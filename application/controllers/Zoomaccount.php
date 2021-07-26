<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 February 2021
 */
class Zoomaccount extends BaseController
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
     * This function is used to load the user list
     */
    public function zoomaccountListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->zoomaccount_model->zoomAccountListingCount($searchText);

			$returns = $this->paginationCompress("zoomAccountListing/", $count, 10);
            
            $data['zoomAccounts'] = $this->zoomaccount_model->zoomAccountListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Admin Software : Zoom Account Listing';
            
            $this->loadViews("zoomaccounts", $this->global, $data, NULL);
        }
    }

    public function addZoomAccount()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {   
            $this->global['pageTitle'] = 'Team Building : Add New Zoom Account';
            $this->loadViews("addNewZoomAccount", $this->global, array(), NULL);
        }
    }

    public function insertZoomAccount()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('accountname','Zoom Account Name','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addZoomAccount();
            }
            else
            {
                $accountname = $this->security->xss_clean($this->input->post('accountname'));
                
                
                $accountInfo = array('account_name'=>$accountname, 'created'=>date('Y-m-d H:i:s'));
                
                $this->load->model('zoomaccount_model');
                $result = $this->zoomaccount_model->insertZoomAccount($accountInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New zoom account created successfully');
                    for ($i = 0; $i < 50; $i++)
                    {
                        $roomno = $i + 1;
                        $roomInfo = array('zoom_account_id' => $result, 'room_no' => $roomno, 'status_id' => '1');
                        $result2 = $this->room_model->addNewZoomRoom($roomInfo);
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zoom account creation failed');
                }
                
                redirect('/addZoomAccount');
            }
        }
    }

    public function editOld($accountId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($accountId == null)
            {
                redirect('/zoomAccountListing');
            }
            
            $data['zoomAccountInfo'] = $this->zoomaccount_model->getZoomAccountInfo($accountId);
            
            $this->global['pageTitle'] = 'Team Building : Edit Zoom Account';
            
            $this->loadViews("editZoomAccount", $this->global, $data, NULL);
        }
    }

    public function editZoomAccount()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $accountId = $this->input->post('accountId');
            
            $this->form_validation->set_rules('accountname','Zoom Account Name','trim|required|max_length[255]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($accountId);
            }
            else
            {
                //$accountname = ucwords(strtolower($this->security->xss_clean($this->input->post('accountname'))));
                $accountname = $this->security->xss_clean($this->input->post('accountname'));
                $accountInfo = array();
                $accountInfo = array('account_name'=>$accountname);
                                
                $result = $this->zoomaccount_model->editZoomAccount($accountInfo, $accountId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Zoom account updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zoom account update failed');
                }
                
                redirect('/zoomAccountListing');
            }
        }
    }

    public function deleteZoomAccount()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $accountId = $this->input->post('accountId');
            $result = $this->room_model->deleteZoomRoom($accountId);
            $result2 = $this->school_model->deleteSchools($accountId);
            $result3 = $this->zoomaccount_model->deleteZoomAccount($accountId);
            
            if ($result3 > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
}

?>