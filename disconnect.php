<?php
require 'util.php';
    init_php_session();
    if($_SESSION['Username'] === NULL){
        header("Location: index.php");
    }
    clean_php_session();
?>
