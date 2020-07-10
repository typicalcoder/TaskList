<?php

class Controller_Main extends Controller
{
    function __construct() {
        parent::__construct();
        $this->model = new Model_Main();
        $this->view = new View();
    }

	function main() {
	    $count = $this->model->countTasks();
	    $tpp = 3;
        $page = isset($_GET["p"]) ? (int) $_GET["p"] : 1;
        $max_page = ceil($count/$tpp);
        if($page > 1 && $page > $max_page) header("Location: /404");
        $sorter = isset($_GET["s"]) ? $_GET["s"] : NULL;
        $direction = isset($_GET["d"]) ? $_GET["d"] : 1;
	    $tasks = $this->model->getTasks($tpp, ($page-1)*$tpp, $sorter, $direction);
		$this->view->generate(
		    'main',
            'layout',
            array(
                "tasks" => $tasks,
                "params" => array(
                    "max_page" => $max_page,
                    "page" => $page,
                    "perpage" => $tpp,
                    "count" => $count,
                    "sorter" => $sorter,
                    "direction" => $direction
                )
            )
        );
	}

	function addTask() {
        $nameInput = isset($_POST["name"]) ? $_POST["name"] : NULL;
        $emailInput = isset($_POST["email"]) ? $_POST["email"] : NULL;
        $text = isset($_POST["text"]) ? $_POST["text"] : NULL;

        if($nameInput != NULL && $emailInput != NULL && $text != NULL) {
            $this->model->addNewTask($nameInput, $emailInput, $text);
            header("Location: /");
        } else echo "Something went wrong!";
    }


}