<?php 
    require('controller/autorun.php');
    $controller = new \Controller\RecipeListApp(\Model\Data::FILE, \View\RecipeListView::SIMPLEVIEW);
    $controller->run();
?>
