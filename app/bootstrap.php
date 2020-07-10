<?php

    require_once 'config.php';

    require_once 'libs/mysql/Mysql.php';
    require_once 'libs/mysql/Mysql/Exception.php';
    require_once 'libs/mysql/Mysql/Statement.php';

    // Ядро
    require_once 'core/model.php';
    require_once 'core/view.php';
    require_once 'core/controller.php';
    require_once 'core/session.php';

    // Роутер
    require_once 'core/route.php';

    Session::init();
    try {
        Route::start();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
