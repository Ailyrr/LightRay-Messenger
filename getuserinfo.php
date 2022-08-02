<?php
    /*CECI EST UN DOCUMENT AJAX, IL NE MONTRERA AUCUNE RESSOURCE VISUELLE */
    
    /* MERCI A THEO LE GROS BG QUI A AIDE POUR LE STATEMENT MYSQL */

    /*Required Docs*/

    require 'util.php';
    init_php_session();

    $q = $_GET['q'];
    
    $selectedUser = $q;
    
    /*Connexion à la Database*/

    $con = mysqli_connect(/*DB Login Credentials*/);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }

    /*mySQL syntaxe et lancement de la requête*/

    mysqli_select_db($con,"ajax_demo");
    
    $sql = "SELECT * FROM mes_users WHERE U_ID = '$selectedUser'";
    $result_message = $con->query($sql);
    
    /*Echo le nombre de message trouvé selon leurs catégorie et source*/

  if ($result_message -> num_rows > 0) {
    
      while($row = $result_message->fetch_assoc()) {
        $_SESSION['selectedUserPP'] = $row['path_to_file'];
        $_SESSION['targetUserId'] = $row['U_ID'];
        echo '<div class="img_cont">
                <img src=".'.$_SESSION['selectedUserPP'].'" class="rounded-circle user_img">
                </div>
                <div class="user_info">
                <span>Conversation avec '.$row['Username'].'</span>	
                </div>';
        
      }
  }
    mysqli_close($con);
    
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
</body>
</html>
</body>
</html>