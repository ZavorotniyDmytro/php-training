<?php    
    $f = fopen(__DIR__ . "/prescription.txt","r");
    $grStr = fgets($f);
    $grArr = explode(";", $grStr);
    fclose($f);

    $data['prescription'] = array(
        'patient' => $grArr[0],
        'year' => $grArr[1],
        'doctor' => $grArr[2],
    );
?>