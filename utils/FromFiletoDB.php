<?php
require_once '../controller/autorun.php';
require_once '../data/config.php';

$db = new \Model\MySQLdb();
$db->connect();
$db->runQuery("delete from medicines");
$db->runQuery("delete from recipes");
$db->runQuery("delete from users");

$fileModel = \Model\Data::makeModel(\Model\Data::FILE);
$fileModel->setCurrentUser('admin');

$users = $fileModel->readUsers();
foreach ($users as $user) {
    $db->runQuery("insert into users (username, password, rights) values ('" . $user->getUserName() . "', '" . $user->getPassword() . "' , '" . $user->getRights() . "')");
}

$dbModel = \Model\Data::makeModel(\Model\Data::DB);
$dbModel->setCurrentUser('admin');
 
$recipes = $fileModel->readRecipes();
foreach ($recipes as $recipe) {
    $sql = "insert into recipes (patient, born, doctor) values ('" . $recipe->getPatient() . "', '" . $recipe->getBorn() . "', '" . $recipe->getDoctor() . "')";
    $db->runQuery($sql);
    $res = $db->getArrFromQuery("select max(id) id from recipes");
    $recipe_id = $res[0]['id'];
    $medicines = $fileModel->readMedicines($recipe->getId());
    foreach ($medicines as $medicine) {
        $medicine->setRecipeId($recipe_id);
        $dbModel->addMedicine($medicine);
    }
}

$db->disconnect();
?>