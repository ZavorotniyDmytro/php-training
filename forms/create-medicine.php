<?php
    include(__DIR__ . "/../auth/check-auth.php");
    
    if ($_POST) {
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        $myModel->setCurrentUser($_SESSION['user']);

        $medicine = (new \Model\Medicine())
            ->setRecipeId($_GET['recipe'])
            ->setName($_POST['name'])
            ->setDosage($_POST['dosage'])
            ->setForm($_POST['form'])
            ->setRecovered($_POST['recovered']);
        if (!$myModel->addMedicine($medicine)) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?recipe=' . $_GET['recipe']);
        }
    }

    require_once '../view/autorun.php';
    $myView = \View\RecipeListView::makeView(\View\RecipeListView::SIMPLEVIEW);
    $myView->showMedicineCreateForm();
?>