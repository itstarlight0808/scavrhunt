<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Huntform (Huntform Controller)
 * Huntform class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 25 February 2021
 */
class Huntform extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('zoomaccount_model');
        $this->load->model('school_model');
        $this->load->model('hunt_model');
        $this->load->model('challenge_model');
        date_default_timezone_set('US/Eastern');
    }

    public function index()
    {
        $huntId = 0;
        $gamecode = "";
        $curChgNum = 0;
        $curChgType = 1;
        $isactive = 0;

        $huntId = $this->session->userdata('huntId');
        $playerId = $this->session->userdata('playerId');
        $teamId = $this->session->userdata('teamId');

        if (isset($_GET["gc"]))
            $gamecode = $_GET["gc"];
        
        if (isset($_POST["inp_cur_chg_num"]))
            $curChgNum = intval($_POST["inp_cur_chg_num"]);

        if (isset($_POST["inp_cur_chg_type"]))
            $curChgType = intval($_POST["inp_cur_chg_type"]);

        if ($gamecode != "")
        {
            if ($huntId != 0)
            {
                $huntInfo = $this->hunt_model->getHuntInfo($huntId);
                if (isset($huntInfo))
                    $isactive = intval($huntInfo->is_active);

                if ($isactive == 0)
                {
                    $this->load->view("scavenger-hunts/hunterror.php");
                }
                else
                {
                    $curDateTime = date("Y-m-d h:m:s");
                    // if($curDateTime > $huntInfo->end_date." ".$huntInfo->end_time)
                    //     redirect('/endHuntGame' . '/?gc=' . $gamecode);
                    // if($curDateTime < $huntInfo->start_date." ".$huntInfo->start_time) {
                    //     $this->load->view("scavenger-hunts/hunterror.php");
                    //     return;
                    // }

                    $chgCount = $this->challenge_model->getChallengeCountByHunt($huntId);
                    if ($chgCount == 0)
                    {
                        $this->load->view("scavenger-hunts/hunterror.php");
                    }
                    else
                    {
                        $checkSubmitted = true;
                        $gameCodeId = 0;
                        while($checkSubmitted)
                        {
                            $gameCodeInfo = $this->hunt_model->getHuntGameCodeInfo($teamId);
                            if (isset($gameCodeInfo))
                                $gameCodeId = intval($gameCodeInfo->id);
                            $curChallenge = $this->challenge_model->getCurrentChallengeByHunt($huntId, $curChgNum);
                            if (isset($curChallenge))
                                $challengeId = $curChallenge->id;
                            else
                                $challengeId = 0;
                            $checkSubmitted = $this->challenge_model->checkAlreadySubmitted($gameCodeId, $challengeId);
                            $curChgNum++;
                        }
                        if ($checkSubmitted == false && $curChgNum == $chgCount + 1)
                        {
                            redirect('/endHuntGame' . '/?gc=' . $gamecode);
                        }
                        else
                        {
                            $curChgNum--;
                            $curChallenge = $this->challenge_model->getCurrentChallengeByHunt($huntId, $curChgNum);
                            $leaderBoard = $this->challenge_model->getLeaderBoardByHunt($huntId, $gameCodeId);
                            if (isset($curChallenge))
                            {
                                $data['gamecode'] = $gamecode;
                                $data['playerId'] = $playerId;
                                $data['huntId'] = $huntId;
                                $data['teamId'] = $teamId;
                                $data['teamName'] = $this->session->userdata('teamName');
                                $data['chgCount'] = $chgCount;
                                $data['curChallenge'] = $curChallenge;
                                $chgType = $this->challenge_model->getChallengeTypeInfo($curChallenge->chg_type_id);
                                $chgTypeName = $chgType->name;
                                $data['chgTypeName'] = $chgTypeName;
                                $data['curChgNum'] = $curChgNum;
                                $data['leaderBoard'] = $leaderBoard;
                                $data['huntInfo'] = $huntInfo;
                                $this->load->view("scavenger-hunts/huntform.php", $data);
                            }
                            else
                            {
                                $this->load->view("scavenger-hunts/hunterror.php");
                            }
                        }
                    }
                }
            }
            else
            {
                $this->load->view("scavenger-hunts/hunterror.php");
            }
        }
        else
        {
            $this->load->view("scavenger-hunts/hunterror2.php");
        }
    }

    public function viewFeedback()
    {
        $gamecode = "";
        $chgNum = 0;
        $huntId = 0;

        if (isset($_GET["gc"]))
            $gamecode = $_GET["gc"];
        
        if (isset($_GET["cn"]))
            $chgNum = intval($_GET["cn"]);
        
        $huntId = intval($this->session->userdata('huntId'));

        if ($gamecode != "" && $huntId > 0)
        {
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $curChallenge = $this->challenge_model->getCurrentChallengeByHunt($huntId, $chgNum);
            if (isset($curChallenge))
            {
                $playerId = intval($this->session->userdata('playerId'));
                $teamId = intval($this->session->userdata('teamId'));

                $gameCodeId = 0;
                $gameCodeInfo = $this->hunt_model->getHuntGameCodeInfo($teamId);
                if (isset($gameCodeInfo))
                    $gameCodeId = intval($gameCodeInfo->id);

                $chgResult = $this->challenge_model->getChallengeResult($gameCodeId, $huntId, intval($curChallenge->id));
                if (isset($chgResult))
                {
                    $data['gamecode'] = $gamecode;
                    $data['playerId'] = $playerId;
                    $data['huntId'] = $huntId;
                    $data['teamId'] = $teamId;
                    $data['teamName'] = $this->session->userdata('teamName');
                    $data['curChallenge'] = $curChallenge;
                    $data['chgResult'] = $chgResult;
                    $data['curChgNum'] = $chgNum;
                    $data['huntInfo'] = $huntInfo;
                    $this->load->view("scavenger-hunts/challengeFeedback.php", $data);
                }
                else
                {
                    $this->load->view("scavenger-hunts/hunterror.php");
                }
            }
            else
            {
                $this->load->view("scavenger-hunts/hunterror.php");
            }
        }
        else
        {
            $this->load->view("scavenger-hunts/hunterror.php");
        }
    }

    public function huntEndForm()
    {
        $huntId = 0;
        $gamecode = "";
        $curChgNum = 0;
        $isactive = 0;

        $huntId = $this->session->userdata('huntId');

        if (isset($_GET["gc"]))
            $gamecode = $_GET["gc"];
        
        if (isset($_POST["inp_cur_chg_num"]))
            $curChgNum = intval($_POST["inp_cur_chg_num"]);

        if ($gamecode != "")
        {
            if ($huntId != 0)
            {
                $huntInfo = $this->hunt_model->getHuntInfo($huntId);
                if (isset($huntInfo))
                    $isactive = intval($huntInfo->is_active);

                if ($isactive == 0)
                {
                    $this->load->view("scavenger-hunts/hunterror.php");
                }
                else
                {
                    $chgCount = $this->challenge_model->getChallengeCountByHunt($huntId);
                    if ($curChgNum == 0)
                        $curChgNum = $chgCount;
                    if ($chgCount == 0)
                    {
                        $this->load->view("scavenger-hunts/hunterror.php");
                    }
                    else
                    {
                        $playerId = $this->session->userdata('playerId');
                        $teamId = $this->session->userdata('teamId');
                        $teamLeaderBoard = $this->challenge_model->getLeaderBoardByTeam($huntId, $teamId);
                        $totalPoints = $this->challenge_model->getTotalPointsByHunt($huntId);

                        $data['gamecode'] = $gamecode;
                        $data['playerId'] = $playerId;
                        $data['huntId'] = $huntId;
                        $data['teamId'] = $teamId;
                        $data['teamName'] = $this->session->userdata('teamName');
                        $data['chgCount'] = $chgCount;
                    
                        $data['curChgNum'] = $curChgNum;
                        $data['huntInfo'] = $huntInfo;
                        $data['teamLeaderBoard'] = $teamLeaderBoard;
                        $data['totalPoints'] = $totalPoints;
                        $this->load->view("scavenger-hunts/huntEndForm.php", $data);
                    }
                }
            }
            else
            {
                $this->load->view("scavenger-hunts/hunterror.php");
            }
        }
        else
        {
            $this->load->view("scavenger-hunts/hunterror2.php");
        }
    }

    public function assignGameCode()
    {
        $huntId = 0;
        if (isset($_GET["hunt"]))
            $huntId = intval($_GET["hunt"]);
        
        $huntId = $this->session->set_userdata('huntId', $huntId);
        $teamId = $this->session->userdata('teamId');
        $gamecode = "";
        $gameCodeInfo = $this->hunt_model->getHuntGameCodeInfo($teamId);
        if (isset($gameCodeInfo))
            $gamecode = $gameCodeInfo->gamecode;
        redirect('/gotoHuntGame' . '/?gc=' . $gamecode);
    }

    public function generateHuntGameCode($teamId)
    {
        return mt_rand(100, 999) . ($teamId * 3) . mt_rand(100, 999);
    }

    public function getHuntGameCode()
    {
        $gamecode = "";
        $teamId = intval($this->input->post('teamId'));
        $gameCodeInfo = $this->hunt_model->getHuntGameCodeInfo($teamId);
        if (isset($gameCodeInfo))
            $gamecode = $gameCodeInfo->gamecode;
        if ($gamecode == "")
        {
            $gamecode = $this->generateHuntGameCode($teamId);
            while ($checksame = $this->hunt_model->getSameGameCode($gamecode))
            {
                $gamecode = $this->generateHuntGameCode($teamId);
            }
            $codeInfo = array(
                'team_id' => $teamId,
                'gamecode' => $gamecode,
                'status_id' => 1
            );
            $result = $this->hunt_model->insertHuntGameCode($codeInfo);
        }
        echo $gamecode;
        exit;
    }

    public function submitAnswer()
    {
        $submitted = date("Y-m-d H:i:s");
        /*$playerId = $this->input->post('playerId');
        $teamId = $this->input->post('teamId');
        $huntId = $this->input->post('huntId');
        $challengeId = $this->input->post('challengeId');
        $imageCaptured = $this->input->post('imageCaptured');
        $inpAnswer = $this->input->post('inpAnswer');*/

        $playerId = $_POST['playerId'];
        $teamId = $_POST['teamId'];
        $huntId = $_POST['huntId'];
        $challengeId = $_POST['challengeId'];
        $imageCaptured = isset($_POST['imageCaptured']) ? $_POST['imageCaptured'] : '';
        $inpAnswer = $_POST['inpAnswer'];

        $points = 0;
        $statusId = 1; // submitted , wating for judgement..
        $chgType = 1;
        $challenge = $this->challenge_model->getChallengeInfo($challengeId);
        if (isset($challenge))
            $chgType = intval($challenge->chg_type_id);
        if ($chgType == 1)
        {
            $chgAnswer = $imageCaptured;
        }
        else if ($chgType == 2 || $chgType == 3)
        {
            $statusId = 2; // auto judged..
            $chgAnswer = $inpAnswer;
            $arr_answers = explode(";", strtolower($challenge->puzzle_answer));
            if (in_array(strtolower($chgAnswer), $arr_answers))
                $points = intval($challenge->points);
        }
        else
        {

        }

        $gameCodeId = 0;
        $gameCodeInfo = $this->hunt_model->getHuntGameCodeInfo($teamId);
        if (isset($gameCodeInfo))
            $gameCodeId = intval($gameCodeInfo->id);

        $checkSubmitted = $this->challenge_model->checkAlreadySubmitted($gameCodeId, $challengeId);
        
        if (!$checkSubmitted)
        {
            $judgeInfos = array(
                'player_id' => $playerId,
                'gamecode_id' => $gameCodeId,
                'hunt_id' => $huntId,
                'chg_id' => $challengeId,
                'chg_result' => $chgAnswer,
                'points' => $points,
                'status_id' => $statusId,
                'submitted' => $submitted
            );
            $result = $this->challenge_model->insertChallengeResult($judgeInfos);
        }
        echo json_encode(["status" => 1, "chgType" => $chgType, "points" => $points]);
        exit;
    }
}