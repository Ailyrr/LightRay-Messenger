<?php

/*CECI EST LA PAGE MONTREE POUR LES UTILISATEURS AUTRES QUE LE USER CONNECTE */

/* Documents nécessaires*/
    require 'util.php';
    init_php_session();
/* Vérifier si l'utilisateur s'est connecté*/

    if($_SESSION['Username'] === NULL){
        header("Location: index.php");
    }  
/* Connexion à la databse */
$conn = mysqli_connect(/*DB Login Credentials*/);

if(!$conn){
    echo "Erreur de Connexion: " . mysqli_connect_error();
}

/* mySQL syntax */
$targetUser = $_SESSION['targetUserId'];
$sql = "SELECT * FROM mes_users WHERE U_ID = '$targetUser'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

/* Fonctions du boutton */
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['back'])) {
        header("Location: homepage.php");
    }
}
?>

<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LightRay | Compte de <?= $row['Username']?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>
        <link rel="stylesheet" href="./styling/accountcss.css">
    </head>
    <body>

    <div class="profile">
        <div class="profile-header">
            <div class="PP">
                <img src=".<?=$row['path_to_file'] ?>" alt="">        
            </div>
            <div class="nom"><?=$row['Username'] ?></div>
            
            
            <div class="desc"><?= $row['bio'] ?></div>
            
            <div class="sm">
                <a href="https://twitter.com/<?=$row['link_1'] ?>" class="fab fa-twitter"></a>
                <a href="https://github.com/<?=$row['link_2'] ?>" class="fab fa-github"></a>
                <a href="<?=$row['link_3'] ?>" class="fab fa-youtube"></a>
            </div>
            
            <div class="profile-footer">
                
            <form  class="justify-content-center" method="post">
                <input name="back" type="submit" value="Retour" class="btn" style="border: 0;
    background: none;
    
    margin: 5px;
    text-align: center;
    border: 2px solid #2ecc71;
    padding: 14px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer;
    " onmouseover="this.style.backgroundColor='#2ecc71'" onmouseout="this.style.backgroundColor='#2c3a47'"/><br>
            </form>
                    
    
            </div>
        </div>
    </div>
    
    </body>
</html>