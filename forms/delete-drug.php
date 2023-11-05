<?php
    unlink(__DIR__ . '/../data/drugs/' . $_GET['file']);
    header('Location: /../index.php')
?>