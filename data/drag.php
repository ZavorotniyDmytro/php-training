<?php
    $f = fopen(__DIR__ . "\drags.txt", "r");
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
   


