<?php

class Route {
    static function start() {
        $controller_name = 'main';
        $action_name = 'main';

        $uri = explode("?",$_SERVER['REQUEST_URI']);
        $routes = explode('/', $uri[0]);
        if (!empty($routes[1])) $controller_name = $routes[1];
        if (!empty($routes[2])) $action_name = $routes[2];

        $model_name = 'model_' . $controller_name;
        $controller_name = 'controller_' . $controller_name;

        // подключение модели
        $model_file = strtolower($model_name) . '.php';
        $model_path = "app/models/" . $model_file;
        if (file_exists($model_path))
            include $model_path;

        // подключение контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "app/controllers/" . $controller_file;
        if (file_exists($controller_path))
            include "app/controllers/" . $controller_file;
        else Route::NotFound();

        // создаем контроллер
        $controller = new $controller_name;

        if (method_exists($controller, $action_name)) $controller->$action_name();
        else throw new Exception("Not found action '".$action_name."' in the '".$controller_name."'");
    }

    static function NotFound() {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        include "app/controllers/controller_404.php";
    }
}
