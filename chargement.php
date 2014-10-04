<?php 
include 'includes.php'; 

$table     = T_PALETTE;
$DB->table = $table;
$jour      = date('w');


if (isset($_GET['value'])) {
	$compteur  = $DB->getAndUpdateCompteur();
	$site = intval ($_GET['value']);
	$tournee = str_pad($compteur,5,"0",STR_PAD_LEFT)."-";
	
	if ($site == 0) {
		// Salon vers GRANS
		$tournee .= (string) 1000 * $jour + 100;
	} else {
		// Grans vers SALON
		$tournee .= (string) 1000 * $jour + 800;
	}
	$_SESSION['tournee']= $tournee;

	$table                  = T_TOURNEE;
	$DB->table              = $table;
	$numTournee             = $DB->insertIntoDB(array('numtournee'=>$tournee));
	$_SESSION['numTournee'] = $numTournee;
	$_SESSION['numPalette'] = 0;

}

if (!empty($_POST) & !empty($_POST['ean']) & !empty($_POST['codemag'])) {
	$table     = T_PALETTE;
	$DB->table = $table;
	$codemag   = $_POST['codemag'];
	$ean       = $_POST['ean'];
	// $now     = strftime("%F %T");
	$_SESSION['numPalette']++;

	// Si ean et numero de tournée existent déjà, mettre à jour la ligne
	$listes = $DB->tquery("SELECT id FROM ".T_PALETTE." WHERE ean={$ean} AND id_tournee={$_SESSION['numTournee']} AND receive=0");
	// ean & numTournée déja existants -> mettre à jour code client et la date
	if (!empty($listes)) {
		$id  = $listes[0]['id'];
		$now = strftime("%F %T");
		$nb  = $DB->updateDB(array('codemag' => $codemag, 'dateheure_exp'=>$now), $id);
	} else {
		// Si ean, numéro de tournéee et code magasin existent on ne fait rien sinon nouvel enregistrement.
		$listes = $DB->tquery("SELECT id FROM ".T_PALETTE." WHERE ean={$ean} AND id_tournee={$_SESSION['numTournee']} AND codemag={$codemag} AND receive=0");
		// Non existant -> Enregistrement
		if (empty($listes)){
			$data    = array('codemag'=>$codemag, 'ean'=>$ean, 'receive'=>0, 'id_tournee'=>$_SESSION['numTournee']);       
			$nb      = $DB->insertIntoDB($data);
		}
	}
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Chargement</title>
    </head>
    <body OnLoad="document.chargement.codemag.focus()">
		<h4>Tournée : <?= $_SESSION['tournee'] ?></h4>
		
	    <form method="POST" action="chargement.php" name="chargement">
	     	
	     	Code client : </br>
	     	<input type="text" name="codemag" id="codemag" maxlength="5" onkeydown="if(event.keyCode==13) event.keyCode=9;"></br>

			EAN : </br>
	     	<input type="text" name="ean" id="ean" maxlength="45"></br>

	     	<input type="submit" value="Valider">
	     	<button type="button" onclick="location.href='index.php'">Fin chargement</button>
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
</html>