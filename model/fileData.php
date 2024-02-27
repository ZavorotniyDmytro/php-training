<?php

namespace Model;

class FileData extends Data {
    const DATA_PATH = __DIR__ . '/../data/';
    const MEDICINE_FILE_TEMPLATE = '/^medicine-\d\d.txt\z/';
    const RECIPE_FILE_TEMPLATE = '/^recipe-\d\d\z/';

    protected function getMedicines($recipeId) {
        $medicines = array();
        $const = scandir(self::DATA_PATH . $recipeId);
        foreach ($const as $node) {
            if (preg_match(self::MEDICINE_FILE_TEMPLATE, $node)) {
                $medicines[] = $this->getMedicine($recipeId, $node);
            }
        }
        return $medicines;
    }

    protected function getMedicine($recipeId, $id) {
        $f = fopen(self::DATA_PATH . $recipeId . "/" . $id, "r");
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        $medicine = (new Medicine())
            ->setId($id)
            ->setName($rowArr[0])
            ->setDosage($rowArr[1])
            ->setForm($rowArr[2])
            ->setRecovered($rowArr[3]);
        fclose($f);
        return $medicine;
    }

    protected function getRecipes() {
        $recipes = array();
        $const = scandir(self::DATA_PATH);
        foreach ($const as $node) {
            if (preg_match(self::RECIPE_FILE_TEMPLATE, $node)) {
                $recipes[] = $this->getRecipe($node);
            }
        }
        return $recipes;
    }

    protected function getRecipe($id) {
        $f = fopen(self::DATA_PATH . $id . "/recipe.txt", "r");
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        fclose($f);
        $recipe = (new Recipe())
            ->setId($id)
            ->setPatient($rowArr[0])
            ->setBorn($rowArr[1])
            ->setDoctor($rowArr[2]);
        return $recipe;
    }

    protected function getUsers() {
        $users = array();
        $f = fopen(self::DATA_PATH . "users.txt", "r");
        while (!feof($f)) {
            $rowStr = fgets($f);
            $rowArr = explode(";", $rowStr);
            if (count($rowArr) == 3) {
                $user = (new User())
                    ->setUserName($rowArr[0])
                    ->setPassword($rowArr[1])
                    ->setRights(substr($rowArr[2],0,9));
                $users[] = $user;
            }
        }
        fclose($f);
        return $users;
    }

    protected function getUser($id) {
        $users = $this->getUsers();
        foreach($users as $user) {
            if ($user->getUserName() == $id) {
                return $user;
            }
        }
        return false;
    }

    protected function setMedicine(Medicine $medicine) {
        $f = fopen(self::DATA_PATH . $medicine->getRecipeId() . "/" . $medicine->getId(), "w");
        $rowArr = array($medicine->getName(), $medicine->getDosage(), $medicine->getForm(), $medicine->getRecovered());
        $rowStr = implode(";", $rowArr);
        fwrite($f, $rowStr);
        fclose($f);
    }
    protected function delMedicine(Medicine $medicine) {
        unlink(self::DATA_PATH . $medicine->getRecipeId() . "/" . $medicine->getId());
    }
    protected function insMedicine(Medicine $medicine) {
        $path = self::DATA_PATH . $medicine->getRecipeId();
        $const = scandir($path);
        foreach ($const as $node) {
            if (preg_match(self::MEDICINE_FILE_TEMPLATE, $node)) {
                $last_file = $node;
            }
        }

        $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
        if (strlen($file_index) == 1) {
            $file_index = "0" . $file_index;
        }

        $newFileName = "medicine-" . $file_index . ".txt";
        $medicine->setId($newFileName);
        $this->setMedicine($medicine);
    }

    protected function setRecipe(Recipe $recipe) {
        $f = fopen(self::DATA_PATH . $recipe->getId() . "/recipe.txt", "w");
        $rowArr = array($recipe->getPatient(), $recipe->getBorn(), $recipe->getDoctor());
        $rowStr = implode(";", $rowArr);
        fwrite($f, $rowStr);
        fclose($f);
    }
    protected function delRecipe($recipeId) {
        $dirName = self::DATA_PATH . $recipeId;
        $const = scandir($dirName);
        foreach ($const as $node) {
            @unlink($dirName . "/" . $node);
        }
        @rmdir($dirName);
    }
    protected function insRecipe() {
        $path = self::DATA_PATH;
        $const = scandir($path);
        foreach ($const as $node) {
            if (preg_match(self::RECIPE_FILE_TEMPLATE, $node)) {
                $last_file = $node;
            }
        }

        $file_index = (String)(((int)substr($last_file, -1, 2)) + 1);
        if (strlen($file_index) == 1) {
            $file_index = "0" . $file_index;
        }

        $newFileName = "recipe-" . $file_index;
        mkdir($path . $newFileName);
        $f = fopen($path . $newFileName . "/recipe.txt", "w");
        fwrite($f, "New; 1; 1");
        fclose($f);
    }

    protected function setUser(User $user) {
        $users = $this->getUsers();
        $found = false;
        foreach($users as $key => $oneUser) {
            if($user->getUserName() == $oneUser->getUserName()) {
                $found = true;
                break;
            }
        }
        if($found) {
            $users[$key] = $user;
            $f = fopen(self::DATA_PATH . "users.txt", "w");
            foreach($users as $oneUser) {
                $rowArr = array($oneUser->getUserName(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n");
                $rowStr = implode(";", $rowArr);
                fwrite($f, $rowStr);
            }
            fclose($f);
        }
    }
}
?>