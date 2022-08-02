<?php
    require 'util.php';
    init_php_session();

$conn = mysqli_connect(/*DB Login Credentials*/);

if(!$conn){
    echo "Erreur de Connexion: " . mysqli_connect_error();
}




$errors = array('mail'=>'', 'username'=>'', 'pw1'=>'', 'tos'=>'', 'takenusername' =>'');

if(isset($_POST['submit'])){
    
    if(empty($_POST['tos'])) {
        $errors['tos'] = "Vous devez accepter les CGU !";
    }
    //check email
    if(empty($_POST['mail'])){
        $errors['mail'] = "Vous devez entrer un E-mail <br />";
    } else {
        $mail = $_POST['mail'];
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors['mail'] = "E-Mail doit etre valide ! <br />";
        } else {
            $mail = $_POST["mail"];
        }
    }

    //check username
    if(empty($_POST['username'])){
        $errors['username'] = "Vous devez entrer un Pseudo <br />";
    } else {
        $username = $_POST['username'];
    }

    //check pw
    if(empty($_POST['pw1'])){
        $errors['pw1'] = "Vous devez entrer un Mot de Passe <br />";
    } else {
        $pw1 = $_POST["pw1"];
        $hashpw = password_hash($pw1, PASSWORD_BCRYPT);
      
    }
    $link_1 = "#";
    $link_2 = "#";
    $link_3 = "#";

    $checkUsernameInstance = "SELECT U_ID FROM mes_users WHERE Username='$username'";
    
    $resultatCheckInstance = $conn->query($checkUsernameInstance);
    if($resultatCheckInstance -> num_rows > 0) {
        $errors['takenusername'] = "Ce nom d'utilisateur est déja utilisé <br />";
        mysqli_close($conn);
    }

    if(array_filter($errors)){
       print $errors;
    } else {
        $link_1 = "#";
        $link_2 = "#";
        $link_3 = "#";
        $path_to_file = "/profilePictures/empty-profile.png";
        
        
        // nouvelle variabel sql

        $sql = "INSERT INTO mes_users (Username, Email, Passwd, path_to_file, link_1, link_2, link_3) VALUES ('$username', '$mail', '$hashpw', '$path_to_file', '$link_1', '$link_2', '$link_3')";
        //sauvegarder vers la base de données
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        mysqli_close($conn);

    }

} 
//fin du test Principal

//upload vers MyDQL 

?>




<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>LightRay | Login</title>
        <link rel="stylesheet" href="./styling/stylecss.css">
        <title>Register</title>
    </head>

    <body>
    
    <div class="titre">
    <h1></h1>
    
    
    </div>
    
    <form class="box" method="post">
        <h1>Register</h1>

        <input type="text" name="username" placeholder="Nom d'utilisateur">

        <h6 style="color:red;"><?php echo $errors["username"]; ?></h6>

        <input type="text" name="mail" placeholder="E-Mail">

        <h6 style="color:red;"><?php echo $errors["mail"]; ?></h6>

        <input type="password" name="pw1" placeholder="Mot de Passe">

        <h6 style="color:red;"><?php echo $errors["pw1"]; ?></h6>

        <input type="submit" name="submit" value="Créer">
        
        <input type="checkbox" id="tos" name="tos" value="Conditions Génerales d'Utilisation">
        <label name="tos" for="tos"><a href="tos.php" style="color:#2ecc71" style="font-size: small">J'ai lu et j'accepte les CGU</a></label><br>
        <h6 style="color:red;"><?php echo $errors['tos'] ?></h6>
        <h6 style="color:red;"><?php echo $errors['takenusername'] ?></h6>
        <h6>Vous avez déjà un compte ? <a href="index.php" style="color:#2ecc71">Connectez vous !</a></h6>
    </form>  
    
    </body>
</html>