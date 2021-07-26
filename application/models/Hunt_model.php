<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Hunt_model extends CI_Model
{
    private $_tablename = 'hunt_infos';
    private $_tablename2 = 'hunt_types';
    private $_tablename3 = 'hunt_delivery';
    private $_tablename4 = 'hunt_gamecode';

    public function getAllHuntTypes()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename2);    
        return $query->result();
    }

    public function getAllHuntDelivery()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename3);    
        return $query->result();
    }

    public function getTypeInfo($typeId)
    {
        $this->db->where('id', $typeId);
        $query = $this->db->get($this->_tablename2);
        return $query->row();
    }

    public function getDeliveryInfo($deliveryId)
    {
        $this->db->where('id', $deliveryId);
        $query = $this->db->get($this->_tablename3);
        return $query->row();
    }

    public function getHuntInfo($huntId)
    {
        $this->db->where('id', $huntId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function getHuntInfosBySchool($schoolId)
    {
        $this->db->where('school_id', $schoolId);
        $this->db->where('status_id != 4');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function getActiveHunts($accountId)
    {
        $this->db->where('zoom_account_id', $accountId);
        $this->db->where('is_active = 1');
        $this->db->where('status_id != 4');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function insertHunt($huntInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $huntInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function editHunt($huntInfo, $huntId)
    {
        $this->db->where('id', $huntId);
        $this->db->update($this->_tablename, $huntInfo);
        return TRUE;
    }

    public function deleteHunt($huntId)
    {
        $deleted = date('Y-m-d H:i:s');
        $huntInfo = array(
            'status_id' => 4,
            'deleted' => $deleted
        );
        $this->db->where('id', $huntId);
        $this->db->update($this->_tablename, $huntInfo);
        return TRUE;
        //$this->db->delete($this->_tablename);
        //return $this->db->affected_rows();
    }

    public function copyHunt($huntInfo)
    {
        $target_dir = "assets/uploads/logo2/";
        $created = date('Y-m-d H:i:s');
        $srcFile = $huntInfo->hunt_logo2;
        $arrSrcFile = explode(".", $srcFile);
        $srcExt = $arrSrcFile[1];
        $destFile = uniqid() . $srcExt;
        copy($target_dir.$srcFile, $target_dir.$destFile);
        $newHuntInfo = array(
            'hunt_name' => $huntInfo->hunt_name,
            'hunt_logo' => $huntInfo->hunt_logo,
            'hunt_logo2' => $destFile,
            'zoom_account_id' => $huntInfo->zoom_account_id,
            'school_id' => $huntInfo->school_id,
            'is_active' => $huntInfo->is_active,
            'type_id' => $huntInfo->type_id,
            'delivery_id' => $huntInfo->delivery_id,
            'start_date' => $huntInfo->start_date,
            'start_time' => $huntInfo->start_time,
            'end_date' => $huntInfo->end_date,
            'end_time' => $huntInfo->end_time,
            'max_time' => $huntInfo->max_time,
            'status_id' => $huntInfo->status_id
        );
        $result = $this->insertHunt($newHuntInfo);
        return $result;
    }

    public function getTeamIdByGameCodeId($gamecodeId)
    {
        $this->db->where('id', $gamecodeId);
        //$this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename4);
        $result = $query->row();
        if (isset($result))
            return intval($result->team_id);
        else
            return 0;
    }

    public function getHuntGameCodeInfo($teamId)
    {
        $this->db->where('team_id', $teamId);
        $this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename4);
        $result = $query->row();
        return $result;
    }

    public function getSameGameCode($gamecode)
    {
        $this->db->where('gamecode', $gamecode);
        $this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename4);
        $result = $query->row();
        if (isset($result))
            return true;
        else
            return false;
    }

    public function getGameCodesByTeams($teamIds)
    {
        $this->db->where_in('team_id', $teamIds);
        $this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename4);
        $result = $query->result();
        return $result;
    }

    public function insertHuntGameCode($gameCodeInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename4, $gameCodeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function editHuntGameCode($gameCodeInfo, $gameCodeId)
    {
        $this->db->where('id', $gameCodeId);
        $this->db->update($this->_tablename4, $gameCodeInfo);
        return TRUE;
    }
}