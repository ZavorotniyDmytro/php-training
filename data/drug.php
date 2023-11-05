<?php
    $f = fopen($path . "/" . $node, "r");
    $rowStr = fgets($f);
    $rowArr = explode(";", $rowStr);
    $student['file'] = $node;
    $student['name'] = $rowArr[0];
    $student['dosage'] = $rowArr[1];
    $student['company'] = $rowArr[2];
    fclose($f);

    return $student;
?>
   


