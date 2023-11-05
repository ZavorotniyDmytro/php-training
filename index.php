<?php 
    require_once('data/drugs.php');
    require_once('data/prescription.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Medical prescription</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <header>
            <h1>Medical prescription for <?php echo $data['prescription']['patient']; ?><br>(<?php echo $data['prescription']['year']; ?>  year of birth)</h1>
            <h2>Doctor: <?php echo $data['prescription']['doctor']; ?></h2>
            <a href="/forms/edit-prescription.php">Edit prescription</a>
        </header>
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
                        <tr>
                            <td><?php echo ($key + 1); ?></td>
                            <td><?php echo $drug['name']; ?></td>
                            <td><?php echo $drug['dosage']; ?></td>
                            <td><?php echo $drug['company']; ?></td>
                            <td>
                                <a href='forms/edit-drug.php?file=<?php echo $drug['file'];?>'>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>    
    </body>
</html>