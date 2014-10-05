<?php
include '../includes.php'; 
	
	if (isset($_POST)){
		$codeMagasin = str_pad($_POST['codeMagasin'],5,"0",STR_PAD_LEFT);
		$table       = T_CLIENT;
		$DB->table   = $table;

		$magasin=$DB->tquery("SELECT libelle FROM {$table} WHERE codecli='{$codeMagasin}' LIMIT 1");
		if (!empty($magasin)) {
			echo "<div style ='color:green'>".$magasin[0]['libelle']."</div>";
		} else {
			echo "<div style ='color:red'>Magasin inconnu...</div>";
			echo "<bgsound src='file://\Application\alert.wav'>";
		}
	}
?>

