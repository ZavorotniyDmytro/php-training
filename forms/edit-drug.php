<?php
    if ($_POST){
        $path = __DIR__ . '/../data/drugs/';
        $f = fopen($path . $_GET['file'], "w");
        $grArr = array($_POST['name'], $_POST['dosage'], $_POST['company'],);
        $grStr = implode(";", $grArr);
        fwrite($f, $grStr);
        fclose($f);
        header('Location: /../index.php');
    }
    $path = __DIR__ . '/../data/drugs/';
    $node = $_GET['file'];
    $drug = require __DIR__ . '/../data/drug.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug edit</title>
    <link rel="stylesheet" href="/styles/edit-form.css">
</head>
    <body>
        <a href="/index.php">Main page</a>
        <form name='edit-drug' method="post">
            <div>
                <label for="name">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    value="<?php echo $drug['name']; ?>">
            </div>
            <div>
                <label for="Dosage">Dosage</label>
                <input 
                    type="text" 
                    name="dosage" 
                    value="<?php echo $drug['dosage']; ?>">
            </div>
            <div>
                <label for="company">Company</label>
                <input 
                    type="text"
                    name="company"
                    value="<?php echo $drug['company']; ?>">
            </div>
            <div>
                <input type="submit" name="ok" value="change">
            </div>
        </form>
    </body>
</html>