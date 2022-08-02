<?php
/*Documents importants */
    require 'util.php';
    init_php_session();

$conn = mysqli_connect(/*DB Login Credentials*/);

if(!$conn) {
    echo "Erreur de Connexion " . mysqli_connect_error();
}
/* Variables universelles de la page */

$Logged_User = $_SESSION['User_ID'];
$account_info_sql = "SELECT * FROM mes_users WHERE U_ID='$Logged_User'";
$result_account_info = $conn->query($account_info_sql);
$row_account_info = $result_account_info->fetch_assoc();

/*Lancer l'uplaod */
if(isset($_POST['upload'])) {
        $target_dir = "profilePictures/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Vérifier si l'image est bien une image
        if(empty($_FILES['fileToUpload'])){
            $path_to_file = $row_account_info['path_to_file'];
        } else {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $file_true = "Le fichier est une image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error_format = "Le fichier n'est pas une image";
                $uploadOk = 0;
            }
        }

        // Vérifier si le nom d'image existe déjà
        if (file_exists($target_file)) {
            $error_name = "Ce nom de fichier existe délà !";
            $uploadOk = 0;
        }

        // Vérifier que taille du fichier est < 5MB
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $error_taille = "Le fichier est trop volumineux !";
            $uploadOk = 0;
        }

        // Permettre que certains type de fichiers
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $error_extension = "Uniquement des fichiers de type JPG, JPEG, PNG & GIF sont autorisés";
            $uploadOk = 0;
        }

        // Verifier si une erreur est apparue
        if ($uploadOk == 0) {
            $error_upload2 = "Désolé le fichier n'a pas pu être chargé";
        // Si il n'y a pas d'erreurs, upload
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
/*Bouton Retour*/
if(isset($_POST['retour'])){
    header("Location: account_page.php");
}
/* Créer les variables sql pour l'upload  */
if(isset($_POST['appliquer'])){
    if(empty($_POST['email'])){
        $mail = $row_account_info['Email'];
    } else {
        $mail = $_POST['email'];
    }
    if(empty($_POST['username'])){
        $username = $row_account_info['Username'];
    } else {
        $username = $_POST['username'];
        $_SESSION['Username'] = $username;
    }
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

    $sql = "UPDATE mes_users SET Username='$username', Email='$mail', bio='$bio', path_to_file='$path_to_file', link_1='$link_1', link_2='$link_2', link_3='$link_3' WHERE U_ID='$Logged_User'";
    /* Créer la requete */

    if ($conn->query($sql) === TRUE) {
        header("Location: account_settings.php");
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
        <link rel="stylesheet" href="./styling/account_settings_css.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        
    </head>
    <body>


    <div class="justify-content-center">
    <form method="post" enctype="multipart/form-data" class="formulaire" style="padding:20px;">

    <div class="row gutters d-flex align-items-center justify-content-center" style="background-color:rgba(0,0,0,0); border-color:rgba(0,0,0,0);">

	<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12" style="background-color:rgba(0,0,0,0); border-color:rgba(0,0,0,0);">

		<div class="card h-100" style="background-color:rgba(0,0,0,0); border-color:rgba(0,0,0,0);">

			<div class="card-body" style="background: #2c3a47; border-radius:25px;">

				<div class="account-settings">
					<div class="user-profile">
						<div class="user-avatar">
							<img src=".<?=$row_account_info['path_to_file']?>">
						</div>
						<h5 style="color:#fff; font-weight: bold;" class="user-name"><?= $row_account_info['Username']?></h5>
						<h6 style="color:#fff;" class="user-email"><?= $row_account_info['Email']?></h6>
					</div>
					<div class="desc">
						<h5 style="color:#2ecc71;" class="mb-2" style="color:2ecc71;">Descripion</h5>
						<p style="color:#fff;"><?= $row_account_info['bio']?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12"  style="background-color:rgba(0,0,0,0); border-color:rgba(0,0,0,0);">
		<div class="card h-100" style="background-color:rgba(0,0,0,0); border-color:rgba(0,0,0,0);">
			<div class="card-body" style="background: #2c3a47; border-radius:25px;">
				<div class="row gutters">
                
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h6 style="color:#2ecc71;" class="mb-3">Informations Personnelles</h6>
                    </div>
                    
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="Username">Nom</label>
							<input type="text" name="username"class="form-control" id="Username" placeholder="Entrez le nom du compte" value="<?= $row_account_info['Username']?>">
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="eMail">Email</label>
							<input type="email" class="form-control" name="email" id="eMail" placeholder="Entrez l'adresse mail" value="<?= $row_account_info['Email']?>">
						</div>
					</div>
				</div>
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h6 style="color:#2ecc71;" class="mb-3">Informations Publiques</h6>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="Street">Nom Twitter (sans @)</label>
							<input type="name" class="form-control" name="twitter" id="Street" placeholder="entrez votre nom Twitter" value="<?= $row_account_info['link_1']?>">
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="GitHub">Nom GitHub</label>
							<input type="name" class="form-control" name="github" id="GitHub" placeholder="Entrez votre nom github" value="<?= $row_account_info['link_2']?>">
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="YT">Entrez votre lien YouTube</label>
							<input type="text" class="form-control" name="yt" id="YT" placeholder="Entrez votre lien" value="<?= $row_account_info['link_3']?>">
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label style="color:#fff;" for="Description">Description</label>
							<input type="text" class="form-control" name="description" id="Description" placeholder="Description" value="<?= $row_account_info['bio']?>">
						</div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label style="color:#fff;" for="fileToUpload">Choisir votre Image de Profil</label>
                            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label style="color:#fff;" for="submitUplaod">Charger votre Image</label><br>
                            <input type="submit" value="Charger" name="upload" class="btn btn-secondary" style="border: 0;
                                                                                                                background: none;
                                                                                                                margin: 2px auto;
                                                                                                                text-align: center;
                                                                                                                border: 2px solid #2ecc71;
                                                                                                                padding: 7px 20px;
                                                                                                                outline: none;
                                                                                                                color: #fff;
                                                                                                                border-radius: 24px;
                                                                                                                transition: 0.25s;
                                                                                                                cursor: pointer;"  onmouseover="this.style.backgroundColor='#2ecc71'" onmouseout="this.style.backgroundColor='#2c3a47'">
                        </div>
                    </div>
				</div>
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="text-right">
                            <input type="submit" value="Retour" id="retour" name="retour" class="btn btn-secondary"  style="border: 0;
    background: none;
    
    margin: 5px auto;
    text-align: center;
    border: 2px solid #2ecc71;
    padding: 14px 40px;
    outline: none;
    color: #fff;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer;"  onmouseover="this.style.backgroundColor='#2ecc71'" onmouseout="this.style.backgroundColor='#2c3a47'">
                            
                            <input type="submit" value="Mettre a Jour" id="appliquer" name="appliquer" calss="btn btn-primary" style="border: 0;
    background: none;
    
    margin: 5px auto;
    text-align: center;
    border: 2px solid #2ecc71;
    padding: 14px 40px;
    outline: none;
    color: #fff;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer;"  onmouseover="this.style.backgroundColor='#2ecc71'" onmouseout="this.style.backgroundColor='#2c3a47'">
                        </div>

					</div>
                </div>
                
                
                
                <h4 style="color:green;"><?= $confirm_upload?></h4>
                <h4 style="color:red;"><?= $error_upload?></h4>
                <h4 style="color:red;"><?= $error_extension?></h4>
                <h4 style="color:red;"><?= $error_format?></h4>
                <h4 style="color:red;"><?= $error_name?></h4>
                <h4 style="color:red;"><?= $error_taille?></h4>
                <h4 style="color:red;"><?= $error_upload2?></h4>
            </form>
			</div>
        </div>
	</div>
</div>
</div>
    </body>
</html>