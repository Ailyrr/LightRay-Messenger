<?php
/*Documents Importants */
    require 'util.php';
    init_php_session();
    if($_SESSION['Username'] === NULL){
        header("Location: index.php");
    }
/*Connexion à la DB */
    $conn = mysqli_connect(/*DB Login Credentials*/);
    if(!$conn){
        echo "Erreur de Connexion: " . mysqli_connect_error();
    }
/*Bouton déconnecter */
	if(isset($_POST['logout'])) {
		clean_php_session();
	}
	
	
/*Menu Déconnecter */ 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['search'])) {   
        
            if(isset($_POST['acc'])) {
                header("Location: account_page.php");
            }
            if(isset($_POST['logout'])) {
                clean_php_session(); 
            }
        }
	} 
/*Fonctions d'envoi vers la DB */
    if(isset($_POST['send'])) {
        if(empty($_POST['textarea'])){
            $alert_message = "veuillez entrer un message";
        } else {
		/*Définir les variables */
        $message_content = $_POST['textarea'];
        $logged_user_id = $_SESSION['User_ID'];
		$destination_user_id = 78;
		/*Envoi vers la DB */
        $sql = "INSERT INTO messages (from_user, to_user, message_content) VALUES ('$logged_user_id', '$destination_user_id', '$message_content')";
        $conn->query($sql);
        $message_content = NULL;
        }
    }
?>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html>
	<head>
		<title>LightRay | Chat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<link rel="stylesheet" href="./styling/homepage.css">
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>

/*Fonction des boutons auxiliares */
	$(document).ready(function(){
    	$('#action_menu_btn').click(function(){
     		$('.action_menu').toggle();
    	});
    });

	$(document).ready(function(){
    	$('#action_menu_btn_user').click(function(){
        	$('.action_menu_user').toggle();
    	});
	});

/* Envoi des Messages (Javascript AJAX) */ 
			var bidon;
			var divCheck;
			var div1;
			var response;
			var myvar;
			var otherUser=-1;	
			
$(document).ready(function() {
	$('#sendMessage').on('click', function() {
		$("#sendMessage").attr("disabled", "disabled");
		
		var messageContent = $('#textArea').val();

		if(messageContent!=""){
			$.ajax({
				url: "sendmessage.php",
				type: "POST",
				data: {
					destinationUser: otherUser,
					messageContent: messageContent,				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$("#sendMessage").removeAttr("disabled");
						$('#messageForm').find('input:text').val('');						
					}
					else if(dataResult.statusCode==201){
					   alert("Erreur d'envoi");
					}
				}
			});
		}
		else{
			alert('Veuillez ne pas envoyer de messages vides.');
		}
	});
});
			/* Chargement des messages (Javascript AJAX) */
			function scrollDown(){
				if (otherUser == -1) {
                	document.getElementById("txtHint").innerHTML = "";
                	return;
            	} else { 
                	var xmlhttp = new XMLHttpRequest();
                	xmlhttp.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
					if(divCheck !== this.responseText){
                		document.getElementById("txtHint").innerHTML = this.responseText;
						divCheck = this.responseText;
						bidon = "true";
					} else {
						bidon = "false";
					}
            	}
        	};
            		xmlhttp.open("GET","getuser.php?q="+otherUser,true);
            		xmlhttp.send();
					if(bidon == "true"){
						var objDiv = document.getElementById("txtHint");
						objDiv.scrollTop = objDiv.scrollHeight;
						}
				}
			}
			/*Boucle de la fonction de chargement des messages */
			function startTimer(){
				myvar = setInterval(scrollDown, 800);
			}

			/*Fonction chargement des messages 1x (au) */
            function showUser() {
            	if (otherUser == -1) {
                	document.getElementById("txtHint").innerHTML = "";
                	return;
            	} else { 
                	var xmlhttp = new XMLHttpRequest();
                	xmlhttp.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
						divCheck = this.responseText;
                		document.getElementById("txtHint").innerHTML = this.responseText;
            			}
        			};						
            			xmlhttp.open("GET","getuser.php?q="+otherUser,true);
            			xmlhttp.send();
				}
        	}
					
			/* Chargement du Header d'utilisateur. (Javascript AJAX) */

			function showUserInfo() {
				if (otherUser == -1) {
					document.getElementById("txtHintInfo").innerHTML = "";
					return;
				} else { 
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("txtHintInfo").innerHTML = this.responseText;
					}
				};
				
				xmlhttp.open("GET","getuserinfo.php?q="+otherUser,true);
				xmlhttp.send();
			}
				}
		</script>
	</head>	
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<span id="action_menu_btn_user"><i class="fas fa-ellipsis-v"></i></span>
								<div class="action_menu_user">
									<ul>
										<li><i class="fas fa-user-circle"></i><a href="account_page.php" style="color:fff"> Voir mon Profil </a></li>
										<li><i class="fas fa-sign-out-alt"></i><a href="disconnect.php" style="color:fff" name="logout"> De Déconnecter </a></li>
									</ul>
								</div>
							<img src=".<?= $_SESSION['path_to_file']?>" class="rounded-circle user_img">
							<div class="user_info">
							<span><?= $_SESSION['Username'] ?></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts">
						<?
							/*Chargement des différents Users (PHP + Javascript Calls) */
							$sql_contact = "SELECT * FROM mes_users";
							$result_contact = $conn->query($sql_contact);
							if($result_contact -> num_rows > 0) {
								$increment = 0;
								while($row = $result_contact->fetch_assoc()) {
									if($row['U_ID'] !== $_SESSION['User_ID']){
									echo'<li class="active">
										<div id="list-entry" class="d-flex bd-highlight" onclick="lookupUser'.$increment.'();showUserStart();">
										<div class="img_cont">
										<img src=".'.$row['path_to_file'].'" class="rounded-circle user_img">
										</div>
										<div class="user_info">
										<span id="username'.$increment.'">'.$row['Username'].'</span>
										<span id="ID'.$increment.'" class="'.$row['U_ID'].'" style="color:rgba(0, 0, 0, 0);"></span>
										</div>
										</div>
										<script>
										</script>
										</li>
										<script>
										function lookupUser'.$increment.'(){
											var str = document.getElementById("ID'.$increment.'").className;
											otherUser = str;
											showUserInfo();
											
											setTimeout(() => {  showUser(); }, 1500);
											startTimer();
										}
										</script>
										';
										$increment = $increment + 1;
									}
								}
							}?>
						</ui>
					</div>
					<div class="card-footer"></div>
				</div>
			</div>
				
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight" id="txtHintInfo">	
								
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i><a href="account_other_user.php" style="color:fff"> Voir Profil</a></li>
								</ul>
							</div>
						</div>

						<div class="card-body msg_card_body" id="txtHint">
							<h4>C'est bien vide ici</h4></i><br><h4>Cliquez sur une conversation pour commencer</h4>
						</div>
						<form id="messageForm" method="get">
						<div class="card-footer">
							<div class="input-group">
								<input id="textArea"type="text" name="textarea" class="form-control type_msg" placeholder="Ecrivez votre message...">
								<button id="sendMessage" name="send" class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>