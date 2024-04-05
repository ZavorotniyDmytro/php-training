<?php
    $my_con = new mysql("localhost", "root", "", "recipe_list");
    $res=$my_son->query("select username from users where id=1");
    $row=$res->fetch_assoc();
    echo $row['username'];
    // phpinfo();
?>