<?php

class Model_Auth extends Model
{

    public function getUser($user, $pass) {
        $raw = $this->db->query("SELECT id, username FROM `users` WHERE username='?s' AND password='?s' LIMIT 1;", $user, $pass);
        if($raw->getNumRows() == 0) return false;
        $data = $raw->fetch_assoc_array();
        return $data[0];
	}

    public function getTask($id) {
        $raw = $this->db->query("SELECT id, text_field, status, modified FROM `tasks` WHERE id=?i LIMIT 1;", $id);
        if($raw->getNumRows() == 0) return false;
        $data = $raw->fetch_assoc_array();
        return $data[0];
	}

	public function updateTask($taskId, $status, $text, $mark) {
        if($this->db->query("UPDATE `tasks` SET `text_field`='?s', `status`=?i, `modified`=?i WHERE `id`=?i LIMIT 1",$text, $status, $mark, $taskId)) return true;
        else return false;
    }

}
