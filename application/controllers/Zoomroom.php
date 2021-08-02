<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 February 2021
 */
class Zoomroom extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('zoomaccount_model');
        $this->load->model('room_model');
        $this->load->model('school_model');
        $this->load->model('team_model');
        $this->load->model('player_model');
        $this->load->model('room_model');
        $this->load->model('hunt_model');
        $this->load->model('challenge_model');
        $this->isLoggedIn();
        //date_default_timezone_set('US/Eastern');
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        
    }

    /**
     * This function is used to load the user list
     */
    public function zoomroomListing($accountId = 1, $accountNo = 1)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $data['accountId'] = $accountId;
            $data['accountNo'] = $accountNo;

            $zoomAccount = $this->zoomaccount_model->getZoomAccountInfo($accountId);
            if (isset($zoomAccount))
                $account_name = $zoomAccount->account_name;
            else
                $account_name = "";
            $data['roomTitle'] = "Zoom Account " . $accountNo . " (" . $account_name . ")";

            $occupiedRooms = array();
            $occupiedStatus = array();
            $roomSchoolIds = array();
            $roomStatusIds = array();

            $ret = array();
            $k = 0;
            
            for ($k=0; $k<50; $k++)
            {
                $roomSchoolIds[$k] = 0;
                $roomStatusIds[$k] = 1;
            }

            $zoomRoomsInAccount = $this->room_model->getRoomSchoolIdsByAccount($accountId);
            foreach($zoomRoomsInAccount as $i => $record)
            {
                $roomSchoolIds[$i] = $record->school_id;
                $roomStatusIds[$i] = $record->status_id;
            }

            $zoomRooms = $this->room_model->getOccupiedRoomsByAccount($accountId);
            foreach ($zoomRooms as $j => $record)
            {
                $occupiedRooms[$j] = $record->room_no;
                $occupiedStatus[$j] = $record->status_id;

                /*
                $tmp = array();
                $tmp = $this->getPlayersByRoomId($record->id);
                $ret = array_merge($ret, $tmp);
                */
            }
            
            $newPlayers = array();
            $m = 0;
            $time1 = strtotime(gmdate("Y-m-d H:i:s", time()-14400));

            $players = $this->player_model->getPlayersByZoomAccount($accountId);
            foreach ($players as $record2)
            {
                $ret[$k]["id"] = $record2->id;
                $ret[$k]["player_name"] = $record2->name;
                $ret[$k]["logged_in"] = substr($record2->logged_in, 0, 16);
                $ret[$k]["school_id"] = $record2->school_id;
                $schoolIds[$k] = $record2->school_id;
                if (intval($record2->school_id) > 0)
                {
                    $school = $this->school_model->getSchoolInfo($record2->school_id);
                    if (isset($school))
                        $ret[$k]["sch_name"] = $school->sch_name;
                    else
                        $ret[$k]["sch_name"] = "";    
                }
                else
                {
                    $ret[$k]["sch_name"] = "";
                }
                $ret[$k]["samedevice"] = "No";
                if (intval($record2->team_id) > 0)
                {
                    $team = $this->team_model->getTeamInfo($record2->team_id);
                    if (isset($team))
                    {
                        $ret[$k]["team_name"] = $team->team_name;
                        $ret[$k]["team_size"] = $team->players_count;
                        $ret[$k]["captain"] = $team->captain;
                        if (intval($team->same_device) == 1)
                            $ret[$k]["samedevice"] = "Yes";
                    }
                    else
                    {
                        $ret[$k]["team_name"] = "";
                        $ret[$k]["team_size"] = "";
                        $ret[$k]["captain"] = "";  
                    }
                }
                else
                {
                    $ret[$k]["team_name"] = "";
                    $ret[$k]["team_size"] = "";
                    $ret[$k]["captain"] = "";
                }
                if (intval($record2->room_id) == 0)
                {
                    $ret[$k]["room_no"] = "X";
                    $ret[$k]["status_id"] = 0;
                }
                else
                {
                    $room = $this->room_model->getRoomInfo($record2->room_id);
                    if (isset($room))
                    {
                        $ret[$k]["room_no"] = intval($room->room_no);
                        $ret[$k]["status_id"] = intval($room->status_id);
                    }
                    else
                    {
                        $ret[$k]["room_no"] = "X";
                        $ret[$k]["status_id"] = 0;
                    }
                }
                $ret[$k]["status_id2"] = intval($record2->status_id);
                $timediff = $time1 - strtotime($record2->logged_in);
                if ($timediff <= 20)
                {
                    $newPlayers[$m] = $record2->name;
                    $m++;
                }
                $k++;
            }

            $ret2 = array();
            for ($k=0; $k<50; $k++)
            {
                $roomId = $this->room_model->getRoomId($accountId, $k+1);
                $ret2[$k] = $this->getTeamsByRoomId($roomId, $schoolIds);
            }

            $data['roomSchoolIds'] = $roomSchoolIds;
            $data['roomStatusIds'] = $roomStatusIds;
            $data['occupiedRooms'] = implode("^", $occupiedRooms);
            $data['occupiedStatus'] = implode("^", $occupiedStatus);
            $data['zoomRooms'] = $ret;
            $data['roomTeams'] = $ret2;
            $data['newPlayers'] = implode(",", $newPlayers);

            $schoolIds = array();
            $schools = $this->school_model->getSchoolsByAccount($accountId);
            $k = 0;
            foreach ($schools as $record)
            {
                $schoolIds[$k] = $record->id;
                $k++;
            }

            $teamIds = array();
            $k = 0;
            if (count($schoolIds) > 0)
            {
                $teams = $this->team_model->getTeamsBySchools($schoolIds);
                foreach ($teams as $record)
                {
                    $teamIds[$k] = $record->id;
                    $k++;
                }
            }

            $huntIds = array();
            $hunts = $this->hunt_model->getActiveHunts($accountId);
            $k = 0;
            foreach ($hunts as $record)
            {
                $huntIds[$k] = $record->id;
                $k++;
            }

            $gameCodeIds = array();
            $k = 0;
            if (count($teamIds) > 0)
            {
                $gameCodes = $this->hunt_model->getGameCodesByTeams($teamIds);
                foreach ($gameCodes as $record)
                {
                    $gameCodeIds[$k] = $record->id;
                    $k++;
                }
            }

            $judgeTeams = $this->challenge_model->getTeamsForJudge($gameCodeIds, $huntIds);

            $judgeTeamInfos = array();
            $k = 0;
            foreach ($judgeTeams as $record)
            {
                $chgCount = $this->challenge_model->getChallengeCountByHunt($record->hunt_id);
                $teamId = $this->hunt_model->getTeamIdByGameCodeId($record->gamecode_id);
                $schoolname = "";
                $teamname = "";
                $teamsize = 0;
                $roomno = 0;
                $samedevice = "No";
                $teamInfo = $this->team_model->getTeamInfo($teamId);
                if (isset($teamInfo))
                {
                    $teamname = $teamInfo->team_name;
                    $teamsize = $teamInfo->players_count;
                    $schoolInfo = $this->school_model->getSchoolInfo($teamInfo->school_id);
                    if (isset($schoolInfo))
                        $schoolname = $schoolInfo->sch_name;
                    if (intval($team->same_device) == 1)
                        $samedevice = "Yes";
                    $roomInfo = $this->room_model->getRoomInfo($teamInfo->room_id);
                    if (isset($roomInfo))
                        $roomno = $roomInfo->room_no;
                }
                $judgeTeamInfos[$k]["team_id"] = $teamId;
                $judgeTeamInfos[$k]["gamecode_id"] = $record->gamecode_id;
                $judgeTeamInfos[$k]["schoolname"] = $schoolname;
                $judgeTeamInfos[$k]["teamname"] = $teamname;
                $judgeTeamInfos[$k]["teamsize"] = $teamsize;
                $judgeTeamInfos[$k]["samedevice"] = $samedevice;
                $judgeTeamInfos[$k]["roomno"] = $roomno;
                $judgeTeamInfos[$k]["hunt_id"] = $record->hunt_id;
                $judgeTeamInfos[$k]["judge_status"] = $record->status < ($chgCount*2) ? 0 : 1;
                $k++;
            }

            $data['judgeTeamInfos'] = $judgeTeamInfos;
            $this->global['pageTitle'] = 'Admin Software : Zoom Room Listing';
            $this->loadViews("zoomrooms", $this->global, $data, NULL);
        }
    }

    public function getPlayersByRoomId($roomId)
    {
        $ret = array();
        $k = 0;
        $players = $this->player_model->getSameRoomPlayers($roomId);
        foreach ($players as $record2)
        {
            $ret[$k]["id"] = $record2->id;
            $ret[$k]["player_name"] = $record2->name;
            $ret[$k]["logged_in"] = substr($record2->logged_in, 0, 16);
            
            if (intval($record2->school_id) > 0)
            {
                $school = $this->school_model->getSchoolInfo($record2->school_id);
                if (isset($school))
                    $ret[$k]["sch_name"] = $school->sch_name;
                else
                    $ret[$k]["sch_name"] = "";
            }
            else
            {
                $ret[$k]["sch_name"] = "";
            }
            $ret[$k]["samedevice"] = "No";
            if (intval($record2->team_id) > 0)
            {
                $team = $this->team_model->getTeamInfo($record2->team_id);
                if (isset($team))
                {
                    $ret[$k]["team_name"] = $team->team_name;
                    $ret[$k]["team_size"] = $team->players_count;
                    $ret[$k]["captain"] = $team->captain;
                    if (intval($team->same_device) == 1)
                        $ret[$k]["samedevice"] = "Yes";
                }
                else
                {
                    $ret[$k]["team_name"] = "";
                    $ret[$k]["team_size"] = "";
                    $ret[$k]["captain"] = "";    
                }
            }
            else
            {
                $ret[$k]["team_name"] = "";
                $ret[$k]["team_size"] = "";
                $ret[$k]["captain"] = "";
            }
            if (intval($record2->room_id) > 0)
            {
                $room = $this->room_model->getRoomInfo($record2->room_id);
                if (isset($room))
                {
                    $ret[$k]["room_no"] = intval($room->room_no);
                    $ret[$k]["status_id"] = intval($room->status_id);
                }
                else
                {
                    $ret[$k]["room_no"] = "X";
                    $ret[$k]["status_id"] = 0;
                }
            }
            else
            {
                $ret[$k]["room_no"] = "X";
                $ret[$k]["status_id"] = 0;
            }
            $k++;
        }
        return $ret;
    }

    public function getTeamsByRoomId($roomId, $schoolIds)
    {
        $ret = array();
        $tmp = array();
        $result = $this->team_model->getTeamsByRoomId($roomId, $schoolIds);
        if (count($result) == 0)
        {
            $ret["id"] = 0;
            $ret["status_id"] = 1;
            $ret["school_id"] = 0;
            $ret["sch_name"] = "";
        }
        else
        {
            $ret["id"] = intval($roomId);
            $ret["sch_name"] = "";
            if (intval($roomId) > 0)
            {
                $room = $this->room_model->getRoomInfo($roomId);
                if (intval($room->school_id) > 0)
                {
                    $school = $this->school_model->getSchoolInfo($room->school_id);
                    if (isset($school))
                        $ret["sch_name"] = "[" . $school->sch_name . "]";
                }
                $ret["status_id"] = intval($room->status_id);
                $ret["school_id"] = intval($room->school_id);
            }
            else
            {
                $ret["status_id"] = 1;
                $ret["school_id"] = 0;
            }
            
            foreach ($result as $j => $record)
            {
                if (intval($record->players_count) == 1)
                {
                    $tmp[$j] = "(" . $record->team_name . " -> " . $record->players_count . ")";
                }
                else
                {
                    $tmp[$j] = "(" . $record->team_name . " -> " . $record->players_count . ", " . $record->captain . ")";
                }        
            }
        }
        $ret["teams"] = implode("<br>", $tmp);
        return $ret;
    }

    public function clearAllRoomData()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $updated = date('Y-m-d H:i:s');

        $zoomRooms = $this->room_model->getOccupiedRoomsByAccount($accountId);
        foreach ($zoomRooms as $record)
        {
            $this->room_model->setRoomVacant($record->id);
            $roomLogs = $this->room_model->getRoomLogs($record->id, $record->status_id);
            foreach ($roomLogs as $record2)
            {
                $infos = array('status_id' => '5', 'room_closed' => $updated);
                $this->room_model->updateRoomLog($infos, $record2->id);
            }
        }

        $players = $this->player_model->getPlayersByZoomAccount($accountId);
        foreach ($players as $record3)
        {
            $infos2 = array('status_id' => '3', 'room_exited' => $updated);
            $this->team_model->updateTeam($infos2, $record3->team_id);
            $infos3 = array('status_id' => '3', 'room_exited' => $updated);
            $this->player_model->updatePlayer($infos3, $record3->id);
        }

        echo "success";
    }

    public function getSameRoomPlayers()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $roomNo = $this->security->xss_clean($this->input->post('roomNo'));

        $roomId = $this->room_model->getRoomId($accountId, $roomNo);
        
        $ret = array();
        $ret = $this->getPlayersByRoomId($roomId);

        echo json_encode($ret);
    }

    public function changePlayerStatus()
    {
        $playerId = $this->security->xss_clean($this->input->post('playerId'));
        $statusId2 = $this->security->xss_clean($this->input->post('statusId2'));

        $nv = 0;
        if (intval($statusId2) == 1)
            $nv = 2;
        else
            $nv = 1;
        
        $updateInfo = array('status_id' => $nv);
        $ret = $this->player_model->updatePlayer($updateInfo, $playerId);
        echo $nv;
    }

    public function movePlayer()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $playerId = $this->security->xss_clean($this->input->post('playerId'));
        $curRoomNo = $this->security->xss_clean($this->input->post('curRoomNo'));
        $roomNo = $this->security->xss_clean($this->input->post('roomNo'));
        $curSchoolId = $this->security->xss_clean($this->input->post('curSchoolId'));
        $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
        $occupiedToSolo = $this->security->xss_clean($this->input->post('occupiedToSolo'));
        $soloToOccupied = $this->security->xss_clean($this->input->post('soloToOccupied'));
        $soloToVacant = $this->security->xss_clean($this->input->post('soloToVacant'));

        //var_dump($occupiedToSolo . " : " . $soloToOccupied . " : " . $soloToVacant);
        //exit;

        $player = $this->player_model->getPlayerInfo($playerId);
        $curTeamId = $player->team_id;
        $curTeam = $this->team_model->getTeamInfo($curTeamId);

        if (intval($curRoomNo) == 0)
        {
            $curRoomId = 0;
            $curStatusId = 1;
        }
        else
        {
            $curRoomId = $this->room_model->getRoomId($accountId, $curRoomNo);
            $curRoom = $this->room_model->getRoomInfo($curRoomId);
            $curStatusId = intval($curRoom->status_id);
        }
        $roomId = $this->room_model->getRoomId($accountId, $roomNo);
        $newRoom = $this->room_model->getRoomInfo($roomId);

        $created = gmdate('Y-m-d H:i:s', time()-14400);
        $updated = gmdate('Y-m-d H:i:s', time()-14400);

        if (intval($schoolId) == 0)
            $schoolId = $player->school_id;

        $curRoomPlayersNum = 0;
        if ($curRoomId != 0)
        {
            $curRoomPlayersNum = $this->player_model->getPlayersNumInRoom($curRoomId, $schoolId);
            if ($curRoomPlayersNum == 1)
            {
                $this->room_model->setRoomVacant($curRoomId);

                if (intval($occupiedToSolo) == 1 || intval($soloToOccupied) == 1)
                {
                    $updateInfo = array('status_id' => '3', 'room_exited' => $updated);
                    $this->team_model->updateTeam($updateInfo, $curTeamId);
                }

                if (intval($curTeam->players_count) > 2)
                {
                    $curLogId = $this->room_model->getRoomLogId2($curRoomId, $curTeamId);
                    $updateInfo3 = array('status_id' => '5', 'room_closed' => $updated);
                    $this->room_model->updateRoomLog($updateInfo3, $curLogId);
                }
            }
        }
        if (intval($occupiedToSolo) == 1)
        {
            $teamInfo = array(
                'school_id' => $player->school_id,
                'team_name' => 'Solo Team',
                'players_count' => 1,
                'same_device' => 0,
                'room_id' => $roomId,
                'captain' => '',
                'members' => '',
                'status_id' => 1,
                'created' => $created,
                'room_exited' => NULL
            );
            $teamId = $this->team_model->addNewTeam($teamInfo);

            $updateInfo = array('team_id' => $teamId, 'room_id' => $roomId/*, 'logged_in' => $created*/);
            $ret = $this->player_model->updatePlayer($updateInfo, $playerId);

            $roomLogInfo = array(
                'room_id' => $roomId,
                'school_id' => $player->school_id,
                'team_id' => $teamId,
                'status_id' => '3',
                'room_closed' => NULL
                );
            
            $insLogId = $this->room_model->searchSameRoomLog($roomId, $teamId, '3');
            if ($insLogId == "0")
                $insLogId = $this->room_model->addNewRoomLog($roomLogInfo);
            
            if (intval($newRoom->status_id) == 1)
                $this->room_model->setRoomSoloVacant($roomId, $player->school_id);
        }
        else if (intval($soloToOccupied) == 1)
        {
            $teamId = $this->room_model->getTeamIdByRoomId($roomId);

            if (intval($teamId) == 0)
            {    
                $updateInfo = array('room_id' => $roomId/*, 'logged_in' => $created*/);
                $ret = $this->player_model->updatePlayer($updateInfo, $playerId);
                $ret2 = $this->team_model->updateTeam($updateInfo, $player->team_id);
            }
            else
            {
                $updateInfo = array('team_id' => $teamId, 'room_id' => $roomId/*, 'logged_in' => $created*/);
                $ret = $this->player_model->updatePlayer($updateInfo, $playerId);
            }
            
            $curTeamPlayers = $curTeam->players_count;

            if (intval($curTeamPlayers) > 2)
                $this->room_model->setRoomOccupied($roomId, $player->school_id);
        }
        else if (intval($soloToVacant) == 1)
        {
            $this->room_model->setRoomSoloVacant($roomId, $player->school_id);

            $updateInfo = array('room_id' => $roomId);
            $ret = $this->team_model->updateTeam($updateInfo, $curTeamId);

            $updateInfo2 = array('room_id' => $roomId/*, 'logged_in' => $created*/);
            $ret2 = $this->player_model->updatePlayer($updateInfo2, $playerId);

            if ($curRoomNo != 0)
            {
                $updateInfo3 = array('room_id' => $roomId);
                $logId = $this->room_model->getRoomLogId2($curRoomId, $curTeamId);
                
                $ret2 = $this->room_model->updateRoomLog($updateInfo3, $logId);
            }
            else
            {
                $roomLogInfo = array(
                    'room_id' => $roomId,
                    'school_id' => $player->school_id,
                    'team_id' => $teamId,
                    'status_id' => '3',
                    'room_closed' => NULL
                    );
                
                $insLogId = $this->room_model->searchSameRoomLog($roomId, $teamId, '3');
                if ($insLogId == "0")
                    $insLogId = $this->room_model->addNewRoomLog($roomLogInfo);
            }
        }
        else
        {
            /*if ($curStatusId == 4)
                $this->room_model->setSoloRoomClosed($roomId, $player->school_id);*/
            
            if (intval($newRoom->status_id) == 3)
                $this->room_model->setRoomSoloVacant($roomId, $player->school_id);
            else
                $this->room_model->setRoomOccupied($roomId, $player->school_id);
                
            $updateInfo = array('room_id' => $roomId/*, 'logged_in' => $created*/);
            $ret = $this->player_model->updatePlayer($updateInfo, $playerId);
            
            $ret2 = $this->team_model->updateTeam($updateInfo, $curTeamId);

            $updateInfo3 = array('room_id' => $roomId);
            $logId = $this->room_model->getRoomLogId2($curRoomId, $curTeamId);
            $ret2 = $this->room_model->updateRoomLog($updateInfo3, $logId);
        }

        echo "success";
    }

    public function setRoomVacant()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $roomNo = $this->security->xss_clean($this->input->post('roomNo'));

        $roomId = $this->room_model->getRoomId($accountId, $roomNo);
        $this->room_model->setRoomVacant($roomId);

        $updated = date('Y-m-d H:i:s');
        $teams = $this->room_model->getTeamsByRoomId($roomId);
        foreach ($teams as $team)
        {
            $updateInfo = array('room_id' => 0);
            $this->team_model->updateTeam($updateInfo, $team->team_id);
        }

        $players = $this->player_model->getSameRoomPlayers($roomId);
        foreach ($players as $player)
        {
            $updateInfo2 = array('room_id' => 0/*, 'logged_in' => $updated*/);
            $this->player_model->updatePlayer($updateInfo2, $player->id);
        }

        $this->room_model->deleteRoomLogByRoomId($roomId);
    }

    public function setSoloRoomClosed()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $roomNo = $this->security->xss_clean($this->input->post('roomNo'));
        $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
        $statusId = $this->security->xss_clean($this->input->post('statusId'));

        $roomId = $this->room_model->getRoomId($accountId, $roomNo);
        $this->room_model->setSoloRoomClosed($roomId, $schoolId);
    }

    public function setRoomNeedHelp()
    {
        $accountId = $this->security->xss_clean($this->input->post('accountId'));
        $roomNo = $this->security->xss_clean($this->input->post('roomNo'));
        $chkHelp = $this->security->xss_clean($this->input->post('chkHelp'));
        $roomId = $this->room_model->getRoomId($accountId, $roomNo);
        $this->room_model->setRoomNeedHelp($roomId, $chkHelp);
    }

    public function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {   
            $zoomAccountCount = $this->zoomaccount_model->getZoomAccountCount();
            if ($zoomAccountCount == 0)
            {
                $this->session->set_flashdata('error', 'There is no Zoom account.');
                redirect('/zoomRoomListing');
            }
            else 
            {
                $allZoomAccounts = $this->zoomaccount_model->getAllZoomAccounts();
                $data['allZoomAccounts'] = $allZoomAccounts;

                $this->global['pageTitle'] = 'Team Building : Add New Zoom Room';
                $this->loadViews("addNewZoomRoom", $this->global, $data, NULL);
            }
        }
    }

    public function addNewZoomRoom()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('statusId','Status','trim|required|max_length[255]');
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $statusId = $this->security->xss_clean($this->input->post('statusId'));
                $roomInfo = array('status_id'=>$statusId, 'created'=>date('Y-m-d H:i:s'));
                $this->load->model('room_model');
                $result = $this->room_model->addNewZoomRoom($roomInfo);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New zoom room created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zoom room creation failed');
                }
                redirect('/addNewZoomRoom');
            }
        }
    }

    public function editOld($roomId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($roomId == null)
            {
                redirect('/zoomRoomListing');
            }
            $data['zoomRoomInfo'] = $this->room_model->getZoomRoomInfo($roomId);
            $this->global['pageTitle'] = 'Team Building : Edit Zoom Room';
            $this->loadViews("editZoomRoom", $this->global, $data, NULL);
        }
    }

    public function editZoomRoom()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $roomId = $this->input->post('roomId');
            $accountId = $this->input->post('accountId');
            
            $this->form_validation->set_rules('statusId','Status','trim|required|max_length[256]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($roomId);
            }
            else
            {
                //$statusId = ucwords(strtolower($this->security->xss_clean($this->input->post('statusId'))));
                $statusId = $this->security->xss_clean($this->input->post('statusId'));
                $roomInfo = array('status_id'=>$statusId);
                                
                $result = $this->room_model->editZoomRoom($roomInfo, $roomId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('cur_account_id', $accountId);
                    $this->session->set_flashdata('success', 'Zoom room updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zoom room update failed');
                }
                
                redirect('/zoomRoomListing');
            }
        }
    }
}