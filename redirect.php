<?php
    require 'util.php';
    init_php_session();
    if($_SESSION['Username'] === NULL){
        header("Location: index.php");
    } else {
        header('Refresh: 1; URL=homepage.php');
    }




?>


<html>
    <head>
        <title>Chargement</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UFT-8">
        <link rel="stylesheet" href="./styling/stylecss.css">
    </head>
    <body>
        <div class="chargement">
            <h3>Connexion au compte</h3>
            <div class="loader"></div>
        </div>
    </body>
</html>