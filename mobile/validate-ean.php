<?php
include '../includes.php'; 
	
	if (isset($_POST)){
		$ean = $_POST['ean'];
		if (strlen($ean) < 8) {
			echo "<div style ='color:red'>EAN inconnu</div>";
			echo "<bgsound src='file://\Application\alert.wav'>";
		}
	}
?>

