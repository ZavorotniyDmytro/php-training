<?php 
    include(__DIR__ . "/../auth/check-auth.php");

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    
    if ($_POST) {
        if (!$myModel->writeRecipe((new \Model\Recipe())
            ->setId($_GET['recipe'])
            ->setPatient($_POST['patient'])
            ->setBorn($_POST['born'])
            ->setDoctor($_POST['doctor'])
        )) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?recipe=' . $_GET['recipe']);
        }
    }
    if (!$data['recipe'] = $myModel->readRecipe($_GET['recipe'])) {
        die($myModel->getError());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit-data-form-style.css">
    <title>Data editing</title>
</head>
<body>
    <a href="javascript:history.back()">Home</a>
    <form class="container" name="edit-data" method='post'>
        <div><label for="patient">Recipe for </label><input type="text" name="patient" value="<?php echo $data['recipe']->getPatient(); ?>"></div>
        <div><label for="born">Born: </label><input type="text" name="born" value="<?php echo $data['recipe']->getBorn(); ?>"></div>
        <div><label for="doctor">Doctor: </label><input type="text" name="doctor" value="<?php echo $data['recipe']->getDoctor(); ?>"></div>
        <div><input type="submit" name="ok" value="Save"></div>
    </form>
</body>
</html>