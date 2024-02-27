<?php 
    require('auth/check-auth.php');

    require_once 'model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    require_once 'view/autorun.php';
    $myView = \View\RecipeListView::makeView(\View\RecipeListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());

    $recipes = array();
    if($myModel->checkRight('recipe', 'view')) {
        $recipes = $myModel->readRecipes();
    }
    $recipe = new \Model\Recipe();
    if(!isset($_GET['recipe'])) {
        $_GET['recipe'] = 'recipe-01';
    }
    if (isset($_GET['recipe']) && $myModel->checkRight('recipe', 'view')) {
        $recipe = $myModel->readRecipe($_GET['recipe']);
    }
    $medicines = array();
    if (isset($_GET['recipe']) && $myModel->checkRight('medicine', 'view')) {
        $medicines = $myModel->readMedicines($_GET['recipe']);
    }
    $myView->showMainForm($recipes, $recipe, $medicines);
?>
