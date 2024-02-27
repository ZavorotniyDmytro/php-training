<?php
    include(__DIR__ . "/../auth/check-auth.php");

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    
    if ($_POST) {
        $medicine = (new \Model\Medicine())
            ->setId($_GET['file'])
            ->setRecipeId($_GET['recipe'])
            ->setName($_POST['name'])
            ->setDosage($_POST['dosage'])
            ->setForm($_POST['form'])
            ->setRecovered($_POST['recovered']);
        if (!$myModel->writeMedicine($medicine)) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?recipe=' . $_GET['recipe']);
        }
    }
    $medicine = $myModel->readMedicine($_GET['recipe'], $_GET['file']);

    require_once '../view/autorun.php';
    $myView = \View\RecipeListView::makeView(\View\RecipeListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());
    $myView->showMedicineEditForm($medicine);
?>