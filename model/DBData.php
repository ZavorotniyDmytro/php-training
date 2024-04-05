<?php
namespace Model;
class DBData extends Data {
    private $db;
    public function __construct(MySQLdb $db) {
        $this->db = $db;
        $this->db->connect();
    }

    protected function getMedicines($recipeId){
        $medicines = array();
        if($medicines_arr = $this->db->getArrFromQuery("select id, name, dosage, form, recovered, 
        recipe_id from medicines where recipe_id=".$recipeId)) {
            foreach($medicines_arr as $medicine_row) {
                $medicine = (new Medicine())
                    ->setId($medicine_row['id'])
                    ->setName($medicine_row['name'])
                    ->setDosage($medicine_row['dosage'])
                    ->setForm($medicine_row['form'])
                    ->setRecovered($medicine_row['recovered'])
                    ->setRecipeId($medicine_row['recipe_id']);
                $medicines[]=$medicine;
            }
        }
        return $medicines;
    }

    protected function getMedicine($recipeId, $id) {
        $medicine = new Medicine();
        if($medicines_arr = $this->db->getArrFromQuery("select id, name, dosage, form, recovered, 
        recipe_id from medicines where id=" . $id)) {
            if (count($medicines_arr)>0){
                $medicine_row = $medicines_arr[0];
                $medicine = (new Medicine())
                    ->setId($medicine_row['id'])
                    ->setName($medicine_row['name'])
                    ->setDosage($medicine_row['dosage'])
                    ->setForm($medicine_row['form'])
                    ->setRecovered($medicine_row['recovered'])
                    ->setRecipeId($medicine_row['recipe_id']);
            }
        }
        return $medicine;
    }

    protected function getRecipes() {
        $recipes = array();
        if ($recipes_arr = $this->db->getArrFromQuery("select id, patient, born, doctor from recipes")) {
            foreach ($recipes_arr as $recipe_row) {
                $recipe = new Recipe();
                $recipe->setId($recipe_row['id'])
                    ->setPatient($recipe_row['patient'])
                    ->setBorn($recipe_row['born'])
                    ->setDoctor($recipe_row['doctor']);
                $recipes[] = $recipe;
            }
        }
        return $recipes;
    }

    protected function getRecipe($id) {
        $recipe = new Recipe();
        if ($recipes_arr = $this->db->getArrFromQuery("select id, patient, born, doctor from recipes where id=" . $id)) {
            if(count($recipes_arr) > 0) {
                $recipe_row = $recipes_arr[0];
                $recipe->setId($recipe_row['id'])
                    ->setPatient($recipe_row['patient'])
                    ->setBorn($recipe_row['born'])
                    ->setDoctor($recipe_row['doctor']);
            }
        }
        return $recipe;
    }

    protected function getUsers() {
        $users = array();
        if ($user_arr = $this->db->getArrFromQuery("select id, username, password, rights from users")) {
            foreach ($user_arr as $user_row) {
                $user = (new User())
                    ->setUserName($user_row['username'])
                    ->setPassword($user_row['password'])
                    ->setRights($user_row['rights']);
                $users[]=$user;
            }
        }
        return $users;
    }

    protected function getUser($id) {
        $user = new User();
        if ($users = $this->db->getArrFromQuery("select id, username, password, rights from users where username ='" . $id ."'")) {
            if(count($users)>0) {
                $user_row = $users[0];
                $user->setUserName($user_row['username'])
                    ->setPassword($user_row['password'])
                    ->setRights($user_row['rights']);
            }
        }
        return $user;
    }

    protected function setMedicine(Medicine $medicine) {
        $sql = "update medicines set name='" . $medicine->getName() . "', dosage='" . $medicine->getDosage() . "', form='" . $medicine->getForm() . 
            "', recovered='" . $medicine->getRecovered() . "', recipe_id=" . $medicine->getRecipeId() . " where id="  . $medicine->getId();
        $this->db->runQuery($sql);
    }

    protected function delMedicine(Medicine $medicine) {
        $sql = "delete from medicines where id=" . $medicine->getId();
        $this->db->runQuery($sql);
    }

    protected function delMedicineWithRecipe($recipe_id) {
        $sql = "delete from medicines where recipe_id=" . $recipe_id;
        $this->db->runQuery($sql);
    }

    protected function insMedicine(Medicine $medicine) {
        $sql = "insert into medicines (name, dosage, form, recovered, recipe_id) values('" . $medicine->getName() . "', '" . $medicine->getDosage() . 
            "', '" . $medicine->getForm() . "', '" . $medicine->getRecovered() . "', " . $medicine->getRecipeId() . ")";
        $this->db->runQuery($sql);
    }

    protected function setRecipe(Recipe $recipe) {
        $sql = "update recipes set patient='" . $recipe->getPatient() . "', born='" . $recipe->getBorn() . "', doctor='" . $recipe->getDoctor() . 
            "' where id=" . $recipe->getId();
        $this->db->runQuery($sql);
    }

    protected function delRecipe($id) {
        $this->delMedicineWithRecipe($id);
        $sql = "delete from recipes where id=" . $id;
        $this->db->runQuery($sql);
    }

    protected function setUser(User $user) {
        $sql = "update users set rights='" . $user->getRights() . "', password='" . $user->getPassword() . "' where username='" . $user->getUserName() . "'";
        $this->db->runQuery($sql);
    }

    protected function insRecipe() {
        $sql = "insert into recipes (patient, born, doctor) values ('new', 1111, '')";
        $this->db->runQuery($sql);
    }
}
?>