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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='../css/edit-medicine-form-style.css'>
    <title>Add medicine</title>
</head>
<body>
    <a href="javascript:history.back()">Home</a>
    <form class="container" name="edit-medicine" method='post'>
        <div><label for="name">Name: </label><input type="text" name="name"></div>
        <div><label for="dosage">Medicine's dosage: </label><input type="text" name="dosage"></div>
        <div><label for="form">Medicine's form: </label><input type="text" name="form"></div>
        <div><input type="checkbox" name="recovered"> Has thos patient recovered?</div>
        <div><input type="submit" name="ok" value="Save"></div>
    </form>
</body>
</html>