<?php 
    if ($_POST) {
        $path = __DIR__ . "/../data/";
        $index = require $path . 'last-drug-index.php';
        $newFile = 'drug-' . $index . '.txt';
        
        $f = fopen($path . "drugs/" . $newFile, "w");
        $grArr = array($_POST['drug_name'], $_POST['drug_dosage'], $_POST['drug_company'],);
        $grStr = implode(";", $grArr);
        fwrite($f, $grStr);
        fclose($f);

        header('Location: ../index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/edit-form.css">
    <title>Add drug</title>
</head>
    <body>
        <a href="/../index.php">Main page</a>
        <form action="add-drug.php" method="post">
            <div>
                <label for="drug_name">Name: </label>
                <input type="text" name="drug_name">
            </div>
            <div>
                <label for="drug_dosage">Dosage: </label>
                <input type="text" name="drug_dosage">
            </div>
            <div>
                <label for="drug_company">Company: </label>
                <input type="text" name="drug_company">
            </div>
            <div>
                <input type="submit" name="ok" value="ADD">
            </div>
        </form>
    </body>
</html>