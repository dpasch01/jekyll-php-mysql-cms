<?php
    session_start();

    $filepath=$_POST['filepath'];
    echo json_encode($_SESSION['markdowns'][$filepath]);
?>