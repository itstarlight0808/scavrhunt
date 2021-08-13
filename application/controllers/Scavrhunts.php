<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Scavrhunts (Scavrhunts Controller)
 * Scavrhunts class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 25 February 2021
 */
class Scavrhunts extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('zoomaccount_model');
        $this->load->model('school_model');
        $this->load->model('player_model');
        $this->load->model('team_model');
        $this->load->model('hunt_model');
        $this->load->model('challenge_model');
        $this->isLoggedIn();
        date_default_timezone_set('US/Eastern');
    }
    public function isJudgeGamesForCheck(){
        $res = $this->challenge_model->isJudgeGamesForCheck();
        if(intval($res[0]->count) > 0)
            echo json_encode(array('isExist'=>1));
        else
            echo json_encode(array("isExist"=>0));
    }
    public function getOldestSubmittedChallenge(){
        $res = $this->challenge_model->getOldestSubmittedChallenge();
        echo json_encode(["data" => $res]);
    }
    public function manage($schoolId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $allSchools = $this->school_model->getAllSchools();
            //$schoolId = $this->security->xss_clean($this->input->post('schoolId'));
            if (intval($schoolId) == 1)
            {
                if (count($allSchools) == 0)
                    $schoolId = "0";
            }
            $data['schoolId'] = $schoolId;

            if (count($allSchools) > 0)
            {
                $data['allSchools'] = $allSchools;
                if ($schoolId == "0")
                    $data['huntInfos'] = $this->getAllHuntInfos();
                else
                    $data['huntInfos'] = $this->getHuntInfosBySchool($schoolId);
            }
            else
            {
                $data['allSchools'] = array();
                $data['huntInfos'] = array();
            }

            $this->global['pageTitle'] = 'Admin Software : Manage Scavenger Hunt';        
            $this->loadViews("scavenger-hunts/manage", $this->global, $data, NULL);
        //}
    }

    public function getAllHuntInfos()
    {
        $ret = array();

        $allSchools = $this->school_model->getAllSchools();
        foreach ($allSchools as $school)
        {
            $tmp = $this->getHuntInfosBySchool($school->id);
            $ret = array_merge($ret, $tmp);
        }

        return $ret;
    }

    public function getHuntInfosBySchool($schoolId)
    {
        $ret = array();
        $k = 0;

        $sch_name = "";
        $school = $this->school_model->getSchoolInfo($schoolId);
        if (isset($school))
            $sch_name = $school->sch_name;

        $huntInfos = $this->hunt_model->getHuntInfosBySchool($schoolId);
            
        if (count($huntInfos) > 0)
        {
            foreach ($huntInfos as $record)
            {
                $ret[$k]["id"] = $record->id;
                $ret[$k]["schoolname"] = $sch_name;
                $ret[$k]["headerImg"] = $record->hunt_logo2;
                $ret[$k]["huntname"] = $record->hunt_name;
                $ret[$k]["isactive"] = $record->is_active;
                $huntType = $this->hunt_model->getTypeInfo($record->type_id);
                $ret[$k]["typeId"] = $record->type_id;
                $ret[$k]["typename"] = $huntType->name;
                $huntDelivery = $this->hunt_model->getDeliveryInfo($record->delivery_id);
                $ret[$k]["deliveryId"] = $record->delivery_id;
                $ret[$k]["deliveryname"] = $huntDelivery->name;
                $ret[$k]["startDay"] = $record->start_date;
                $ret[$k]["startTime"] = $record->start_time;
                $ret[$k]["endDay"] = $record->end_date;
                $ret[$k]["endTime"] = $record->end_time;
                $ret[$k]["maxTime"] = $record->max_time;
                $k++;
            }
        }

        return $ret;
    }

    public function addHunt()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntTypes = $this->hunt_model->getAllHuntTypes();
            $huntDelivery = $this->hunt_model->getAllHuntDelivery();
            $schools = $this->school_model->getAllSchools();

            $data['huntTypes'] = $huntTypes;
            $data['huntDelivery'] = $huntDelivery;
            $data['schools'] = $schools;

            $this->global['pageTitle'] = 'Scavenger Hunts : Create a New Hunt';
            $this->loadViews("scavenger-hunts/addNewHunt", $this->global, $data, NULL);
        //}
    }

    public function uploadLogo()
    {
        $target_dir = "assets/uploads/logo2/";
        $target_file = $target_dir . basename($_FILES["huntlogo"]["name"]);
        if ($_FILES["huntlogo"]["name"] == "")
        {
            return array("", "");
        }
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $huntlogoname = basename($_FILES["huntlogo"]["name"]);
        $target_file = $target_dir . base64_encode(basename($_FILES["huntlogo"]["name"])) . "." . $imageFileType;
        $huntlogoname2 = base64_encode(basename($_FILES["huntlogo"]["name"])) . "." . $imageFileType;
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["huntlogo"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file);
            //echo "Sorry, file already exists.";
            $uploadOk = 1;
        }

        // Check file size
        if ($_FILES["huntlogo"]["size"] > 5000000) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            return NULL;
        } else {            
            if (move_uploaded_file($_FILES["huntlogo"]["tmp_name"], $target_file)) {
                //echo "The file ". htmlspecialchars( basename( $_FILES["huntlogo"]["name"])). " has been uploaded.";
                return array($huntlogoname, $huntlogoname2);
            } else {
                //echo "Sorry, there was an error uploading your file.";
                return NULL;
            }
        }
    }

    public function insertHunt()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('huntname','Hunt Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('startDay','Start Day','trim|required');
            $this->form_validation->set_rules('startTime','Start Time','trim|required');
            $this->form_validation->set_rules('endDay','End Day','trim|required');
            $this->form_validation->set_rules('endTime','End Time','trim|required');
            $this->form_validation->set_rules('maxTime','Maximum Time','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addHunt();
            }
            else
            {                
                $huntname = $this->security->xss_clean($this->input->post('huntname'));
                $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
                $isactive = $this->security->xss_clean($this->input->post('isactive'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));
                $deliveryId = $this->security->xss_clean($this->input->post('deliveryId'));
                $startDay = $this->security->xss_clean($this->input->post('startDay'));
                $startTime = $this->security->xss_clean($this->input->post('startTime'));
                $endDay = $this->security->xss_clean($this->input->post('endDay'));
                $endTime = $this->security->xss_clean($this->input->post('endTime'));
                $maxTime = $this->security->xss_clean($this->input->post('maxTime'));

                $arr_huntlogo = $this->uploadLogo();
                $huntlogo = $arr_huntlogo[0];
                $huntlogo2 = $arr_huntlogo[1];

                $school = $this->school_model->getSchoolInfo($schoolId);
                $accountId = $school->zoom_account_id;

                $huntInfo = array(
                    'hunt_name'=>$huntname, 
                    'hunt_logo'=>$huntlogo, 
                    'hunt_logo2'=>$huntlogo2, 
                    'zoom_account_id'=>$accountId,
                    'school_id'=>$schoolId, 
                    'is_active'=>$isactive,
                    'type_id'=>$typeId, 
                    'delivery_id'=>$deliveryId, 
                    'start_date'=>$startDay,
                    'start_time' =>$startTime, 
                    'end_date'=>$endDay,
                    'end_time'=>$endTime,
                    'max_time'=>$maxTime,
                    'status_id'=>1,
                    'created'=>date('Y-m-d H:i:s'),
                    'deleted'=>NULL
                );
                
                $this->load->model('hunt_model');
                $nId = $this->hunt_model->insertHunt($huntInfo);
                
                if(intval($nId) > 0)
                {
                    $this->session->set_flashdata('success', 'New Hunt created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Hunt creation failed');
                }
                
                redirect('/gotoHuntDetails' . '/' . $nId);
            }
        //}
    }

    public function gotoHuntDetails($huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntTypes = $this->hunt_model->getAllHuntTypes();
            $huntDelivery = $this->hunt_model->getAllHuntDelivery();
            $schools = $this->school_model->getAllSchools();
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;

            $data['huntTypes'] = $huntTypes;
            $data['huntDelivery'] = $huntDelivery;
            $data['schools'] = $schools;
            $data['huntInfo'] = $huntInfo;

            $this->global['pageTitle'] = 'Scavenger Hunts : Edit Hunt Details';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            
            $this->loadViews2("scavenger-hunts/huntDetails", $this->global, $data, NULL);
        //}
    }

    public function editHunt()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $updated = date('Y-m-d H:i:s');
            $this->load->library('form_validation');

            $huntId = $this->input->post('huntId');
            $oldHuntInfo = $this->hunt_model->getHuntInfo($huntId);

            $this->form_validation->set_rules('huntname','Hunt Name','trim|required|max_length[255]');
            if($this->form_validation->run() == FALSE)
            {
                $this->gotoHuntDetails($huntId);
            }
            else
            {
                $huntname = $this->security->xss_clean($this->input->post('huntname'));
                $isactive = $this->security->xss_clean($this->input->post('isactive'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));
                $deliveryId = $this->security->xss_clean($this->input->post('deliveryId'));
                $startDay = $this->security->xss_clean($this->input->post('startDay'));
                $startTime = $this->security->xss_clean($this->input->post('startTime'));
                $endDay = $this->security->xss_clean($this->input->post('endDay'));
                $endTime = $this->security->xss_clean($this->input->post('endTime'));
                $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
                $maxTime = $this->security->xss_clean($this->input->post('maxTime'));

                $arr_huntlogo = $this->uploadLogo();
                $huntlogo = $arr_huntlogo[0];
                $huntlogo2 = $arr_huntlogo[1];

                $accountId = 0;
                $school = $this->school_model->getSchoolInfo($schoolId);
                if (isset($school))
                    $accountId = $school->zoom_account_id;
                
                if ($huntlogo != "")
                {
                    $huntInfo = array('hunt_name'=>$huntname, 
                                    'hunt_logo'=>$huntlogo, 
                                    'hunt_logo2'=>$huntlogo2, 
                                    'zoom_account_id'=>$accountId,
                                    'school_id'=>$schoolId,
                                    'is_active'=>$isactive,
                                    'type_id'=>$typeId,
                                    'delivery_id'=>$deliveryId,
                                    'start_date'=>$startDay,
                                    'start_time'=>$startTime,
                                    'end_date'=>$endDay,
                                    'end_time'=>$endTime,
                                    'max_time'=>$maxTime,
                                    'created'=>$updated
                                );
                }
                else
                {
                    $huntInfo = array('hunt_name'=>$huntname, 
                                    'zoom_account_id'=>$accountId,
                                    'school_id'=>$schoolId,
                                    'is_active'=>$isactive,
                                    'type_id'=>$typeId,
                                    'delivery_id'=>$deliveryId,
                                    'start_date'=>$startDay,
                                    'start_time'=>$startTime,
                                    'end_date'=>$endDay,
                                    'end_time'=>$endTime,
                                    'max_time'=>$maxTime,
                                    'created'=>$updated
                                );
                }

                $this->load->model('hunt_model');
                $result = $this->hunt_model->editHunt($huntInfo, $huntId);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'The hunt updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Hunt update failed');
                }
                
                redirect('/gotoHuntDetails' . '/' . $huntId);
            }
        //}
    }

    public function manageChallenges($huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();
            $challenges = array();
            
            $ret = $this->challenge_model->getChallengesByHunt($huntId);
            if (count($ret) > 0)
            {
                foreach ($ret as $k => $record)
                {
                    $challenges[$k]["id"] = $record->id;
                    $challenges[$k]["challengename"] = $record->chg_name;
                    $challenges[$k]["description"] = $record->description;
                    $challenges[$k]["points"] = $record->points;
                    $challenges[$k]["puzzlepage"] = $record->puzzle_page;
                    $chgType = $this->challenge_model->getChallengeTypeInfo($record->chg_type_id);
                    $challenges[$k]["typeId"] = $record->chg_type_id;
                    $challenges[$k]["challengetype"] = $chgType->name;
                    $challenges[$k]["challengeImage"] = $record->chg_image2;
                    $challenges[$k]["challengelink"] = $record->chg_link;
                }
            }
            $data['challengesTypes'] = $challengeTypes;
            $data['challenges'] = $challenges;
            $this->global['pageTitle'] = 'Scavenger Hunts : Challenges';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/manageChallenges", $this->global, $data, NULL);
        //}
    }

    public function addChallenge($huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();

            $data['challengesTypes'] = $challengeTypes;
            $data['huntId'] = $huntId;
            $this->global['pageTitle'] = 'Scavenger Hunts : Add a New Challenge';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/addNewChallenge", $this->global, $data, NULL);
        //}
    }

    public function uploadChallengeImage($huntId, $photoType, $imgUri = "")
    {
        $target_dir = "assets/uploads/challenges/" . $huntId;
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
        $target_dir .= "/";
        if (intval($photoType) == 1)
        {
            $target_file = $target_dir . basename($_FILES["challengeImage"]["name"]);
            if ($_FILES["challengeImage"]["name"] == "")
            {
                return array("", "");
            }
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $challengeImageName = basename($_FILES["challengeImage"]["name"]);
            $target_file = $target_dir . base64_encode(basename($_FILES["challengeImage"]["name"])) . "." . $imageFileType;
            $challengeImageName2 = base64_encode(basename($_FILES["challengeImage"]["name"])) . "." . $imageFileType;
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["challengeImage"]["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file);
                //echo "Sorry, file already exists.";
                $uploadOk = 1;
            }

            // Check file size
            if ($_FILES["challengeImage"]["size"] > 5000000) {
                //echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                //echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                return NULL;
            } else {            
                if (move_uploaded_file($_FILES["challengeImage"]["tmp_name"], $target_file)) {
                    //echo "The file ". htmlspecialchars( basename( $_FILES["huntlogo"]["name"])). " has been uploaded.";
                    return array($challengeImageName, $challengeImageName2);
                } else {
                    //echo "Sorry, there was an error uploading your file.";
                    return NULL;
                }
            }
        }
        else
        {
            $image_parts = explode(";base64,", $imgUri);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
        
            $image_base64 = base64_decode($image_parts[1]);
            $challengeImageName = uniqid() . '.png';
            $challengeImageName2 = $challengeImageName;
        
            $target_file = $target_dir . $challengeImageName;
            file_put_contents($target_file, $image_base64);

            return array($challengeImageName, $challengeImageName2);
        }
    }

    public function uploadChallengeImage2()
    {
        $huntId = $this->input->post("huntId");
        $uploadFileName = $this->input->post("uploadFileName");
        $imgUri = $this->input->post("imgUri");

        $target_dir = "assets/uploads/challenges/" . $huntId;
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
        $target_dir .= "/";

        $image_parts = explode(";base64,", $imgUri);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
    
        $image_base64 = base64_decode($image_parts[1]);
        if ($uploadFileName == "")
            $challengeImageName = uniqid() . '.png';
        else
            $challengeImageName = $uploadFileName;
    
        $target_file = $target_dir . $challengeImageName;
        file_put_contents($target_file, $image_base64);

        echo base_url() . $target_file;
        exit;
    }

    public function insertChallenge()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntId = $this->security->xss_clean($this->input->post('huntId'));
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('challengeName','Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('challengePoints','Point Value','trim|required');
            //$this->form_validation->set_rules('challengeDescription','Description','trim|required');
            $this->form_validation->set_rules('challengePage','Puzzle Page','trim|required');
            //$this->form_validation->set_rules('challengeLink','Link','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addChallenge($huntId);
            }
            else
            {    
                $challengeName = $this->security->xss_clean($this->input->post('challengeName'));
                $challengeDescription = $this->input->post('challengeDescription');
                $challengePoints = $this->security->xss_clean($this->input->post('challengePoints'));
                $challengePage = $this->input->post('challengePage');
                $challengeAnswer = $this->input->post('challengeAnswer');
                //$multiAnswer = $this->input->post('multiAnswer');
                $challengeLink = $this->security->xss_clean($this->input->post('challengeLink'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));
                /*$photoType = $this->security->xss_clean($this->input->post('photoType'));
                $allowPhoto = $this->security->xss_clean($this->input->post('allowPhoto'));
                $imageCaptured = $this->input->post('imageCaptured');

                if (intval($typeId) == 1 || (intval($typeId) == 2 && intval($allowPhoto) == 1))
                {
                    $arr_chgimage = $this->uploadChallengeImage($huntId, $photoType, $imageCaptured);
                    $chgimage = $arr_chgimage[0];
                    $chgimage2 = $arr_chgimage[1];
                }
                else
                {
                    $chgimage = "";
                    $chgimage2 = "";
                }*/

                $challengePage = str_replace("\r\n", "", $challengePage);
                $challengePage = str_replace('href="../assets', 'href="assets', $challengePage);
                $challengePage = str_replace('<img src="../assets', '<img class="img-responsive" src="assets', $challengePage);

                $chgInfo = array(
                    'hunt_id'=>$huntId, 
                    'chg_name'=>$challengeName, 
                    'description'=>$challengeDescription, 
                    'points'=>$challengePoints,
                    'puzzle_page'=>$challengePage,
                    'puzzle_answer'=>$challengeAnswer,
                    'multi_answer'=>1,
                    'chg_type_id'=>$typeId, 
                    'chg_image'=>"", 
                    'chg_image2'=>"", 
                    'chg_link'=>$challengeLink,
                    'status_id'=>1, 
                    'created'=>date("Y-m-d H:i:s"),
                    'deleted'=>NULL
                );
                
                $this->load->model('challenge_model');
                $nId = $this->challenge_model->insertChallenge($chgInfo);
                
                if(intval($nId) > 0)
                {
                    $this->session->set_flashdata('success', 'New Challenge created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Challenge creation failed');
                }
                
                redirect('/addChallenge' . '/' . $huntId);
            }
        //}
    }

    public function gotoChallengeDetails($challengeId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $challengeInfo = $this->challenge_model->getChallengeInfo($challengeId);
            $huntId = $challengeInfo->hunt_id;
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();

            $data['challengeInfo'] = $challengeInfo;
            $data['challengesTypes'] = $challengeTypes;
            $data['challengeId'] = $challengeId;
            $this->global['pageTitle'] = 'Scavenger Hunts : Edit Challenge Details';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/challengeDetails", $this->global, $data, NULL);
        //}
    }

    public function editChallenge()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $updated = date('Y-m-d H:i:s');
            $this->load->library('form_validation');
            $this->load->model('challenge_model');
            $challengeId = $this->input->post('challengeId');
            $chgInfo = $this->challenge_model->getChallengeInfo($challengeId);
            $huntId = $chgInfo->hunt_id;
            $this->form_validation->set_rules('challengeName','Name','trim|required|max_length[255]');
            if($this->form_validation->run() == FALSE)
            {
                $this->gotoChallengeDetails($challengeId);
            }
            else
            {
                $challengeName = $this->security->xss_clean($this->input->post('challengeName'));
                $challengeDescription = $this->input->post('challengeDescription');
                $challengePoints = $this->security->xss_clean($this->input->post('challengePoints'));
                $challengePage = $this->input->post('challengePage');
                $challengeAnswer = $this->input->post('challengeAnswer');
                //$multiAnswer = $this->input->post('multiAnswer');
                $challengeLink = $this->security->xss_clean($this->input->post('challengeLink'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));
                /*$photoType = $this->security->xss_clean($this->input->post('photoType'));
                $allowPhoto = $this->security->xss_clean($this->input->post('allowPhoto'));
                $imageCaptured = $this->input->post('imageCaptured');

                if (intval($typeId) == 1 || (intval($typeId) == 2 && intval($allowPhoto) == 1))
                {
                    $arr_chgimage = $this->uploadChallengeImage($huntId, $photoType, $imageCaptured);
                    $chgimage = $arr_chgimage[0];
                    $chgimage2 = $arr_chgimage[1];
                }
                else
                {
                    $chgimage = "";
                    $chgimage2 = "";
                }*/

                $challengePage = str_replace("\r\n", "", $challengePage);
                $challengePage = str_replace('href="../assets', 'href="assets', $challengePage);
                $challengePage = str_replace('<img src="../assets', '<img class="img-responsive" src="assets', $challengePage);

                $challengeInfo = array(
                    'chg_name'=>$challengeName, 
                    'description'=>$challengeDescription, 
                    'points'=>$challengePoints,
                    'puzzle_page'=>$challengePage,
                    'puzzle_answer'=>$challengeAnswer,
                    'multi_answer'=>1,
                    'chg_type_id'=>$typeId, 
                    'chg_image'=>"", 
                    'chg_image2'=>"", 
                    'chg_link'=>$challengeLink,
                    'status_id'=>1, 
                    'created'=>$updated,
                    'deleted'=>NULL
                );

                
                $result = $this->challenge_model->editChallenge($challengeInfo, $challengeId);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'The challenge updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Challenge update failed');
                }
                
                redirect('/manageChallenges' . '/' . $huntId);
            }
        //}
    }

    public function judgeChallenges($huntId, $gamecodeId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/   
            $chgPhotoVideos = $this->challenge_model->getPhotoVideoChallengesByHunt($huntId);
            $chgOthers = $this->challenge_model->getOtherChallengesByHunt($huntId);

            $data['huntId'] = $huntId;
            $data['gamecodeId'] = $gamecodeId;
            $data['chgPhotoVideos'] = $chgPhotoVideos;
            $data['chgOthers'] = $chgOthers;

            $this->load->view("scavenger-hunts/judgeChallenges", $data);
        //}
    }

    public function getChallengeAnswers()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntId = $_POST['huntId'];
            $gamecodeId = $_POST['gamecodeId'];
            $challengeId = $_POST['challengeId'];

            //$challengeInfo = $this->challenge_model->getChallengeInfo($challengeId);
            //$chgTypeId = intval($challengeInfo->chg_type_id);

            $submittedResult = array();
            $result = $this->challenge_model->getSubmittedResults($huntId, $gamecodeId, $challengeId);
            $k = 0;
            foreach ($result as $record)
            {
                $submittedResult[$k]["id"] = $record->id;
                $teamId = $this->hunt_model->getTeamIdByGameCodeId($record->gamecode_id);
                $teamInfo = $this->team_model->getTeamInfo($teamId);
                $teamname = "";
                if (isset($teamInfo))
                    $teamname = $teamInfo->team_name;
                $submittedResult[$k]["teamname"] = $teamname;
                $submittedResult[$k]["answer"] = $record->chg_result;
                $submittedResult[$k]["points"] = $record->points;
                $submittedResult[$k]["judge_status"] = $record->status_id < 2 ? 0 : 1;
            }

            echo json_encode($submittedResult);
            exit;
        //}
    }

    public function saveChallengePoints()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $chgResultId = $_POST["chgResultId"];
            $points = $_POST["points"];
            $judgeInfo = array('points' => $points, 'status_id'=>2);
            $result = $this->challenge_model->editChallengeResult($judgeInfo, $chgResultId);
            echo "success";
            exit;
        //}
    }

    public function copyChallenge($challengeId)
    {
        $huntId = 1;
        $chgInfo = $this->challenge_model->getChallengeInfo($challengeId);
        if (isset($chgInfo))
        {
            $huntId = $chgInfo->hunt_id;
            $result = $this->challenge_model->copyChallenge($chgInfo);
        }
        redirect('/manageChallenges' . '/' . $huntId);
    }

    public function deleteChallenge($challengeId)
    {
        $huntId = 1;
        $chgInfo = $this->challenge_model->getChallengeInfo($challengeId);
        if (isset($chgInfo))
        {
            $huntId = $chgInfo->hunt_id;
            $result = $this->challenge_model->deleteResultByChallengeId($challengeId);
            $result2 = $this->challenge_model->deleteChallenge($challengeId);
        }
        redirect('/manageChallenges' . '/' . $huntId);
    }

    public function copyHunt($huntId)
    {
        $schoolId = 1;
        $huntInfo = $this->hunt_model->getHuntInfo($huntId);
        if (isset($huntInfo))
        {
            $schoolId = $huntInfo->school_id;
            $newHuntId = $this->hunt_model->copyHunt($huntInfo);
            $src_dir = "assets/uploads/challenges/" . $huntId;
            $dst_dir = "assets/uploads/challenges/" . $newHuntId;
            $this->custom_copy($src_dir, $dst_dir);
            $challenges = $this->challenge_model->getChallengesByHunt($huntId);
            foreach ($challenges as $record)
            {
                $record->hunt_id = $newHuntId;
                $puzzle_page = $record->puzzle_page;
                $puzzle_page = str_replace("assets/uploads/challenges/" . $huntId . "/", "/assets/uploads/challenges/" . $newHuntId. "/", $puzzle_page);
                $record->puzzle_page = $puzzle_page;
                $result = $this->challenge_model->copyChallenge($record);
            }
            redirect('/gotoHuntDetails' . '/' . $newHuntId);
        }
        else
            redirect('/manageHunt' . '/' . $schoolId);
    }

    public function deleteHunt($huntId)
    {
        $schoolId = 1;
        $huntInfo = $this->hunt_model->getHuntInfo($huntId);
        if (isset($huntInfo))
        {
            $schoolId = $huntInfo->school_id;
            $src_dir = "assets/uploads/challenges/" . $huntId;
            $this->custom_delete($src_dir);
            $challenges = $this->challenge_model->getChallengesByHunt($huntId);
            foreach ($challenges as $record)
            {    
                $challengeId = $record->id;
                $result = $this->challenge_model->deleteResultByChallengeId($challengeId);
                $result2 = $this->challenge_model->deleteChallenge($challengeId);
            }
            $result3 = $this->hunt_model->deleteHunt($huntId);
        }
        redirect('/manageHunt' . '/' . $schoolId);
    }

    public function custom_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while ($file = readdir($dir))
        {
            if (($file != '.') && ($file != '..'))
            {
                if (is_dir($src.'/'.$file))
                {
                    custom_copy($src . '/' . $file, $dst . '/' . $file);
                }
                else
                {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function custom_delete($src)
    {
        $files = glob($src . '/*');
        foreach ($files as $file)
        {
            if (is_file($file))
            {
                unlink($file);
            }
        }
    }

    public function manageDataBank($huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();
            $challenges = array();
            
            $ret = $this->challenge_model->getChallengesFromDataBank();
            if (count($ret) > 0)
            {
                foreach ($ret as $k => $record)
                {
                    $challenges[$k]["id"] = $record->id;
                    $challenges[$k]["challengename"] = $record->chg_name;
                    $challenges[$k]["description"] = $record->description;
                    $challenges[$k]["points"] = $record->points;
                    $challenges[$k]["puzzlepage"] = $record->puzzle_page;
                    $chgType = $this->challenge_model->getChallengeTypeInfo($record->chg_type_id);
                    $challenges[$k]["typeId"] = $record->chg_type_id;
                    $challenges[$k]["challengetype"] = $chgType->name;
                    $challenges[$k]["challengelink"] = $record->chg_link;
                }
            }
            $data['challengesTypes'] = $challengeTypes;
            $data['challenges'] = $challenges;
            $data['huntId'] = $huntId;
            $this->global['pageTitle'] = 'Scavenger Hunts : Challenge Data Bank';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/manageDataBank", $this->global, $data, NULL);
        //}
    }

    public function addChallengeDB($huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();

            $data['challengesTypes'] = $challengeTypes;
            $data['huntId'] = $huntId;
            $this->global['pageTitle'] = 'Scavenger Hunts : Add a New Challenge';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/addNewChallengeDB", $this->global, $data, NULL);
        //}
    }

    public function uploadChallengeDBImage2()
    {
        $huntId = $this->input->post("huntId");
        $uploadFileName = $this->input->post("uploadFileName");
        $imgUri = $this->input->post("imgUri");

        $target_dir = "assets/uploads/databank";
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
        $target_dir .= "/";

        $image_parts = explode(";base64,", $imgUri);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
    
        $image_base64 = base64_decode($image_parts[1]);
        if ($uploadFileName == "")
            $challengeImageName = uniqid() . '.png';
        else
            $challengeImageName = $uploadFileName;
    
        $target_file = $target_dir . $challengeImageName;
        file_put_contents($target_file, $image_base64);

        echo base_url() . $target_file;
        exit;
    }

    public function insertChallengeDB()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $huntId = $this->security->xss_clean($this->input->post('huntId'));
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('challengeName','Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('challengePoints','Point Value','trim|required');
            //$this->form_validation->set_rules('challengeDescription','Description','trim|required');
            $this->form_validation->set_rules('challengePage','Puzzle Page','trim|required');
            //$this->form_validation->set_rules('challengeLink','Link','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addChallenge($huntId);
            }
            else
            {    
                $challengeName = $this->security->xss_clean($this->input->post('challengeName'));
                $challengeDescription = $this->input->post('challengeDescription');
                $challengePoints = $this->security->xss_clean($this->input->post('challengePoints'));
                $challengePage = $this->input->post('challengePage');
                $challengeAnswer = $this->input->post('challengeAnswer');
                $multiAnswer = $this->input->post('multiAnswer');
                $challengeLink = $this->security->xss_clean($this->input->post('challengeLink'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));

                $challengePage = str_replace("\r\n", "", $challengePage);
                $challengePage = str_replace('href="../assets', 'href="assets', $challengePage);
                $challengePage = str_replace('<img src="../assets', '<img class="img-responsive" src="assets', $challengePage);

                $chgInfo = array(
                    'chg_name'=>$challengeName, 
                    'description'=>$challengeDescription, 
                    'points'=>$challengePoints,
                    'puzzle_page'=>$challengePage,
                    'puzzle_answer'=>$challengeAnswer,
                    'multi_answer'=>$multiAnswer,
                    'chg_type_id'=>$typeId, 
                    'chg_image'=>"", 
                    'chg_image2'=>"", 
                    'chg_link'=>$challengeLink,
                    'status_id'=>1, 
                    'created'=>date("Y-m-d H:i:s"),
                    'deleted'=>NULL
                );
                
                $this->load->model('challenge_model');
                $nId = $this->challenge_model->insertChallengeDB($chgInfo);
                
                if(intval($nId) > 0)
                {
                    $this->session->set_flashdata('success', 'New Challenge created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Challenge creation failed');
                }
                
                redirect('/addChallengeDB' . '/' . $huntId);
            }
        //}
    }

    public function gotoChallengeDBDetails($challengeId, $huntId)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $challengeInfo = $this->challenge_model->getChallengeDBInfo($challengeId);
            
            $huntInfo = $this->hunt_model->getHuntInfo($huntId);
            $schoolId = $huntInfo->school_id;
            $challengeTypes = $this->challenge_model->getAllChallengeTypes();

            $data['challengeInfo'] = $challengeInfo;
            $data['challengesTypes'] = $challengeTypes;
            $data['challengeId'] = $challengeId;
            $this->global['pageTitle'] = 'Scavenger Hunts : Edit Challenge Details';
            $this->global['huntId'] = $huntId;
            $this->global['schoolId'] = $schoolId;
            $this->loadViews2("scavenger-hunts/challengeDBDetails", $this->global, $data, NULL);
        //}
    }

    public function editChallengeDB()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {*/
            $updated = date('Y-m-d H:i:s');
            $this->load->library('form_validation');
            $this->load->model('challenge_model');
            $challengeId = $this->input->post('challengeId');
            $chgInfo = $this->challenge_model->getChallengeInfo($challengeId);
            $huntId = $chgInfo->hunt_id;
            $this->form_validation->set_rules('challengeName','Name','trim|required|max_length[255]');
            if($this->form_validation->run() == FALSE)
            {
                $this->gotoChallengeDBDetails($challengeId);
            }
            else
            {
                $challengeName = $this->security->xss_clean($this->input->post('challengeName'));
                $challengeDescription = $this->input->post('challengeDescription');
                $challengePoints = $this->security->xss_clean($this->input->post('challengePoints'));
                $challengePage = $this->input->post('challengePage');
                $challengeAnswer = $this->input->post('challengeAnswer');
                //$multiAnswer = $this->input->post('multiAnswer');
                $challengeLink = $this->security->xss_clean($this->input->post('challengeLink'));
                $typeId = $this->security->xss_clean($this->input->post('typeId'));

                $challengePage = str_replace("\r\n", "", $challengePage);
                $challengePage = str_replace('href="../../assets', 'href="assets', $challengePage);
                $challengePage = str_replace('<img src="../../assets', '<img class="img-responsive" src="assets', $challengePage);

                $challengeInfo = array(
                    'chg_name'=>$challengeName, 
                    'description'=>$challengeDescription, 
                    'points'=>$challengePoints,
                    'puzzle_page'=>$challengePage,
                    'puzzle_answer'=>$challengeAnswer,
                    'multi_answer'=>1,
                    'chg_type_id'=>$typeId, 
                    'chg_image'=>"", 
                    'chg_image2'=>"", 
                    'chg_link'=>$challengeLink,
                    'status_id'=>1, 
                    'created'=>$updated,
                    'deleted'=>NULL
                );

                
                $result = $this->challenge_model->editChallengeDB($challengeInfo, $challengeId);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'The challenge updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Challenge update failed');
                }
                
                redirect('/manageDataBank' . '/' . $huntId);
            }
        //}
    }

    public function copyChallengeDB($challengeId, $huntId)
    {
        $chgInfo = $this->challenge_model->getChallengeDBInfo($challengeId);
        if (isset($chgInfo))
        {
            $result = $this->challenge_model->copyChallengeDB($chgInfo);
        }
        redirect('/manageDataBank' . '/' . $huntId);
    }

    public function deleteChallengeDB($challengeId, $huntId)
    {
        $chgInfo = $this->challenge_model->getChallengeDBInfo($challengeId);
        if (isset($chgInfo))
        {
            $result = $this->challenge_model->deleteChallengeDB($challengeId);
        }
        redirect('/manageDataBank' . '/' . $huntId);
    }

    public function copyChallengeDBToHunt($challengeId, $huntId)
    {
        $chgInfo = $this->challenge_model->getChallengeDBInfo($challengeId);
        if (isset($chgInfo))
        {
            $result = $this->challenge_model->copyChallengeDBToHunt($chgInfo, $huntId);
        }
        redirect('/manageDataBank' . '/' . $huntId);
    }
}