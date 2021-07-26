<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Room_model extends CI_Model
{
    private $_tablename = 'zoom_rooms';
    private $_tablename2 = 'zoom_rooms_log';

    private $_tablename3 = 'teams';
    private $_tablename4 = 'players';

    public function addNewZoomRoom($roomInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $roomInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    public function deleteZoomRoom($roomId)
    {
        $this->db->where('zoom_account_id', $roomId);
        $this->db->delete($this->_tablename);
        
        return $this->db->affected_rows();
    }

    public function editZoomRoom($roomInfo, $roomId)
    {
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $roomInfo);
        return TRUE;
    }

    public function updateRoom($roomInfo, $roomId)
    {
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $roomInfo);
        return TRUE;
    }

    public function getRoomId($accountId, $roomNo)
    {
        $this->db->where('zoom_account_id', $accountId);
        $this->db->where('room_no', $roomNo);
        $query = $this->db->get($this->_tablename);
        $result = $query->row();
        if (isset($result))
            return $result->id;
        else
            return "0";
    }

    public function getRoomInfo($roomId)
    {
        $this->db->where('id', $roomId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function getTeamIdByRoomId($roomId)
    {
        $statusIds = array(2,4);
        $this->db->where('room_id', $roomId);
        $this->db->where_in('status_id', $statusIds);
        $query = $this->db->get($this->_tablename2);
        $result = $query->row();
        if (isset($result))
            return $result->team_id;
        else
            return "0";
    }

    public function getSoloTeamIdByRoomId($roomId)
    {
        $statusIds = array(3,4);
        $this->db->where('room_id', $roomId);
        $this->db->where_in('status_id', $statusIds);
        $query = $this->db->get($this->_tablename2);
        $result = $query->row();
        if (isset($result))
            return $result->team_id;
        else
            return "0";
    }

    public function getRoomLogId2($roomId, $teamId)
    {
        $statusIds = array(2,3,4);
        $this->db->where('room_id', $roomId);
        $this->db->where('team_id', $teamId);
        $this->db->where_in('status_id', $statusIds);
        
        $query = $this->db->get($this->_tablename2);
        $result = $query->row();
        if (isset($result))
            return $result->id;
        else
            return "0";
    }

    public function getZoomRoomInfo($roomId)
    {
        $this->db->select('RoomTbl.*, AccountTbl.account_name');
        $this->db->from($this->_tablename . ' as RoomTbl');
        $this->db->join('zoom_account as AccountTbl', 'RoomTbl.zoom_account_id = AccountTbl.id','left');
        $this->db->where('RoomTbl.id', $roomId);
        $query = $this->db->get();
        return $query->row();
    }

    public function addNewRoomLog($logInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename2, $logInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getRoomLogInfo($roomLogId)
    {
        $this->db->where('id', $roomLogId);
        $query = $this->db->get($this->_tablename2);
        return $query->row();
    }

    public function getRoomLogs($roomId, $statusId)
    {
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id', $statusId);
        $query = $this->db->get($this->_tablename2);
        return $query->result();
    }

    public function getTeamsByRoomId($roomId)
    {
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id != 5');
        $query = $this->db->get($this->_tablename2);
        return $query->result();
    }

    public function updateRoomLog($logInfo, $logId)
    {
        $this->db->where('id', $logId);
        $this->db->update($this->_tablename2, $logInfo);
    }

    public function deleteRoomLog($logId)
    {
        $this->db->where('id', $logId);
        $this->db->delete($this->_tablename2);
        return TRUE;
    }

    public function deleteRoomLogByRoomId($roomId)
    {
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id != 5');
        $this->db->delete($this->_tablename2);
        return TRUE;
    }

    public function searchSameRoomLog($roomId, $teamId, $statusId)
    {
        $this->db->where('room_id', $roomId);
        $this->db->where('team_id', $teamId);
        $this->db->where('status_id', $statusId);
        $query = $this->db->get($this->_tablename2);
        $result = $query->row();
        if (isset($result))
            return $result->id;
        else
            return "0";
    }

    public function assignAutoVacantRoom($zoomAccountId, $schoolId, $playersNum)
    {
        $ret = "0";
        $this->db->where('zoom_account_id', $zoomAccountId);
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        $result = $query->result();
        if (isset($result))
        {
            foreach ($result as $record)
            {
                if (intval($record->school_id) == intval($schoolId) || intval($record->school_id) == 0)
                {
                    $pcount = $this->getTeamPlayersNumInRoom($record->id, $schoolId);
                    if ($pcount == 0)
                    {
                        $ret = $record->id;
                        $this->setRoomOccupied($ret, $schoolId);
                        break;
                    }
                }
            }
        }
        return $ret;
    }

    public function assignAutoSoloVacantRoom($zoomAccountId, $schoolId, $playersNum)
    {
        $ret = "0";
        $statusIds = array(1,3);
        $this->db->where('zoom_account_id', $zoomAccountId);
        $this->db->where_in('status_id', $statusIds);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        $result = $query->result();
        if (isset($result))
        {
            foreach ($result as $record)
            {
                if (intval($record->school_id) == intval($schoolId) || intval($record->school_id) == 0)
                {
                    $pcount = $this->getTeamPlayersNumInRoom($record->id, $schoolId);
                    if ($record->status_id == '3')
                    {
                        if ($pcount + $playersNum < 10)
                        {
                            $ret = $record->id;
                            break;
                        }
                        else if ($pcount + $playersNum == 10)
                        {
                            $ret = $record->id;
                            //$this->setRoomOccupied($ret, $schoolId);
                            break;
                        }
                    }
                    else if ($record->status_id == '1')
                    {
                        if ($pcount == 0)
                        {
                            $ret = $record->id;
                            $this->setRoomSoloVacant($ret, $schoolId);
                            break;
                        }
                    }
                }
            }
        }
        return $ret;
    }

    public function getRoomSchoolIdsByAccount($accountId)
    {
        $this->db->where("zoom_account_id", $accountId);
        $this->db->where("status_id != 5");
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    public function getOccupiedRoomsByAccount($accountId)
    {
        $this->db->where("zoom_account_id", $accountId);
        $this->db->where("status_id != 1");
        $this->db->where("status_id != 5");
        $query = $this->db->get($this->_tablename);    
        return $query->result();
    }

    public function getTeamPlayersNumInRoom($roomId, $schoolId)
    {
        $this->db->select('SUM(players_count) as pcount');
        $this->db->where('school_id', $schoolId);
        $this->db->where('room_id', $roomId);
        $this->db->where('status_id = 1');
        $query = $this->db->get($this->_tablename3);
        $result = $query->row();
        return intval($result->pcount);
    }

    public function reconfigureRoom($oldAccountId, $accountId, $schoolId)
    {
        $this->db->where('zoom_account_id', $oldAccountId);
        $this->db->where('school_id', $schoolId);
        $query = $this->db->get($this->_tablename);    
        $result = $query->result();
        //var_dump($oldAccountId . " -> " . $accountId . " -> " . $schoolId);
        //var_dump($result);
        
        foreach($result as $record)
        {
            $this->db->where('room_id', $record->id);
            $this->db->where('status_id != 5');
            $query3 = $this->db->get($this->_tablename2);
            $result3 = $query3->result();
            //var_dump($result3);
            foreach ($result3 as $record3)
            {
                $this->db->where('id', $record3->team_id);
                $this->db->where('status_id != 3');
                $query4 = $this->db->get($this->_tablename3);
                $teamInfo = $query4->row();
                if (!isset($teamInfo))
                    $playersNum = 1;
                else
                    $playersNum = intval($teamInfo->players_count);
                if ($playersNum <= 2)
                {
                    $newRoomId = $this->assignAutoSoloVacantRoom($accountId, $schoolId, $playersNum);
                }
                else
                {
                    $newRoomId = $this->assignAutoVacantRoom($accountId, $schoolId, $playersNum);    
                }
                
                //var_dump($record3->team_id . " -> " . $playersNum . " -> " . $newRoomId);
                $updateInfo = array('status_id' => $record->status_id, 'school_id' => $schoolId);
                $this->updateRoom($updateInfo, $newRoomId);

                $updateInfo2 = array('room_id' => $newRoomId);
                $this->db->where('id', $record3->team_id);
                $this->db->update($this->_tablename3, $updateInfo2);

                $updateInfo3 = array('room_id' => $newRoomId);
                $this->db->where('team_id', $record3->team_id);
                $this->db->where('room_id', $record3->room_id);
                $this->db->update($this->_tablename4, $updateInfo3);

                $updateInfo4 = array('room_id' => $newRoomId);
                $this->updateRoomLog($updateInfo4, $record3->id);
            }
            
            $updateInfo5 = array('status_id' => 1, 'school_id' => 0);
            $this->updateRoom($updateInfo5, $record->id);
        }
        //exit;
    }   

    public function setRoomVacant($roomId)
    {
        $data = array('status_id' => '1', 'school_id' => '0');
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $data);
    }

    public function setRoomOccupied($roomId, $schoolId)
    {
        $data = array('status_id' => '2', 'school_id' => $schoolId);
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $data);
    }

    public function setRoomSoloVacant($roomId, $schoolId)
    {
        $data = array('status_id' => '3', 'school_id' => $schoolId);
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $data);
    }

    public function setSoloRoomClosed($roomId, $schoolId)
    {
        $data = array('status_id' => '4', 'school_id' => $schoolId);
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $data);

        $this->db->where('room_id', $roomId);
        $this->db->where('school_id', $schoolId);
        $this->db->where('status_id != 5');
        $query = $this->db->get($this->_tablename2);
        $result = $query->result();

        foreach ($result as $record)
        {
            $data2 = array('status_id' => '4', 'school_id' => $schoolId);
            $this->db->where('id', $record->id);
            $this->db->update($this->_tablename2, $data2);
        }
    }

    public function setRoomNeedHelp($roomId, $chkHelp)
    {
        if (intval($chkHelp) == 1)
        {
            $data = array('status_id' => '6');
        }
        else
        {
            $data = array('status_id' => '4');
        }
        $this->db->where('id', $roomId);
        $this->db->update($this->_tablename, $data);
    }
}