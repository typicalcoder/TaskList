<?php

class Controller_Auth extends Controller{

    function __construct() {
        parent::__construct();
        $this->model = new Model_Auth();
    }

	function start() {
        $loginInput = isset($_POST["login"]) ? $_POST["login"] : NULL;
        $passInput = isset($_POST["pass"]) ? $_POST["pass"] : NULL;

        if($loginInput != NULL && $passInput != NULL) {
            $res = $this->model->getUser($loginInput, $passInput);
            if($res) {
                Session::set("loggedIn", true);
                Session::set("username", $res['username']);
                Session::set("uid", $res['id']);
                echo "OK";
            } else echo "ERROR";
        }
	}

	function logout() {
        if(Session::get("loggedIn")) {
            Session::destroy();
        }
        header("Location: /");
	}

	function editTask() {
        $taskId = isset($_POST["task"]) ? $_POST["task"] : NULL;
        $status = isset($_POST["status"]) ? $_POST["status"] : NULL;
        $text = isset($_POST["text"]) ? htmlspecialchars($_POST["text"]) : NULL;
        if($taskId != NULL && $text != NULL && Session::get("loggedIn")) {
            $old = $this->model->getTask($taskId);
            $mark = ($old['text_field'] != $text || $old['modified'] == "1") ? 1 : 0;
            $res = $this->model->updateTask($taskId, $status, $text, $mark);
            if($res)
                header("Location: /");
            else
                echo "ERROR";
        }
        echo "ACCESS DENIED";
    }

	function getTaskInfo() {
        $taskId = isset($_POST["task"]) ? $_POST["task"] : NULL;
        if($taskId != NULL && Session::get("loggedIn")) {
            $res = $this->model->getTask($taskId);
            header("Content-type: application/json; charset=utf-8");
            if($res) {
                $res['text_field'] = htmlspecialchars_decode($res["text_field"]);
                echo json_encode($res);
            }
            else echo json_encode( array( "status" => "ERROR" ) );
        }
    }
}