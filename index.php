<?php 
    require_once 'data/config.php';
    require_once 'controller/autorun.php';
    $controller = new \Controller\RecipeListApp(Config::$modelType, Config::$viewType);
    $controller->run();
?>
