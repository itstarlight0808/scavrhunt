<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Zoomaccount_model extends CI_Model
{
    private $_tablename = 'zoom_account';

    function getZoomAccountCount()
    {
        $query = $this->db->get($this->_tablename);    
        return $query->num_rows();
    }
    
    function getAllZoomAccounts()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    function zoomAccountListingCount($searchText = '')
    {
        if(!empty($searchText)) {
            $likeCriteria = "account_name LIKE '%".$searchText."%'";
            $likeCriteria .= " or created LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get($this->_tablename);    
        return $query->num_rows();
    }

    function zoomAccountListing($searchText = '', $page, $segment)
    {
        if(!empty($searchText)) {
            $likeCriteria = "account_name LIKE '%".$searchText."%'";
            $likeCriteria .= " or created LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    function getZoomAccountInfo($accountId)
    {
        $this->db->where('id', $accountId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    function insertZoomAccount($accountInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $accountInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function editZoomAccount($accountInfo, $accountId)
    {
        $this->db->where('id', $accountId);
        $this->db->update($this->_tablename, $accountInfo);
        
        return TRUE;
    }

    function deleteZoomAccount($accountId)
    {
        $this->db->where('id', $accountId);
        $this->db->delete($this->_tablename);
        
        return $this->db->affected_rows();
    }
}

  