<?php
    require('../data/prescription.php')
?>
<?php
    if ($_POST){
        $f = fopen("../data/prescription.txt", "w");
        $grArr = array($_POST['patient'], $_POST['year'], $_POST['doctor'],);
        $grStr = implode(";", $grArr);
        fwrite($f, $grStr);
        fclose($f);
        header('Location: /../index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription edit</title>
    <link rel="stylesheet" href="/styles/edit-form.css">
</head>
    <body>
        <a href="/index.php">Main page</a>
        <form name='edit-prescription' method="post">
            <div><label for="patient">Patient</label><input type="text" name="patient" 
            value="<?php echo $data['prescription']['patient']; ?>"></div>
            <div><label for="year">Year</label><input type="text" name="year" 
            value="<?php echo $data['prescription']['year']; ?>"></div>
            <div><label for="doctor">Doctor</label><input type="text" name="doctor"
            value="<?php echo $data['prescription']['doctor']; ?>"></div>
            <div><input type="submit" name="ok" value="change"></div>
        </form>
    </body>
</html>