<?php
    session_start();
    
    if ($_SESSION['dirty']==true) {
        echo 'true';
    }else{
        echo 'false';
    }
?>
