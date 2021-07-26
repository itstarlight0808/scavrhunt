<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Player_model extends CI_Model
{
    private $_tablename = 'players';
    private $_tablename2 = 'schools';

    public function addNewPlayer($playerInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $playerInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function searchSamePlayer(/*$fullname, */$email, $schoolId)
    {
        //$this->db->where('name', $fullname);
        $this->db->where('email', $email);
        $this->db->where('school_id', $schoolId);
        $this->db->where('status_id != 3');

        $query = $this->db->get($this->_tablename);
        $result = $query->row();
        if (isset($result))
            return $result->id;
        else
            return "0";
    }

    public function getPlayersByZoomAccount($accountId)
    {
        $this->db->select('p.*');
        $this->db->from($this->_tablename . ' as p');
        $this->db->join($this->_tablename2 . ' as s', 'p.school_id = s.id','left');
        $this->db->where('s.zoom_account_id', $accountId);
        $this->db->where('p.status_id != 3');
        $this->db->order_by('p.logged_in', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPlayersNumInRoom($roomId, $schoolId)
    {
        $this->db->select('COUNT(id) as pcount');
        $this->db->where('school_id', $schoolId);
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id != 3');
        $query = $this->db->get($this->_tablename);
        $result = $query->row();
        return intval($result->pcount);
    }

    public function getPlayerInfo($playerId)
    {
        $this->db->where('id', $playerId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function getSameRoomPlayers($roomId)
    {
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id != 3');
        $this->db->order_by('team_id', 'ASC');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function updatePlayer($playerInfo, $playerId)
    {
        $this->db->where('id', $playerId);
        $this->db->update($this->_tablename, $playerInfo);
        return TRUE;
    }

    public function getPlayersBySchool($schoolId)
    {
        $this->db->where('school_id', $schoolId);
        $query = $this->db->get($this->_tablename);
        $result = $query->result();
        return $result;
    }

    public function updatePlayersInTeam($playerInfo, $teamId)
    {
        $this->db->where('team_id', $teamId);
        $this->db->update($this->_tablename, $playerInfo);
        return TRUE;
    }
}