<?php
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    $stm = $db->prepare('INSERT into accounts VALUES (?,?)');
    $stm->bindParam(1,$user);
    $stm->bindParam(2,$pass);

?>