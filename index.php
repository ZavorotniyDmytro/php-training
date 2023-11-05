<?php 
    require_once('data/drugs.php');
    require_once('data/prescription.php');
    if (!isset($_POST['drug-filter'])){
        $_POST['drug-filter'] = "";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Medical prescription</title>
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/filter.css">
    </head>
    <body>
        <header>
            <h1>Medical prescription for <?php echo $data['prescription']['patient']; ?><br>(<?php echo $data['prescription']['year']; ?>  year of birth)</h1>
            <h2>Doctor: <?php echo $data['prescription']['doctor']; ?></h2>
            <a href="/forms/edit-prescription.php">Edit prescription</a>
        </header>
        <center><a href="/forms/add-drug.php">Add drug</a></center>
        <center>
            <form name='drug-filter' method="post">
                <label for="drug-filter">Filter by name</label>
                <input type="text" name="drug-filter" value="<?php echo $_POST['drug-filter'];?>">
                <input type="submit" value="filter">
            </form>
        </center>
        <section>
            <table>
                <thead>
                    <th>drug number</th>
                    <th>name</th>
                    <th>dosage</th>
                    <th>company</th>
                    <td>EDIT</td>
                </thead>
                <tbody>
                    <?php foreach ($data['drug'] as $key => $drug ): ?>
                        <?php if (!$_POST['drug-filter'] || stristr($drug['name'], $_POST['drug-filter'])): ?>
                            <tr>
                                <td><?php echo ($key + 1); ?></td>
                                <td><?php echo $drug['name']; ?></td>
                                <td><?php echo $drug['dosage']; ?></td>
                                <td><?php echo $drug['company']; ?></td>
                                <td>
                                    <a href='forms/edit-drug.php?file=<?php echo $drug['file'];?>'>
                                        Edit
                                    </a> or
                                    
                                    <a href='forms/delete-drug.php?file=<?php echo $drug['file'];?>'>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </body>
</html>