<?php
    $data = array();
    
    $f = fopen("data\prescription.txt","r");
    $grStr = fgets($f);
    $grArr = explode(";", $grStr);
    fclose($f);

    $data['prescription'] = array(
        'patient' => $grArr[0],
        'year' => $grArr[1],
        'doctor' => $grArr[2],
    );

    $f = fopen("data\drags.txt", "r");
    $i = 0;
    while(!feof($f)) {
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        $data['drug'][$i]['name'] = $rowArr[0];
        $data['drug'][$i]['dosage'] = $rowArr[1];
        $data['drug'][$i]['company'] = $rowArr[2];
        $i++;
    }
    fclose($f);
    ?>
   


