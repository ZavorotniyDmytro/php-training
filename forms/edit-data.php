<?php 
    include(__DIR__ . "/../auth/check-auth.php");

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    
    if ($_POST) {
        if (!$myModel->writeRecipe((new \Model\Recipe())
            ->setId($_GET['recipe'])
            ->setPatient($_POST['patient'])
            ->setBorn($_POST['born'])
            ->setDoctor($_POST['doctor'])
        )) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?recipe=' . $_GET['recipe']);
        }
    }
    if (!$recipe = $myModel->readRecipe($_GET['recipe'])) {
        die($myModel->getError());
    }

    require_once '../view/autorun.php';
    $myView = \View\RecipeListView::makeView(\View\RecipeListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());
    $myView->showRecipeEditForm($recipe);
?>