<?php
    session_start();

    $filetodelete=$_POST['filepath'];
    unlink("$filetodelete");

    $_SESSION['dirty']=true;
?>
