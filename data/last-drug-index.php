<?php 
    $f = fopen(__DIR__ . "/last-drug-index.txt","r");
    $index = fgets($f) + 1;
    fclose($f);

    $f = fopen(__DIR__ . "/last-drug-index.txt","w");
    fwrite($f, $index);
    fclose($f);

    return $index;
?>