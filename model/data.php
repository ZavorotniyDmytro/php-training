<?php
namespace Model;

abstract class Data {
    const FILE = 0;

    private $error;
    private $user;

    public function setCurrentUser($username) {
        $this->user = $this->readUser($username);
    }

    public function getCurrentUser() {
        return $this->user;
    }

    public function checkRight($object, $right) {
        return $this->user->checkRight($object, $right);
    }

    public function readMedicines($recipeId) {
        if ($this->user->checkRight('medicine', 'view')) {
            $this->error = "";
            return $this->getMedicines($recipeId);
        } else {
            $this->error = "You have no permissions to view medicines";
            return false;
        }
    }
    protected abstract function getMedicines($recipeId);

    public function readMedicine($recipeId, $id) {
        if ($this->user->checkRight('medicine', 'view')) {
            $this->error = "";
            return $this->getMedicine($recipeId, $id);
        } else {
            $this->error = "You have no permissions to view medicine";
            return false;
        }
    }
    protected abstract function getMedicine($recipeId, $id);

    public function readRecipes() {
        if ($this->checkRight('recipe', 'view')) {
            $this->error = "";
            return $this->getRecipes();            
        } else {
            $this->error = "You have no permission to view recipes";
            return false;
        }
    }
    protected abstract function getRecipes();

    public function readRecipe($id) {
        if ($this->checkRight('recipe', 'view')) {
            $this->error = "";
            return $this->getRecipe($id);            
        } else {
            $this->error = "You have no permission to view recipe";
            return false;
        }
    }
    protected abstract function getRecipe($id);

    public function readUsers() {
        if ($this->checkRight('user', 'admin')) {
            $this->error = "";
            return $this->getUsers();            
        } else {
            $this->error = "You have no permission to administrate users";
            return false;
        }
    }
    protected abstract function getUsers();

    public function readUser($id) {
        $this->error = "";
        return $this->getUser($id);
    }
    protected abstract function getUser($id);

    public function writeMedicine(Medicine $medicine) {
        if ($this->checkRight('medicine', 'edit')) {
            $this->error = "";
            $this->setMedicine($medicine);
            return true;
        } else {
            $this->error = "You have no permissions to edit medicineds";
            return false;
        }
    }
    protected abstract function setMedicine(Medicine $medicine);

    public function writeRecipe(Recipe $recipe) {
        if ($this->checkRight('recipe', 'edit')) {
            $this->error = "";
            $this->setRecipe($recipe);
            return true;
        } else {
            $this->error = "You have no permissions to edit recipes";
            return false;
        }
    }
    protected abstract function setRecipe(Recipe $recipe);

    public function writeUser(User $user) {
        if ($this->checkRight('user', 'admin')) {
            $this->error = "";
            $this->setUser($user);
            return true;
        } else {
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }
    protected abstract function setUser(User $user);

    public function removeMedicine(Medicine $medicine) {
        if ($this->checkRight('medicine', 'delete')) {
            $this->error = "";
            $this->delMedicine($medicine);
            return true;
        } else {
            $this->error = "You have no permissions to delete medicines";
            return false;
        }
    }
    protected abstract function delMedicine(Medicine $medicine);

    public function addMedicine(Medicine $medicine) {
        if ($this->checkRight('medicine', 'create')) {
            $this->error = "";
            $this->insMedicine($medicine);
            return true;
        } else {
            $this->error = "You have no permissions to create medicines";
            return false;
        }
    }
    protected abstract function insMedicine(Medicine $medicine);

    public function removeRecipe($recipeId) {
        if ($this->checkRight('recipe', 'delete')) {
            $this->error = "";
            $this->delRecipe($recipeId);
            return true;
        } else {
            $this->error = "You have no permissions to delete recipes";
            return false;
        }
    }
    protected abstract function delRecipe($recipeId);

    public function addRecipe () {
        if ($this->checkRight('recipe', 'create')) {
            $this->error = "";
            $this->insRecipe();
            return true;
        } else {
            $this->error = "You have no permissions to create recipes";
            return false;
        }
    }
    protected abstract function insRecipe();

    public function getError() {
        if ($this->error) {
            return $this->error;
        }
        return false;
    }

    public static function makeModel($type) {
        if ($type == self::FILE) {
            return new FileData();
        }
        return new FileData();
    }
}
?>