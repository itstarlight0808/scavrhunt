<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model
{
    private $_tablename = 'schools';

    public function getSchoolCount()
    {
        $query = $this->db->get($this->_tablename);    
        return $query->num_rows();
    }
    
    public function getAllSchools()
    {
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    public function getSchoolsByAccount($accountId)
    {
        $this->db->where("zoom_account_id", $accountId);
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    public function schoolListingCount($accountId = 0, $searchText = '')
    {
        if ($accountId != 0 || $accountId != "0")
        {
            $this->db->where("zoom_account_id", $accountId);
            if(!empty($searchText)) {
                $likeCriteria = "(sch_name LIKE '%".$searchText."%'";
                $likeCriteria .= " or sch_address LIKE '%".$searchText."%'";
                $likeCriteria .= " or sch_details LIKE '%".$searchText."%'";
                $likeCriteria .= " or zoom_link LIKE '%".$searchText."%'";
                $likeCriteria .= " or video_id LIKE '%".$searchText."%'";
                $likeCriteria .= " or subdomains LIKE '%".$searchText."%')";
                $this->db->where($likeCriteria);
            }
        }
        $query = $this->db->get($this->_tablename);    
        return $query->num_rows();
    }

    public function schoolListing($accountId = 0, $searchText = '', $page = 1, $segment = 1)
    {
        $this->db->select('SchoolTbl.*, AccountTbl.account_name');
        $this->db->from($this->_tablename . ' as SchoolTbl');
        $this->db->join('zoom_account as AccountTbl', 'SchoolTbl.zoom_account_id = AccountTbl.id','left');
        if (intval($accountId) > 0)
        {
            $this->db->where("SchoolTbl.zoom_account_id", $accountId);
        }
        if(!empty($searchText)) {
            $likeCriteria = "(sch_name LIKE '%".$searchText."%'";
            $likeCriteria .= " or sch_address LIKE '%".$searchText."%'";
            $likeCriteria .= " or sch_details LIKE '%".$searchText."%'";
            $likeCriteria .= " or zoom_link LIKE '%".$searchText."%'";
            $likeCriteria .= " or video_id LIKE '%".$searchText."%'";
            $likeCriteria .= " or subdomains LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }   
        $this->db->order_by('SchoolTbl.created', 'DESC');
        //$this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getSchoolInfo($schoolId)
    {
        $this->db->where('id', $schoolId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function insertSchool($schoolInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $schoolInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    public function editSchool($schoolInfo, $schoolId)
    {
        $this->db->where('id', $schoolId);
        $this->db->update($this->_tablename, $schoolInfo);
        
        return TRUE;
    }

    public function deleteSchool($schoolId)
    {
        $this->db->where('id', $schoolId);
        $this->db->delete($this->_tablename);
        
        return $this->db->affected_rows();
    }

    public function deleteSchools($accountId)
    {
        $this->db->where('zoom_account_id', $accountId);
        $this->db->delete($this->_tablename);
        
        return TRUE;
    }
}