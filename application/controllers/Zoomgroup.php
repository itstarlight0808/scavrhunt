<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 February 2021
 */

class Zoomgroup extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('player_model');
        $this->load->model('room_model');
        $this->load->model('team_model');
        $this->load->model('school_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        
    }

    /**
     * This function is used to load the group list
     */
    public function groupListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $allSchools = $this->school_model->getAllSchools();

            $schoolId = $this->security->xss_clean($this->input->post('schoolId'));
            if ($schoolId == "")
            {
                if (count($allSchools) > 0)
                {
                    $schoolId = $allSchools[0]->id;
                }
                else
                    $schoolId = "0";
            }
            $data['schoolId'] = $schoolId;

            if (count($allSchools) > 0)
            {
                $data['allSchools'] = $allSchools;
                if ($schoolId == "0")
                    $data['groups'] = $this->getAllGroups();
                else
                    $data['groups'] = $this->getGroupsBySchool($schoolId);
            }
            else
            {
                $data['allSchools'] = array();
                $data['groups'] = array();
            }
            

            $this->global['pageTitle'] = 'Admin Software : Group Listing';
            
            $this->loadViews("groups", $this->global, $data, NULL);
        }
    }


    public function getAllGroups()
    {
        $ret = array();

        $allSchools = $this->school_model->getAllSchools();
        foreach ($allSchools as $school)
        {
            $tmp = $this->getGroupsBySchool($school->id);
            $ret = array_merge($ret, $tmp);
        }

        return $ret;
    }

    public function getGroupsBySchool($schoolId)
    {
        $ret = array();
        $k = 0;
        if (intval($schoolId) > 0)
        {
            $school = $this->school_model->getSchoolInfo($schoolId);
            $sch_name = $school->sch_name;
        }
        else
        {
            $sch_name = "";
        }
        $players = $this->player_model->getPlayersBySchool($schoolId);
            
        if (count($players) > 0)
        {
            foreach ($players as $record)
            {
                $ret[$k]["id"] = $record->id;
                $ret[$k]["logged_in"] = substr($record->logged_in, 0, 16);
                $ret[$k]["email"] = $record->email;
                $ret[$k]["fullname"] = $record->name;
                $ret[$k]["stdId"] = $record->std_id_req;
                $ret[$k]["schoolname"] = $sch_name;
                if (intval($record->team_id) > 0)
                {
                    $teamInfo = $this->team_model->getTeamInfo($record->team_id);
                    if ($teamInfo->same_device == "0")
                    {
                        $ret[$k]["samedevice"] = "No";
                    }
                    else
                    {
                        $ret[$k]["samedevice"] = "Yes";
                    }
                    if ($teamInfo->players_count == "1")
                    {
                        $ret[$k]["playerscount"] = "Solo player looking for a team";
                    }
                    else
                    {
                        $ret[$k]["playerscount"] = $teamInfo->players_count . " players";
                    }
                    $ret[$k]["teamname"] = $teamInfo->team_name;
                    $ret[$k]["captain"] = $teamInfo->captain;
                    $ret[$k]["members"] = $teamInfo->members;
                }
                else
                {
                    $ret[$k]["samedevice"] = "No";
                    $ret[$k]["playerscount"] = "Solo player looking for a team";
                    $ret[$k]["teamname"] = "";
                    $ret[$k]["captain"] = "";
                    $ret[$k]["members"] = "";
                }
                if (intval($record->room_id) > 0)
                {
                    $room = $this->room_model->getRoomInfo($record->room_id);
                    $ret[$k]["roomno"] = $room->room_no;
                }
                else
                {
                    $ret[$k]["roomno"] = "Not Assigned";
                }
                $k++;
            }
        }

        return $ret;
    }
}