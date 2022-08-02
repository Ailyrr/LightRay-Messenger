<?php
    require 'util.php';
    init_php_session();

$conn = mysqli_connect(/*DB Login Credentials*/);

if(!$conn) {
    echo "Erreur de Connexion " . mysqli_connect_error();
}

$Logged_User = $_SESSION['Username'];

$account_info_sql = "SELECT bio, path_to_file, link_1, link_2, link_3 FROM mes_users WHERE Username='$Logged_User'";

$result_account_info = $conn->query($account_info_sql);

$row_account_info = $result_account_info->fetch_assoc();


if(isset($_POST['upload'])) {
        $target_dir = "profilePictures/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        
        
        if(empty($_FILES['fileToUpload'])){
            $path_to_file = $row_account_info['path_to_file'];
        } else {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $file_true = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error_format = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $error_name = "Ce nom de fichier existe délà !";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $error_taille = "Le fichier est trop volumineux !";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $error_extension = "Uniquement des fichiers de type JPG, JPEG, PNG & GIF sont autorisés";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_upload2 = "Désolé le fichier n'a pas pu être chargé";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $path = "/" . $target_dir . $_FILES['fileToUpload']['name'];
                $_SESSION['path_to_file'] = $path;
                $confirm_upload = "Le fichier à été chargé !";
                //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
                $error_upload = "Le fichier n'a pas pu être chargé";
                //echo "Sorry, there was an error uploading your file.";
            }
        }
    
}   


if(isset($_POST['appliquer'])){

    if(!empty($_POST['description'])){
        $bio = $_POST['description'];
    } 
    
    if(!empty($_POST['twitter'])){
        $link_1 = $_POST['twitter'];
    } else {
        $link_1 = "#";
    }
    if(!empty($_POST['github'])){
        $link_2 = $_POST['github'];
    } else {
        $link_2 = "#";
    }
    if(!empty($_POST['yt'])){
        $link_3 = $_POST['yt'];
    } else {
        $link_3 = "#";
    }
    
    $path_to_file = $_SESSION['path_to_file'];

    $sql = "UPDATE mes_users SET bio='$bio', path_to_file='$path_to_file', link_1='$link_1', link_2='$link_2', link_3='$link_3' WHERE Username='$Logged_User'";
    

    if ($conn->query($sql) === TRUE) {
        header("Location: account_page.php");
    } else {
        echo "Error: " . $sql . "<br>";
    }
    mysqli_close($conn);
}


?>
<html>
    <head>
        <title>
            Paramètres de Compte
        </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./styling/parametre.css">
    </head>
    <body>
        <div class="main-body">
            
            <form method="post" class="box" enctype="multipart/form-data">    
                <h1>Paramètres de Compte</h1><br>
                <h3>Modifiez les champs ci dessous, afin de modifier vos informations de compte</h3>
            
                <h4>Modifier votre Description :</h4>
            
                <input type="text" id="desc"name="description" placeholder="Votre Description" value="<?= $row_account_info['bio'] ?>">
            
                <h4>Modifier vos liens socieaux :</h4>
            
                <input type="text" id="twt" name="twitter" placeholder="Twitter (sans @)" value="<?= $row_account_info['link_1']?>">
            
                <input type="text" id="gh"name="github" placeholder="Nom Github" value="<?= $row_account_info['link_2']?>">
            
                <input type="text" id="yt"name="yt" placeholder="Lien Youtube" value="<?= $row_account_info['link_3']?>">
                <input type="submit" value="Appliquer" name="appliquer">
            </form>

            <h3>Modifier l'image de profil</h3>
            
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Charger" name="upload">
                <h4 style="color:green;"><?= $confirm_upload?></h4>
                <h4 style="color:red;"><?= $error_upload?></h4>
                <h4 style="color:red;"><?= $error_extension?></h4>
                <h4 style="color:red;"><?= $error_format?></h4>
                <h4 style="color:red;"><?= $error_name?></h4>
                <h4 style="color:red;"><?= $error_taille?></h4>
                <h4 style="color:red;"><?= $error_upload2?></h4>
            </form>
        </div>
    </body>
</html>