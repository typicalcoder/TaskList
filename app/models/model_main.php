<?php

class Model_Main extends Model
{


    /**
     * @param int $limit лимит получаемых записей
     * @param int $offset отступ
     * @param null $sorter поле по которому сортируем
     * @param int $direction по возрастанию (ASC) - 0; по убыванию (DESC) - 1.
     * @return array массив, содержащий задачи
     * @throws Database_Mysql_Exception
     */
    public function getTasks($limit, $offset = 0, $sorter = NULL, $direction = 0) {
        $direction = ($direction == 0) ? "ASC" : "DESC";
        if(!empty($sorter)) {
            $raw = $this->db->query("SELECT id, name_field, timestamp, email_field, text_field, status, modified FROM `tasks` ORDER BY ?f ".$direction." LIMIT ?i OFFSET ?i", $sorter, $limit, $offset);
            $data = $raw->fetch_assoc_array();
        } else {
            $raw = $this->db->query("SELECT id, name_field, timestamp, email_field, text_field, status, modified FROM `tasks` ORDER BY timestamp ".$direction." LIMIT ?i OFFSET ?i", $limit, $offset);
            $data = $raw->fetch_assoc_array();
        }
        return $data;
	}


    public function addNewTask($name_field, $email_field, $text_field) {
        $sql_str = "INSERT INTO `tasks` (`name_field`, `email_field`, `text_field`) VALUES( '?s', '?s','?s' );";
        if(!$this->db->query($sql_str,$name_field,$email_field,$text_field)) return false;
        return true;
    }

    public function countTasks() {
        $raw = $this->db->query("SELECT id FROM `tasks`");
        return $raw->getNumRows();
    }


}
