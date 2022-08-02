<?php
    /*CECI EST UN DOCUMENT AJAX, IL NE MONTRERA AUCUNE RESSOURCE VISUELLE */
    
    /* MERCI A THEO LE GROS BG QUI A AIDE POUR LE STATEMENT MYSQL */

    /*Required Docs*/

    require 'util.php';
    init_php_session();

    /*Connexion à la Database*/

    $con = mysqli_connect(/*DB Login Credentials*/);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }
	
	$destinationUser=mysqli_real_escape_string($con, $_POST['destinationUser']);
  $sendingUser=mysqli_real_escape_string($con, $_SESSION['User_ID']);
  $messageContent=mysqli_real_escape_string($con, $_POST['messageContent']);
  /*Convertir le contenu du message en contenu adapté au la BD mySQL */
  
	
	$sql = "INSERT INTO messages (from_user, to_user, message_content) VALUES ('$sendingUser', '$destinationUser', '$messageContent')";
	if (mysqli_query($con, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>