<?php

    /* MERCI A THEO LE GROS BG QUI A AIDE POUR LE STATEMENT MYSQL */

    /*Required Docs*/

    require 'util.php';
    init_php_session();
    

  /* Get Q parameter*/

    $q = $_GET['q'];
    
    $path_to_user_file = $_SESSION['selectedUserPP'];
    
    
    /*Connexion à la Database*/

    $con = mysqli_connect(/*DB Login Credentials*/);
    if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
    }


    /*mySQL syntaxe et lancement de la requête*/
    $User_ID = $_SESSION['User_ID'];
    $To_User_ID = $q;
    mysqli_select_db($con,"ajax_demo");
    
    /*Trouver les messages correspondants */

    $sql = "SELECT * FROM messages WHERE (from_user='$User_ID' OR from_user='$To_User_ID') AND (to_user='$To_User_ID' OR to_user='$User_ID') ORDER BY messages.timestamp";
    $result_message = $con->query($sql);
    
    /*Echo le nombre de message trouvé selon leurs catégorie et source*/

  if ($result_message -> num_rows > 0) {
      while($row = $result_message->fetch_assoc()) {
        if($row['from_user'] == $User_ID) {
        echo '<div class="d-flex justify-content-end mb-4" id="'.$row['from_user'].'">
              <div class="msg_cotainer_send">
              '.$row['message_content'].'
              <span class="msg_time_send" style="white-space: nowrap;">'.$row['timestamp'].'</span>
              </div>
              <div class="img_cont_msg">
              <img src=".'.$_SESSION['path_to_file'].'" class="rounded-circle user_img_msg">
              </div>
              </div>
              ';
        } else {
          echo '<div class="d-flex justify-content-start mb-4" id="'.$row['from_user'].'">
                <div class="img_cont_msg">
                <img src=".'.$path_to_user_file.'" class="rounded-circle user_img_msg">
                </div>
                <div class="msg_cotainer">
                  '.$row['message_content'].'
                <span class="msg_time" style="white-space: nowrap;">'.$row['timestamp'].'</span>
                </div>
                </div>';
                
        }
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