<?php
include '../includes.php';

if (!empty($_POST) & !empty($_POST['ean'])) {
	$table     = T_PALETTE;
	$DB->table = $table;
	$ean       = $_POST['ean'];
	// $now     = strftime("%F %T");
	$_SESSION['numPalette']++;

	// Si ean et numero de tournée existent déjà, mettre à jour la ligne
	$listes = $DB->tquery("SELECT id FROM ".$table." WHERE ean='{$ean}' AND id_tournee='{$_SESSION['numTournee']}' AND receive=0");
	// ean & numTournée déja existants -> mettre à jour code client et la date
	if (!empty($listes)) {
		$id  = $listes[0]['id'];
		$now = strftime("%F %T");
		$nb  = $DB->updateDB(array('dateheure_exp'=>$now), $id);
	} else {
		// Si ean, numéro de tournéee et code magasin existent on ne fait rien sinon nouvel enregistrement.
		$listes = $DB->tquery("SELECT id FROM {$table} WHERE ean='{$ean}' AND id_tournee='{$_SESSION['numTournee']}' AND receive=0");
		// Non existant -> Enregistrement
		if (empty($listes)){
			$data    = array('ean'=>$ean, 'receive'=>0, 'id_tournee'=>$_SESSION['numTournee']);
			$nb      = $DB->insertIntoDB($data);
		}
	}
} else {
	$jour     = date('w');
	$compteur = $DB->getAndUpdateCompteur();
	// Calcul du n° de tournée
	// Afficher la date sous forme AAMMJJ
	$tournee  = str_pad($compteur,5,"0",STR_PAD_LEFT)."-".date('ymd', strtotime('now'));

	$_SESSION['tournee']    = $tournee;
	$table                  = T_TOURNEE;
	$DB->table              = $table;
	$numTournee             = $DB->insertIntoDB(array('numtournee'=>$tournee));
	$_SESSION['numTournee'] = $numTournee;
	$_SESSION['numPalette'] = 0;
}
?>

<!doctype html>
    <head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	    <meta name="viewport" content="user-scalable=no">
        <title>Chargement</title>
        <link rel="stylesheet" href="mobile.css">
    </head>
    <body OnLoad="document.chargement.ean.focus()">
		<h4>Tournée : <?= $_SESSION['tournee'] ?></h4>

	    <form method="POST" action="chargement.php" name="chargement" onsubmit="return validateEAN()">

	     	<input type="text" name="ean" id="ean" class="input-support" maxlength="20"></br>
	     	<div id="erreurEan" style ='color:red'></div>
	     	<!-- <button id="button" type="submit"><strong>Valider</strong></button> -->
	     	<br>
			<a href="index.php" class="click">Fin Chargement</a>
	     	<!-- <button type="button" onclick="location.href='index.php'"><strong>Fin chargement</strong></button> -->
	    </form>
	    <?php
			if ($_SESSION['numPalette'] > 1) {
				echo "Palettes déja scannées : ".$_SESSION['numPalette']."</br>";
			} else {
				echo "Palette déja scannée : ".$_SESSION['numPalette']."</br>";
			}
			echo "";
		 ?>
    </body>

<script>

	function validateEAN(){
		var ean = document.getElementById("ean").value;
		if (ean.length < 8) {
			alert ("Le code EAN doit faire au moins 8 caractères !");
			//document.getElementById("erreurEan").innerHTML="<span>Code EAN erroné...</span><bgsound src='file://\Application\alert.wav'>";
			document.chargement.ean.focus();
			return false;
		} else {
			return true;
		}

	}
}
</script>
</html>