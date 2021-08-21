<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Challenge_model extends CI_Model
{
    private $_tablename = 'challenges';
    private $_tablename2 = 'challenge_types';
    private $_tablename3 = 'challenge_judge';
    private $_tablename4 = 'chg_databank';

    public function getAllChallengeTypes()
    {
        $this->db->where('is_active = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename2);    
        return $query->result();
    }

    public function getChallengeTypeInfo($typeId)
    {
        $this->db->where('id', $typeId);
        $query = $this->db->get($this->_tablename2);
        return $query->row();
    }

    public function getChallengeInfo($challengeId)
    {
        $this->db->where('id', $challengeId);
        $query = $this->db->get($this->_tablename);
        return $query->row();
    }

    public function getChallengeCountByHunt($huntId)
    {
        $this->db->where('hunt_id', $huntId);
        $this->db->where('status_id = 1');
        $this->db->from($this->_tablename);
        return $this->db->count_all_results();
    }

    public function getChallengesByHunt($huntId)
    {
        $this->db->where('hunt_id', $huntId);
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function getPhotoVideoChallengesByHunt($huntId)
    {   
        $typeIds = array(1,5);
        $this->db->where('hunt_id', $huntId);
        $this->db->where_in('chg_type_id', $typeIds);
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function getOtherChallengesByHunt($huntId)
    {   
        $typeIds = array(2,3,4);
        $this->db->where('hunt_id', $huntId);
        $this->db->where_in('chg_type_id', $typeIds);
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename);
        return $query->result();
    }

    public function getCurrentChallengeByHunt($huntId, $curChgNum)
    {
        $this->db->where('hunt_id', $huntId);
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1, $curChgNum);
        $query = $this->db->get($this->_tablename);
        $result = $query->result();
        if (count($result) > 0)
            return $result[0];
        else
            return NULL;
    }

    public function getLeaderBoardByHunt($huntId, $gameCodeId) {
        $sql0 = "SELECT gm.team_id,
                    IF(teams.players_count=1, CONCAT('Room ', teams.room_id), teams.team_name) AS team_name,
                    SUM(ju.points) AS points
                FROM challenge_judge AS ju
                LEFT JOIN hunt_gamecode AS gm ON ju.gamecode_id = gm.id
                LEFT JOIN teams ON teams.id = gm.team_id
                WHERE ju.hunt_id = $huntId
                GROUP BY ju.gamecode_id 
                ORDER BY points DESC
                LIMIT 0, 10";
        $result = $this->db->query($sql0)->result();

        $sql1 = "SELECT gm.team_id,
                    IF(teams.players_count=1, CONCAT('Room ', teams.room_id), teams.team_name) AS team_name,
                    SUM(ju.points) AS points
                FROM teams
                LEFT JOIN hunt_gamecode AS gm ON teams.id = gm.team_id
                LEFT JOIN (SELECT * FROM challenge_judge WHERE hunt_id = $huntId) AS ju ON ju.gamecode_id = gm.id
                WHERE gm.id = $gameCodeId
                GROUP BY gm.id";
        $curTeamLeaderPoints = $this->db->query($sql1)->row();
        if(!$curTeamLeaderPoints->points)
            $curTeamLeaderPoints->points = 0;
        array_push($result, $curTeamLeaderPoints);

        return $result;
    }
    public function getLeaderBoardByTeam($huntId, $teamId) {
        $this->db->select("ju.chg_id, ch.chg_name, ch.points, ju.points AS earned_points, ju.status_id");
        $this->db->from("challenge_judge AS ju");
        $this->db->join("challenges AS ch", "ju.chg_id = ch.id", "LEFT");
        $this->db->join("hunt_gamecode AS gc", "ju.gamecode_id = gc.id", "LEFT");
        $this->db->where("ju.hunt_id", $huntId);
        $this->db->where("gc.team_id", $teamId);
        $query = $this->db->get();
        return $query->result();
    }
    public function getTotalPointsByHunt($huntId) {
        $this->db->select("SUM(points) as points");
        $this->db->from("challenges");
        $this->db->where("hunt_id", $huntId);
        $query = $this->db->get();

        return $query->row();
    }
    public function isJudgeGamesForCheck(){
        $this->db->select("COUNT(*) as count");
        $this->db->where('status_id = 1');
        $this->db->from($this->_tablename3);
        $query = $this->db->get();

        return $query->result();
    }
    public function getOldestSubmittedChallenge(){
        $this->db->select("ju.id, ju.chg_id, ju.chg_result, ju.submitted, chg.chg_name, chg.chg_type_id AS chg_type, chg.puzzle_page, chg.points, teams.team_name");
        $this->db->from($this->_tablename3." AS ju");
        $this->db->join($this->_tablename." AS chg", "ju.chg_id = chg.id", "LEFT");
        $this->db->join("hunt_gamecode AS gm", "ju.gamecode_id = gm.id", "LEFT");
        $this->db->join("teams", "gm.team_id = teams.id", "LEFT");
        $this->db->where("ju.status_id = 1");
        $this->db->order_by("ju.submitted ASC");
        $this->db->limit(1, 0);
        $query = $this->db->get();
        $a = $this->db->last_query();
        
        return $query->row();
    }
    public function getSubmittedResults($huntId, $gamecodeId, $challengeId)
    {
        $this->db->where('hunt_id', $huntId);
        $this->db->where('gamecode_id', $gamecodeId);
        $this->db->where('chg_id', $challengeId);
        $this->db->where('status_id != 3');
        $query = $this->db->get($this->_tablename3);
        return $query->result();
    }

    public function getChallengeResult($gameCodeId, $huntId, $challengeId)
    {
        $this->db->where('gamecode_id', $gameCodeId);
        $this->db->where('hunt_id', $huntId);
        $this->db->where('chg_id', $challengeId);
        $this->db->where('(status_id = 1 OR status_id = 2)');
        $query = $this->db->get($this->_tablename3);
        return $query->row();
    }

    public function checkAlreadySubmitted($gameCodeId, $challengeId)
    {
        $this->db->where('gamecode_id', $gameCodeId);
        $this->db->where('chg_id', $challengeId);
        $this->db->where('chg_result != ""');
        $this->db->where('(status_id = 1 OR status_id = 2)');
        $query = $this->db->get($this->_tablename3);
        $result = $query->row();
        if (isset($result))
            return true;
        else
            return false;
    }

    public function insertChallenge($challengeInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename, $challengeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function editChallenge($challengeInfo, $challengeId)
    {
        $this->db->where('id', $challengeId);
        $this->db->update($this->_tablename, $challengeInfo);
        return TRUE;
    }

    public function deleteChallenge($challengeId)
    {
        $deleted = date('Y-m-d H:i:s');
        $chgInfo = array(
            'status_id' => 4,
            'deleted' => $deleted
        );
        $this->db->where('id', $challengeId);
        $this->db->update($this->_tablename, $chgInfo);
        return TRUE;
        //$this->db->delete($this->_tablename);
        //return $this->db->affected_rows();
    }

    public function copyChallenge($chgInfo)
    {
        $created = date('Y-m-d H:i:s');
        $newChgInfo = array(
            'hunt_id' => $chgInfo->hunt_id,
            'chg_name' => $chgInfo->chg_name,
            'description' => $chgInfo->description,
            'points' => $chgInfo->points,
            'puzzle_page' => $chgInfo->puzzle_page,
            'puzzle_answer' => $chgInfo->puzzle_answer,
            'multi_answer' => $chgInfo->multi_answer,
            'chg_type_id' => $chgInfo->chg_type_id,
            'chg_image' => $chgInfo->chg_image,
            'chg_image2' => $chgInfo->chg_image2,
            'chg_link' => $chgInfo->chg_link,
            'status_id' => $chgInfo->status_id,
            'created' => $created
        );
        $result = $this->insertChallenge($newChgInfo);
        return $result;
    }

    public function insertChallengeResult($judgeInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename3, $judgeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function editChallengeResult($judgeInfo, $chgResultId)
    {
        $this->db->where('id', $chgResultId);
        $this->db->update($this->_tablename3, $judgeInfo);
        return TRUE;
    }
    
    public function deleteResultByChallengeId($challengeId)
    {
        $deleted = date('Y-m-d H:i:s');
        $judgeInfo = array(
            'status_id' => 3,
            'deleted' => $deleted
        );
        $this->db->where('chg_id', $challengeId);
        $this->db->update($this->_tablename3, $judgeInfo);
        return TRUE;
    }

    public function getTeamsForJudge($gameCodeIds, $huntIds)
    {
        $this->db->select('player_id, gamecode_id, hunt_id, SUM(status_id) as status');
        $this->db->where_in('gamecode_id', $gameCodeIds);
        $this->db->where_in('hunt_id', $huntIds);
        $this->db->where('status_id != 3');
        $this->db->group_by("player_id, gamecode_id, hunt_id");
        $query = $this->db->get($this->_tablename3);
        return $query->result();
    }

    public function getChallengesFromDataBank()
    {
        $this->db->where('status_id = 1');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->_tablename4);
        return $query->result();
    }

    public function getChallengeDBInfo($challengeId)
    {
        $this->db->where('id', $challengeId);
        $query = $this->db->get($this->_tablename4);
        return $query->row();
    }

    public function insertChallengeDB($challengeInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_tablename4, $challengeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function editChallengeDB($challengeInfo, $challengeId)
    {
        $this->db->where('id', $challengeId);
        $this->db->update($this->_tablename4, $challengeInfo);
        return TRUE;
    }

    public function deleteChallengeDB($challengeId)
    {
        $deleted = date('Y-m-d H:i:s');
        $chgInfo = array(
            'status_id' => 4,
            'deleted' => $deleted
        );
        $this->db->where('id', $challengeId);
        $this->db->update($this->_tablename4, $chgInfo);
        return TRUE;
        //$this->db->delete($this->_tablename);
        //return $this->db->affected_rows();
    }

    public function copyChallengeDB($chgInfo)
    {
        $created = date('Y-m-d H:i:s');
        $newChgInfo = array(
            'chg_name' => $chgInfo->chg_name,
            'description' => $chgInfo->description,
            'points' => $chgInfo->points,
            'puzzle_page' => $chgInfo->puzzle_page,
            'puzzle_answer' => $chgInfo->puzzle_answer,
            'multi_answer' => $chgInfo->multi_answer,
            'chg_type_id' => $chgInfo->chg_type_id,
            'chg_image' => $chgInfo->chg_image,
            'chg_image2' => $chgInfo->chg_image2,
            'chg_link' => $chgInfo->chg_link,
            'status_id' => $chgInfo->status_id,
            'created' => $created
        );
        $result = $this->insertChallengeDB($newChgInfo);
        return $result;
    }

    public function copyChallengeDBToHunt($chgInfo, $huntId)
    {
        $created = date('Y-m-d H:i:s');
        $newChgInfo = array(
            'hunt_id' => $huntId,
            'chg_name' => $chgInfo->chg_name,
            'description' => $chgInfo->description,
            'points' => $chgInfo->points,
            'puzzle_page' => $chgInfo->puzzle_page,
            'puzzle_answer' => $chgInfo->puzzle_answer,
            'multi_answer' => $chgInfo->multi_answer,
            'chg_type_id' => $chgInfo->chg_type_id,
            'chg_image' => $chgInfo->chg_image,
            'chg_image2' => $chgInfo->chg_image2,
            'chg_link' => $chgInfo->chg_link,
            'status_id' => $chgInfo->status_id,
            'created' => $created
        );
        $result = $this->insertChallenge($newChgInfo);
        return $result;
    }
}