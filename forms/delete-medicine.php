<?php
    include(__DIR__ . "/../auth/check-auth.php");

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    
    $medicine = (new \Model\Medicine())->setId($_GET['file'])->setRecipeId($_GET['recipe']);
    if (!$myModel->removeMedicine($medicine)) {
        die($myModel->getError());
    } else {
        header('Location: ../index.php?recipe=' . $_GET['recipe']);
    }
?>