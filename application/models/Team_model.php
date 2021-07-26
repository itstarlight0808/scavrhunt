<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Team_model extends CI_Model
{
    private $_tablename = 'teams';

    public function addNewTeam($teamInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $teamInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getTeamInfo($teamId)
    {
        $this->db->where('id', $teamId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function getTeamInfoByResult($teamId)
    {
        $this->db->where('id', $teamId);
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function updateTeam($teamInfo, $teamId)
    {
        $this->db->where('id', $teamId);
        $this->db->update($this->_tablename, $teamInfo);
    }

    public function deleteTeam($teamId)
    {
        $this->db->where('id', $teamId);
        $this->db->delete($this->_tablename);
        return TRUE;
    }

    public function getTeamsByRoomId($roomId, $schoolIds)
    {
        $this->db->select('t.id, t.team_name, t.players_count, t.same_device, t.room_id, t.captain, zr.room_no, zr.status_id');
        $this->db->from($this->_tablename . ' as t');
        $this->db->join('zoom_rooms as zr', 't.room_id = zr.id','left');
        if (count($schoolIds) > 0)
            $this->db->where_in('t.school_id', $schoolIds);
        $this->db->where('t.room_id', $roomId);
        $this->db->where('t.status_id = 1');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTeamsBySchools($schoolIds)
    {
        $this->db->where_in('school_id', $schoolIds);
        $this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function getSameTeam($schoolId, $teamname, $playersNum, $assignedRoomId, $teamcaptain)
    {
        $this->db->where('school_id', $schoolId);
        $this->db->where('team_name', $teamname);
        $this->db->where('players_count', $playersNum);
        $this->db->where('room_id', $assignedRoomId);
        $this->db->where('captain', $teamcaptain);
        $this->db->where('status_id', '1');
        $query = $this->db->get($this->_tablename);
        $result = $query->row();
        if (isset($result))
            return $result->id;
        else
            return "0";
    }

    public function searchTeam($step, $playerName, $schoolId, $playersNum, $teamname, $teamcaptain, $teammembers)
    {   
        if ($step == 1)
        {
            $matchNum1 = 5;
            $matchNum2 = 5;
            $matchNum3 = 3;
        }
        if ($step == 2)
        {
            $matchNum1 = 4;
            $matchNum2 = 4;
            $matchNum3 = 3;
        }
        if ($step == 3)
        {
            $matchNum1 = 3;
            $matchNum2 = 3;
            $matchNum3 = 3;
        }

        if ($playersNum == 1)
        {
            $wh = "school_id = '" . $schoolId . "' and status_id = 1 and (";
            $wh .= "members like \"%" . substr($playerName, 0, $matchNum3) . "%\" or ";
            $wh .= "captain like \"%" . substr($playerName, 0, $matchNum2) . "%\")";
            $this->db->where($wh);
        }
        else if ($playersNum == 2)
        {
            $wh = "school_id = '" . $schoolId . "' and status_id = 1 and (players_count = '" . $playersNum . "' or ";
            $arr_teammembers = explode(",", $teammembers);
            /*for ($i = 0; $i < count($arr_teammembers); $i++)
            {
                if ($arr_teammembers[$i] != "")
                    $arr_teammembers[$i] = substr($arr_teammembers[$i], 0, 4);
            }*/
            $memberCount = count($arr_teammembers);
            for ($i = 0; $i < $memberCount; $i++)
            {
                $wh .= "members like \"%" . substr($arr_teammembers[$i], 0, $matchNum3) . "%\" or ";
                $wh .= "captain like \"%" . substr($arr_teammembers[$i], 0, $matchNum3) . "%\" or ";
            }
            $wh .= "captain like \"" . substr($teamcaptain, 0, $matchNum2) . "%\" or ";
            if (substr($teamname, 0, 4) == "the " || substr($teamname, 0, 4) == "The ")
                $wh .= "MID(team_name, 5, LENGTH(team_name)-1) like \"" . substr(substr($teamname, 4), 0, $matchNum1) . "%\"";
            else
                $wh .= "team_name like \"%" . substr($teamname, 0, $matchNum1) . "%\"";
            $wh .= ")";
            $this->db->where($wh);
        }
        else
        {
            $wh = "school_id = '" . $schoolId . "' and status_id = 1 and (players_count = '" . $playersNum . "' or ";
            $arr_teammembers = explode(",", $teammembers);
            /*for ($i = 0; $i < count($arr_teammembers); $i++)
            {
                if ($arr_teammembers[$i] != "")
                    $arr_teammembers[$i] = substr($arr_teammembers[$i], 0, 4);
            }*/
            $memberCount = count($arr_teammembers);
            for ($i = 0; $i < $memberCount; $i++)
            {
                //$wh .= "members like '" . $arr_teammembers[$i] . "%' or ";
                //$wh .= "members like \"%" . $arr_teammembers[$i] . "%\" or ";
                $wh .= "members like \"%" . substr($arr_teammembers[$i], 0, $matchNum3) . "%\" or ";
                $wh .= "captain like \"%" . substr($arr_teammembers[$i], 0, $matchNum3) . "%\" or ";
            }
            $wh .= "captain like \"%" . substr($teamcaptain, 0, $matchNum2) . "%\" or ";
            if (substr($teamname, 0, 4) == "the " || substr($teamname, 0, 4) == "The ")
                $wh .= "MID(team_name, 5, LENGTH(team_name)-1) like \"" . substr(substr($teamname, 4), 0, $matchNum1) . "%\"";
            else
                $wh .= "team_name like \"" . substr($teamname, 0, $matchNum1) . "%\"";
            $wh .= ")";
            $this->db->where($wh);
        }
        //var_dump($wh);
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }
}