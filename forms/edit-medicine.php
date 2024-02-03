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
            ->setDosage($_POST['dpsage'])
            ->setForm($_POST['form'])
            ->setRecovered($_POST['recovered']);
        if (!$myModel->writeMedicine($medicine)) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?recipe=' . $_GET['recipe']);
        }
    }
    $medicine = $myModel->readMedicine($_GET['recipe'], $_GET['file']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='../css/edit-medicine-form-style.css'>
    <title>Edit medicine</title>
</head>
<body>
    <a href="javascript:history.back()">Home</a>
    <form class="container" name="edit-medicine" method='post'>
        <div><label for="name">Name: </label><input type="text" name="name" value="<?php echo $medicine->getName();?>"></div>
        <div><label for="dosage">Medicine's dosage: </label><input type="text" name="dosage" value="<?php echo $medicine->getDosage(); ?>"></div>
        <div><label for="form">Medicine's form: </label><input type="text" name="form" value="<?php echo $medicine->getForm(); ?>"></div>
        <div><input type="checkbox" name="recovered" <?php echo ("1" == $medicine->getRecovered())?"checked":""; ?> value="1"> Has this patient recovered?</div>
        <div><input type="submit" name="ok" value="Save"></div>
    </form>
</body>
</html>