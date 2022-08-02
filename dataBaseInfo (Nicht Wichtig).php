<?php
    /*CE DOCUMENT N'EST ACCESSIBLE QUE PAR LE USER AILYRR*/
    
    require 'util.php';
    init_php_session();
    /*if($_SESSION['User_ID'] != "Ailyrr"){
      header("Location: index.php");
    }*/

  echo '<p class="abruf">Seite abgerufen am ', date('d.m.Y \u\m H:i:s'), ' Uhr</p>';
 
    $servername = /*DB Login Credentials*/;
	$username = /*DB Login Credentials*/;
	$password = /*DB Login Credentials*/;
	$dbname = /*DB Login Credentials*/;
    


// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
	if ($conn->query($sql) === TRUE) {
  		echo "New record created successfully";
	} else {
  		echo "Error: " . $sql . "<br>" . $conn->error;
	}



	$sql = "Select * From mes_users";

echo "<hr/>";
	if (!$conn->query($sql)) {
		echo "Fehler: <br/>";
  		echo($conn -> error);
	}else{
		$result = $conn->query($sql);
	}

$output = "<table cellspacing='5'>";
foreach($result as $key => $var) {
    //$output .= '<tr>';
    if($key===0) {
        $output .= '<tr>';
        foreach($var as $col => $val) {
           $output .= "<th>" . $col . '</th>';
        }
        $output .= '</tr>';
        foreach($var as $col => $val) {
            $output .= '<td>' . $val . '</td>';
        }
        $output .= '</tr>';
    }
    else {
        $output .= '<tr>';
        foreach($var as $col => $val) {
            $output .= '<td>' . $val . '</td>';
        }
        $output .= '</tr>';
    }
}
$output .= '</table>';
echo $output;

$conn->close();
?>
