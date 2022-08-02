<?php
/*Documents Importants */
    require 'util.php';
    init_php_session();
$conn = mysqli_connect(/*DB Login Credentials*/);
if(!$conn) {
    echo "Erreur de Connexion: " . mysqli_connect_error();
}
//sortir les IDs
$errors = array('Username'=>'', 'Password'=>'');
//Definir les variables
if(isset($_POST["submit"])){
    $CheckUsername = mysqli_real_escape_string($conn, $_POST["username"]);
    $CheckPw = mysqli_real_escape_string($conn, $_POST["password"]);
    $sql = "SELECT U_ID, Username, Passwd, path_to_file FROM mes_users WHERE Username = '$CheckUsername'";
    $result = $conn->query($sql);
/*Verifier les IDs */
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["Username"] == $CheckUsername) {
                if(password_verify($CheckPw, $row['Passwd'])) {
                    $_SESSION['path_to_file'] = $row['path_to_file'];
                    $_SESSION['Username'] = $CheckUsername;
                    $_SESSION['User_ID'] = $row['U_ID'];
                    header("Location: redirect.php");
                } else {
                    $errors["Password"] = "Mot de passe Incorrect !";
                } 
            } else {
                $errors["Username"] = "Ce Compte n'éxiste pas !"; 
            }
        }
    } else {
        echo "Erreur : " . mysqli_error();
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LightRay | Login</title>
        <link rel="stylesheet" href="./styling/stylecss.css">
        <script src="connexion.js"></script>
    </head>
    <body>
    <div class="titre">
    <form class="box" method="post">
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <h6 style="color:red;"><?php echo $errors["Username"]; ?></h6>
        <input type="password" name="password" placeholder="Mot de Passe">
        <h6 style="color:red;"><?php echo $errors["Password"]; ?></h6>
        <input type="submit" name="submit" value="Login">
        <h6>Vous n'avez pas de compte ? <a href="register.php" style="color:#2ecc71">Créez en un !</a></h6>
        <h6>© 2020-2021 Light Ray</h6>
    </form>
    </div>
    </body>
</html>