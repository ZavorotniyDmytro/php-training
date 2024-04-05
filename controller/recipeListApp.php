<?php

namespace Controller;

use Model\Data;
use View\RecipeListView;

class RecipeListApp {
    private $model;
    private $view;

    public function __construct($modelType, $viewType) {
        session_start();
        $this->model = Data::makeModel($modelType);
        $this->view = RecipeListView::makeView($viewType);
    }

    public function checkAuth() {
        if ($_SESSION['user']) {
            $this->model->setCurrentUser($_SESSION['user']);
            $this->view->setCurrentUser($this->model->getCurrentUser());
        } else {
            header('Location: ?action=login');
        }
    }

    public function run() {
        if(!isset($_GET['action']) || $_GET['action'] == '') $_GET['action'] = 'main'; 
        if(!in_array($_GET['action'], array('login', 'checkLogin'))) {
            $this->checkAuth();
        }
        if($_GET['action']) {
            switch ($_GET['action']) {
                case 'login':
                    $this->showLoginForm();
                    break;
                case 'checkLogin':
                    $this->checkLogin();
                    break;
                case 'logout':
                    $this->logout();
                    break;
                case 'create-recipe':
                    $this->createRecipe();
                    break;
                case 'edit-recipe-form':
                    $this->showEditRecipeForm();
                    break;
                case 'edit-recipe':
                    $this->editRecipe();
                    break;
                case 'delete-recipe':
                    $this->deleteRecipe();
                    break;
                case 'create-medicine-form':
                    $this->showCreateMedicineForm();
                    break;
                case 'create-medicine':
                    $this->createMedicine();
                    break;
                case 'edit-medicine-form':
                    $this->showEditMedicineForm();
                    break;
                case 'edit-medicine':
                    $this->editMedicine();
                    break;
                case 'delete-medicine':
                    $this->deleteMedicine();
                    break;
                case 'admin':
                    $this->adminUsers();
                    break;
                case 'edit-user-form':
                    $this->showEditUserForm();
                    break;
                case 'edit-user':
                    $this->editUser();
                    break;
                default:
                    $this->showMainForm();
            }
        } else {
            $this->showMainForm();
        }
    }
    private function showLoginForm() {
        $this->view->showLoginForm();
    }
    private function checkLogin() {
        if ($user = $this->model->readUser($_POST['username'])) {
            if($user->checkPassword($_POST['password'])) {
                session_start();
                $_SESSION['user'] = $user->getUserName();
                header('Location: index.php');
            }
        }
    }
    private function logout() {
        unset($_SESSION['user']);
        header('Location: ?action=login');
    }
    private function showMainForm() {
        $recipes = array();
        if ($this->model->checkRight('recipe', 'view')) {
            $recipes = $this->model->readRecipes();
        }
        $recipe = new \Model\Recipe();
        if(!isset($_GET['recipe'])) $_GET['recipe'] = 2;
        if($_GET['recipe'] && $this->model->checkRight('recipe', 'view')) {
            $recipe = $this->model->readRecipe($_GET['recipe']);
        }
        $medicines = array();
        if ($_GET['recipe'] && $this->model->checkRight('medicine', 'view')) {
            $medicines = $this->model->readMedicines($_GET['recipe']);
        }
        $this->view->showMainForm($recipes, $recipe, $medicines);
    }
    private function createRecipe() {
        if (!$this->model->addRecipe()) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }
    private function showEditRecipeForm() {
        if (!$recipe = $this->model->readRecipe($_GET['recipe'])) {
            die($this->model->getError());
        }
        $this->view->showRecipeEditForm($recipe);
    }
    private function editRecipe() {
        if (!$this->model->writeRecipe((new \Model\Recipe())
            ->setId($_GET['recipe'])
            ->setPatient($_POST['patient'])
            ->setBorn($_POST['born'])
            ->setDoctor($_POST['doctor'])
        )) {
            die($this->model->getError());
        } else {
            header('Location: index.php?recipe=' . $_GET['recipe']);
        }
    }
    private function deleteRecipe() {
        if (!$this->model->removeRecipe($_GET['recipe'])) {
            die($this->model->getError());
        } else {
            header('Location: index.php');
        }
    }
    private function showEditMedicineForm() {
        $medicine = $this->model->readMedicine($_GET['recipe'], $_GET['file']);
        $this->view->showMedicineEditForm($medicine);
    }
    private function editMedicine() {
        $medicine = (new \Model\Medicine())
                ->setId($_GET['file'])
                ->setName($_POST['name'])
                ->setDosage($_POST['dosage'])
                ->setForm($_POST['form'])
                ->setRecovered($_POST['recovered'])
                ->setRecipeId($_GET['recipe']);
        if (!$this->model->writeMedicine($medicine)) {
            die($this->model->getError());
        } else {
            echo $_GET['recipe'];
            header('Location: index.php?recipe=' . $_GET['recipe']);
        }
    }
    private function showCreateMedicineForm() {
        $this->view->showMedicineCreateForm();
    }
    private function createMedicine() {
        if ($_POST['recovered'] == 'on') $_POST['recovered'] = '1';
        $medicine = (new \Model\Medicine())
            ->setName($_POST['name'])
            ->setDosage($_POST['dosage'])
            ->setForm($_POST['form'])
            ->setRecovered($_POST['recovered'])
            ->setRecipeId($_GET['recipe']);
        if (!$this->model->addMedicine($medicine)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?recipe=' . $_GET['recipe']);
        }
    }
    private function deleteMedicine() {
        $medicine = (new \Model\Medicine())->setId($_GET['file'])->setRecipeId($_GET['recipe']);
        if (!$this->model->removeMedicine($medicine)) {
            die($this->model->getError());
        } else {
            header('Location: index.php?recipe=' . $_GET['recipe']);
        }
    }
    private function adminUsers() {
        $users = $this->model->readUsers();
        $this->view->showAdminForm($users);
    }
    private function showEditUserForm() {
        if(!$user = $this->model->readUser($_GET['username'])) {
            die($this->model->getError());
        } 
        $this->view->showUserEditForm($user);
    }
    private function editUser() {
        $rights = "";
        for($i=0; $i<9; $i++) {
            if($_POST['right' . $i]) {
                $rights .= "1";
            } else {
                $rights .= "0";
            }
        }
        $user = (new \Model\User())
            ->setUserName($_POST['user_name'])
            ->setPassword($_POST['user_pwd'])
            ->setRights($rights);
        if(!$this->model->writeUser($user)) {
            die($this->model->getError());
        } else {
            header('Location: ?action=admin ');
        }
    }
}
?>