<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Entryform (Entryform Controller)
 * Entryform class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 25 February 2021
 */
class Entryform extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('player_model');
        $this->load->model('school_model');
        $this->load->model('team_model');
        $this->load->model('room_model');
        $this->load->model('hunt_model');
        //$this->load->model('Entryform_model');
        date_default_timezone_set('US/Eastern');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $curSchoolId = 0;
        if (isset($_GET["school"]))
            $curSchoolId = intval($_GET["school"]);
        
        $allSchools = $this->school_model->getAllSchools();
        $strStdIdRequired = "";
        $arrStdIdRequired = array();
        if (count($allSchools) > 0)
        {
            foreach ($allSchools as $k => $school)
            {
                $arrStdIdRequired[$k] = $school->std_id_required;
            }
            $strStdIdRequired = implode("^", $arrStdIdRequired);
        }

        $data['curSchoolId'] = $curSchoolId;
        $data['allSchools'] = $allSchools;
        $data['stdIdRequired'] = $strStdIdRequired;
        $this->load->view("entryform.php", $data);
    }

    public function canRegisterForHunt() {
        $schoolId = $_REQUEST["schoolId"];
        $recentHunts = $this->hunt_model->getActiveHuntsSortedByDate($schoolId);
        if(!count($recentHunts)){
            echo json_encode(["status" => 0, "msg" => "No Available Hunts!"]);
            return;
        }
        $hunt = $recentHunts[0];
        $curDate = date("Y-m-d");
        $curTime = date("H:i:s");

        if($curDate < $hunt->start_date){
            echo json_encode(
                [
                    "status" => 0,
                    "msg" => "Current Time : ".$curDate." ".$curTime
                             ."<br>New Hunt Game will be started from ".$hunt->start_date." ". $hunt->start_time
            ]);
            return;
        }
        if($curDate == $hunt->start_date){
            $curTimeStamp = explode(":", $curTime);
            $curTimeStamp = intval($curTimeStamp[0])*3600+intval($curTimeStamp[1])*60+intval($curTimeStamp[2]);
            $startTimeStamp = explode(":", $hunt->start_time);
            $startTimeStamp = intval($startTimeStamp[0])*3600+intval($startTimeStamp[1])*60+intval($startTimeStamp[2]);
            $offset = $startTimeStamp - $curTimeStamp ;
            if(floor($offset/60) > 30){ // team/player can register the new hunt before 30 mins
                echo json_encode(
                    [
                        "status" => 0,
                        "msg" => "Current Time : ".$curDate." ".$curTime
                                 ."<br>New Hunt Game will be started from ".$hunt->start_date." ". $hunt->start_time
                ]);
                return;
            }
        }
        echo json_encode(["status" => 1, "msg" => ""]);
    }
    public function searchTeam($step = 1)
    {
        //$created = gmdate('Y-m-d H:i:s', time()-14400);
        $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
        $this->session->set_userdata('schoolId', $schoolId);

        $recentHunts = $this->hunt_model->getActiveHuntsSortedByDate($schoolId);
        $hunt = $recentHunts[0];
        $curDate = date("Y-m-d");
        $curTime = date("H:i:s");

        $curTimeStamp = explode(":", $curTime);
        $curTimeStamp = intval($curTimeStamp[0])*3600+intval($curTimeStamp[1])*60+intval($curTimeStamp[2]);
        $startTimeStamp = explode(":", $hunt->start_time);
        $startTimeStamp = intval($startTimeStamp[0])*3600+intval($startTimeStamp[1])*60+intval($startTimeStamp[2]);
        $endTimeStamp = explode(":", $hunt->end_time);
        $endTimeStamp = intval($endTimeStamp[0])*3600+intval($endTimeStamp[1])*60+intval($endTimeStamp[2]);

        $remainTime = $startTimeStamp - $curTimeStamp;
        if($curDate == $hunt->start_date && $remainTime > 0)
            $data["hunt_status"] = "Ready";
        if(($curDate == $hunt->start_date && $remainTime <= 0) || $curDate > $hunt->start_date){
            $data["hunt_status"] = "Started";
            $remainTime = $endTimeStamp - $curTimeStamp;
        }
        if(($curDate > $hunt->end_date) || ($curDate == $hunt->end_date && $remainTime < 0))
            $data["hunt_status"] = "Ended";
        $data["remainTime"] = $remainTime;
        $data["huntInfo"] = $hunt;

        $created = date('Y-m-d H:i:s');
        $fullname = $this->security->xss_clean($this->input->post('fullname'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $stdId = $this->security->xss_clean($this->input->post('studentId'));

        $school = $this->school_model->getSchoolInfo($schoolId);
        $zoomAccountId = $school->zoom_account_id;
        if ($step == 1)
            $playersNum = $this->security->xss_clean($this->input->post('playersId'));
        else
            $playersNum = $this->security->xss_clean($this->input->post('playersNum'));

        $loggedbefore = $this->security->xss_clean($this->input->post('loggedbefore'));
        if (!isset($loggedbefore))
            $loggedbefore = 0;
        
        if (intval($playersNum) == 1)
        {
            $samedevice = "0";
            $teamname = "Solo Team";
            $teamcaptain = "";
            $teammembers = "";
        }
        else
        {
            $samedevice = $this->security->xss_clean($this->input->post('samedevice'));
            $teamname = $this->security->xss_clean($this->input->post('teamname'));
            $teamcaptain = $this->security->xss_clean($this->input->post('teamcaptain'));
            $teammembers = $this->security->xss_clean($this->input->post('teammembers'));
        }

        if ($step == 1)
        {
            $samePlayer = $this->player_model->searchSamePlayer(/*$fullname, */$email, $schoolId);
            if ($samePlayer == "0")
            {
                $playerInfo = array(
                    'name' => $fullname,
                    'email' => $email,
                    'std_id_req' => $stdId,
                    'school_id' => $schoolId,
                    'team_id' => 0,
                    'room_id' => 0,
                    'game_link' => $school->zoom_link,
                    'status_id' => 1,
                    'logged_in' => $created,
                    'room_exited' => NULL
                );
                $newPlayer = $this->player_model->addNewPlayer($playerInfo);
                $data["playerId"] = $newPlayer;
                $loggedbefore = 0;
            }
            else
            {
                $data["playerId"] = $samePlayer;
                $loggedbefore = 1;
            }
        }
        else
        {
            $playerId = $this->security->xss_clean($this->input->post('playerId'));
            $data["playerId"] = $playerId;
        }

        $data["fullname"] = $fullname;
        $data["schoolId"] = $schoolId;
        $data["teamname"] = $teamname;
        $data["playersNum"] = intval($playersNum);
        $data["samedevice"] = $samedevice;
        $data["teamcaptain"] = $teamcaptain;
        $data["teammembers"] = $teammembers;
        $data["loggedbefore"] = $loggedbefore;

        //$result = $this->team_model->searchTeam(intval($step), $fullname, $schoolId, $playersNum, $teamname, $teamcaptain, $teammembers);
        $result = array();

        while (count($result) == 0)
        {
            if ($step > 3)
                break;
            $result = $this->team_model->searchTeam($step, $fullname, $schoolId, intval($playersNum), $teamname, $teamcaptain, $teammembers);
            $step++;
        }
        
        $data["matchTeams"] = $result;
        if(count($result) == 1){
            $this->assignRoom($data["playerId"], $result[0]->id, $data);
            return;
        }
        if ($step == 2)
            $this->load->view("matchteams1.php", $data);
        if ($step == 3)
            $this->load->view("matchteams2.php", $data);
        if ($step == 4)
        {
            if (count($result) == 0)
                $this->assignRoom($data["playerId"], "0", $data);
            else
                $this->load->view("matchteams3.php", $data);
        }
    }

    public function selectTeam()
    {
        $schoolId = $this->session->userdata('schoolId');

        $recentHunts = $this->hunt_model->getActiveHuntsSortedByDate($schoolId);
        $hunt = $recentHunts[0];
        $curDate = date("Y-m-d");
        $curTime = date("H:i:s");

        $curTimeStamp = explode(":", $curTime);
        $curTimeStamp = intval($curTimeStamp[0])*3600+intval($curTimeStamp[1])*60+intval($curTimeStamp[2]);
        $startTimeStamp = explode(":", $hunt->start_time);
        $startTimeStamp = intval($startTimeStamp[0])*3600+intval($startTimeStamp[1])*60+intval($startTimeStamp[2]);
        $endTimeStamp = explode(":", $hunt->end_time);
        $endTimeStamp = intval($endTimeStamp[0])*3600+intval($endTimeStamp[1])*60+intval($endTimeStamp[2]);

        $remainTime = $startTimeStamp - $curTimeStamp;
        if($curDate == $hunt->start_date && $remainTime > 0)
            $data["hunt_status"] = "Ready";
        if(($curDate == $hunt->start_date && $remainTime <= 0) || $curDate > $hunt->start_date){
            $data["hunt_status"] = "Started";
            $remainTime = $endTimeStamp - $curTimeStamp;
        }
        if(($curDate > $hunt->end_date) || ($curDate == $hunt->end_date && $remainTime < 0))
            $data["hunt_status"] = "Ended";
        $data["remainTime"] = $remainTime;
        $data["huntInfo"] = $hunt;

        $playerId = $this->security->xss_clean($this->input->post('playerId'));
        $selTeamId = $this->security->xss_clean($this->input->post('selTeamId'));
        
        $data["playersNum"] = $this->security->xss_clean($this->input->post('playersNum'));
        $data["samedevice"] = $this->security->xss_clean($this->input->post('samedevice'));
        $data["teamname"] = $this->security->xss_clean($this->input->post('teamname'));
        $data["teamcaptain"] = $this->security->xss_clean($this->input->post('teamcaptain'));
        $data["teammembers"] = $this->security->xss_clean($this->input->post('teammembers'));
        $data["loggedbefore"] = $this->security->xss_clean($this->input->post('loggedbefore'));
        $this->assignRoom($playerId, $selTeamId, $data);
    }

    public function assignRoom($playerId, $selTeamId, $data)
    {
        $ret = array();
        $player = $this->player_model->getPlayerInfo($playerId);
        $school = $this->school_model->getSchoolInfo($player->school_id);
        $zoomAccountId = $school->zoom_account_id;
        $schoolId = $player->school_id;
        
        //$schoolId = $this->security->xss_clean($this->input->post('schoolId'));

        $playersNum = $this->security->xss_clean($this->input->post('playersNum'));
        if ($playersNum == "")
        {
            $playersNum = $data["playersNum"];
            $samedevice = $data["samedevice"];
            $teamname = $data["teamname"];
            $teamcaptain = $data["teamcaptain"];
            $teammembers = $data["teammembers"];
        }
        else
        {
            $samedevice = $this->security->xss_clean($this->input->post('samedevice'));
            $teamname = $this->security->xss_clean($this->input->post('teamname'));
            $teamcaptain = $this->security->xss_clean($this->input->post('teamcaptain'));
            $teammembers = $this->security->xss_clean($this->input->post('teammembers'));
        }

        $loggedbefore = $data["loggedbefore"];
        if ($loggedbefore == 1)
            $selTeamId = $player->team_id;
        
        $assignedRoomId = $player->room_id;

        //$created = gmdate('Y-m-d H:i:s', time()-14400);
        $created = date('Y-m-d H:i:s');
        
        if (intval($selTeamId) == 0)
        {
            if (intval($assignedRoomId) == 0)
            {
                if ($playersNum <= 2)
                {
                    $assignedRoomId = $this->room_model->assignAutoSoloVacantRoom($zoomAccountId, $schoolId, intval($playersNum));
                }
                else
                {
                    $assignedRoomId = $this->room_model->assignAutoVacantRoom($zoomAccountId, $schoolId, intval($playersNum));    
                }
            }    
            if ($teamname == "" && intval($playersNum) == 1)
                $teamname = "Solo Team";
            if (intval($loggedbefore) == 0)
            {    
                $teamInfo = array(
                    'school_id' => $schoolId,
                    'team_name' => $teamname,
                    'players_count' => $playersNum,
                    'same_device' => $samedevice,
                    'room_id' => $assignedRoomId,
                    'captain' => $teamcaptain,
                    'members' => $teammembers,
                    'status_id' => 1,
                    'created' => $created,
                    'room_exited' => NULL
                );
                $insId = $this->team_model->addNewTeam($teamInfo);
                $selTeamId = $insId;
            }
        }
        else
        {
            $teamInfo = $this->team_model->getTeamInfo($selTeamId);
            $assignedRoomId = $teamInfo->room_id;
            if (intval($playersNum) > intval($teamInfo->players_count))
            {
                $updateTeamInfo = array(
                    'players_count' => intval($playersNum),
                    'room_id' => $assignedRoomId,
                    'members' => $teammembers    
                );
                $this->team_model->updateTeam($updateTeamInfo, $selTeamId);
            }
        }

        $updatePlayerInfo = array(
            'team_id' => $selTeamId,
            'room_id' => $assignedRoomId
            );
        $this->player_model->updatePlayer($updatePlayerInfo, $playerId);
        $roomInfo = $this->room_model->getRoomInfo($assignedRoomId);
        
        $roomLogInfo = array(
            'room_id' => $assignedRoomId,
            'school_id' => $player->school_id,
            'team_id' => $selTeamId,
            'status_id' => $roomInfo->status_id,
            'room_closed' => NULL
            );
        
        $insRoomId = $this->room_model->searchSameRoomLog($assignedRoomId, $selTeamId, $roomInfo->status_id);
        if (intval($insRoomId) == 0)
            $insRoomId = $this->room_model->addNewRoomLog($roomLogInfo);

        $this->session->set_userdata('playerId', $playerId);
        $this->session->set_userdata('playerName', $player->name);
        $this->session->set_userdata('teamId', $selTeamId);
        $this->session->set_userdata('teamName', $teamname);
        $this->session->set_userdata('schoolId', $schoolId);

        if (intval($assignedRoomId) == 0)
        {
            $roomMates = array();
        }
        else
        {
            $roomMates = $this->player_model->getSameRoomPlayers($assignedRoomId);
            if (count($roomMates) > 0)
            {
                $k = 0;
                foreach ($roomMates as $record)
                {
                    $teamInfo = $this->team_model->getTeamInfo($record->team_id);
                    $roomInfo = $this->room_model->getRoomInfo($record->room_id);
                    $ret[$k]["id"] = $record->id;
                    $ret[$k]["playername"] = $record->name;
                    $ret[$k]["teamname"] = $teamInfo->team_name;
                    $ret[$k]["captain"] = $teamInfo->captain;
                    $ret[$k]["roomno"] = $roomInfo->room_no;
                    $ret[$k]["gamelink"] = base_url()."gotoHunt/?hunt=".$data["huntInfo"]->id;
                    $k++;
                }
            }
        }

        $data["roomMates"] = $ret;
        $data["teamId"] = $selTeamId;
        $this->load->view("assignedroom.php", $data);
    }

}