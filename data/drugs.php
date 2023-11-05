<?php
    $nameTemplate= '/^drug-(\d+).txt\z/';
    $path = __DIR__ . "/drugs";
    $conts = scandir($path);

    $i = 0;
    foreach ($conts as $node) {
        if (preg_match($nameTemplate, $node)) {
            $data['drug'][$i] = require __DIR__ . '/drug.php';
            $i++;
        }
    }
?>