<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 February 2021
 */

class School extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('zoomaccount_model');
        $this->load->model('school_model');
        $this->load->model('room_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        
    }

    /**
     * This function is used to load the school list
     */
    public function schoolListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $allZoomAccounts = $this->zoomaccount_model->getAllZoomAccounts();
            $data['allZoomAccounts'] = $allZoomAccounts;

            $accountId = $this->security->xss_clean($this->input->post('accountId'));
            if ($accountId == "")
                $accountId = "0";
            $data['accountId'] = $accountId;

            /*$searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->school_model->schoolListingCount($accountId, $searchText);
			$returns = $this->paginationCompress("schoolListing/", $count, 10);
            $data['schools'] = $this->school_model->schoolListing($accountId, $searchText, $returns["page"], $returns["segment"]);*/
            
            $data['schools'] = $this->school_model->schoolListing($accountId);
            
            $this->global['pageTitle'] = 'Admin Software : School Listing';
            $this->loadViews("schools", $this->global, $data, NULL);
        }
    }

    public function uploadLogo()
    {
        $target_dir = "assets/uploads/logo/";
        $target_file = $target_dir . basename($_FILES["schoollogo"]["name"]);
        if ($_FILES["schoollogo"]["name"] == "")
        {
            return array("", "");
        }
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $schoollogoname = basename($_FILES["schoollogo"]["name"]);
        $target_file = $target_dir . base64_encode(basename($_FILES["schoollogo"]["name"])) . "." . $imageFileType;
        $schoollogoname2 = base64_encode(basename($_FILES["schoollogo"]["name"])) . "." . $imageFileType;
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["schoollogo"]["tmp_name"]);
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
        if ($_FILES["schoollogo"]["size"] > 5000000) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        //echo $target_file;
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            return NULL;
        } else {
            
            if (move_uploaded_file($_FILES["schoollogo"]["tmp_name"], $target_file)) {
                //echo "The file ". htmlspecialchars( basename( $_FILES["schoollogo"]["name"])). " has been uploaded.";
                return array($schoollogoname, $schoollogoname2);
            } else {
                //echo "Sorry, there was an error uploading your file.";
                return NULL;
            }
        }
    }

    public function addSchool()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {   
            $allZoomAccounts = $this->zoomaccount_model->getAllZoomAccounts();
            $data['allZoomAccounts'] = $allZoomAccounts;
            $this->global['pageTitle'] = 'Team Building : Add New School';
            $this->loadViews("addNewSchool", $this->global, $data, NULL);
        }
    }

    public function insertSchool()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('schoolname','School Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('zoomlink','Zoom Link','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addSchool();
            }
            else
            {                
                $schoolname = $this->security->xss_clean($this->input->post('schoolname'));
                $schooladdr = $this->security->xss_clean($this->input->post('schooladdr'));
                $accountId = $this->security->xss_clean($this->input->post('accountId'));
                $isactive = $this->security->xss_clean($this->input->post('isactive'));
                $stdIdRequired = $this->security->xss_clean($this->input->post('stdIdRequired'));
                $schooldetails = $this->security->xss_clean($this->input->post('schooldetails'));
                //$schoolLinkId = $this->security->xss_clean($this->input->post('schoolLinkId'));
                $zoomlink = $this->security->xss_clean($this->input->post('zoomlink'));
                $videoId = $this->security->xss_clean($this->input->post('videoId'));

                $arr_schoollogo = $this->uploadLogo();
                $schoollogo = $arr_schoollogo[0];
                $schoollogo2 = $arr_schoollogo[1];
                
                /*
                $num0 = (rand(100,1000));
                $num1 = date("Ymd");
                $num2 = (rand(10,100));
                $num3 = time();
                $subdomains = $num0 . $num1 . $num2 . $num3;
                */

                $x = 9; // Amount of digits
                $min = pow(10,$x);
                $max = pow(10,$x+1)-1;
                $subdomains = rand($min, $max);

                $schoolInfo = array(
                    'sch_name'=>$schoolname, 
                    'sch_logo'=>$schoollogo, 
                    'sch_logo2'=>$schoollogo2, 
                    'sch_address'=>$schooladdr, 
                    'zoom_account_id'=>$accountId, 
                    'is_active'=>$isactive,
                    'std_id_required'=>$stdIdRequired, 
                    'sch_details'=>$schooldetails, 
                    //'sch_link_id'=>$schoolLinkId,
                    'zoom_link'=>$zoomlink,
                    'video_id' => $videoId, 
                    'subdomains'=>$subdomains, 
                    'created'=>date('Y-m-d H:i:s')
                );
                
                $this->load->model('school_model');
                $result = $this->school_model->insertSchool($schoolInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New school created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'School creation failed');
                }
                
                redirect('/addSchool');
            }
        }
    }

    public function editOld($schoolId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($schoolId == null)
            {
                redirect('/schoolListing');
            }
            
            $allZoomAccounts = $this->zoomaccount_model->getAllZoomAccounts();
            $data['allZoomAccounts'] = $allZoomAccounts;

            $data['schoolInfo'] = $this->school_model->getSchoolInfo($schoolId);
            
            $this->global['pageTitle'] = 'Team Building : Edit School';
            
            $this->loadViews("editSchool", $this->global, $data, NULL);
        }
    }

    public function editSchool()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $schoolId = $this->input->post('schoolId');
            $oldSchoolInfo = $this->school_model->getSchoolInfo($schoolId);
            $oldAccountId = $oldSchoolInfo->zoom_account_id;
            
            $this->form_validation->set_rules('schoolname','School Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('zoomlink','Zoom Link','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($schoolId);
            }
            else
            {
                $schoolname = $this->security->xss_clean($this->input->post('schoolname'));
                $schooladdr = $this->security->xss_clean($this->input->post('schooladdr'));
                $accountId = $this->security->xss_clean($this->input->post('accountId'));
                $isactive = $this->security->xss_clean($this->input->post('isactive'));
                $stdIdRequired = $this->security->xss_clean($this->input->post('stdIdRequired'));
                $schooldetails = $this->security->xss_clean($this->input->post('schooldetails'));
                //$schoolLinkId = $this->security->xss_clean($this->input->post('schoolLinkId'));
                $zoomlink = $this->security->xss_clean($this->input->post('zoomlink'));
                $videoId = $this->security->xss_clean($this->input->post('videoId'));

                $arr_schoollogo = $this->uploadLogo();
                $schoollogo = $arr_schoollogo[0];
                $schoollogo2 = $arr_schoollogo[1];
                
                if ($schoollogo != "")
                {
                    $schoolInfo = array('sch_name'=>$schoolname, 
                                        'sch_logo'=>$schoollogo, 
                                        'sch_logo2'=>$schoollogo2, 
                                        'sch_address'=>$schooladdr, 
                                        'zoom_account_id'=>$accountId, 
                                        'is_active'=>$isactive, 
                                        'std_id_required'=>$stdIdRequired,
                                        'sch_details'=>$schooldetails,
                                        //'sch_link_id'=>$schoolLinkId, 
                                        'zoom_link'=>$zoomlink,
                                        'video_id' => $videoId
                                    );
                }
                else
                {
                    $schoolInfo = array('sch_name'=>$schoolname,   
                                        'sch_address'=>$schooladdr, 
                                        'zoom_account_id'=>$accountId, 
                                        'is_active'=>$isactive, 
                                        'std_id_required'=>$stdIdRequired,
                                        'sch_details'=>$schooldetails,
                                        //'sch_link_id'=>$schoolLinkId, 
                                        'zoom_link'=>$zoomlink,
                                        'video_id' => $videoId
                                    );
                }
                
                $this->load->model('room_model');
                $result2 = $this->room_model->reconfigureRoom($oldAccountId, $accountId, $schoolId);
                
                $this->load->model('school_model');
                $result = $this->school_model->editSchool($schoolInfo, $schoolId);
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New school updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'School update failed');
                }
                
                redirect('/schoolListing');
            }
        }
    }

    public function deleteSchool()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $schoolId = $this->input->post('schoolId');
            $schoolInfo = $this->school_model->getSchoolInfo($schoolId);
            $target_file = "assets/uploads/logo/" . $schoolInfo->sch_logo2;
            // Check if file already exists
            if (file_exists($target_file)) 
            {
                unlink($target_file);
            }
            $result = $this->school_model->deleteSchool($schoolId);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
}