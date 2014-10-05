<?php 
include 'includes.php'; 

$numTournee = "";
$nbPalettes = 0;
$restant    = 0;

if (!empty($_POST) & !empty($_POST['ean'])) {
	$table     = T_PALETTE;
	$DB->table = $table;
	$ean       = $_POST['ean'];

	// Recherche du n° de tournée à partir de l'ean scanné.
	$tournees = $DB->tquery("SELECT t1.id, t1.id_tournee, t2.numtournee FROM ".$table." AS t1 JOIN ".T_TOURNEE." AS t2 ON t1.id_tournee = t2.id WHERE ean='{$ean}' AND receive=0");
	if (!empty($tournees)) {
		// Palette trouvée -> Mettre à jour.
		$numTournee = $tournees[0]['numtournee'];
		$idPalette  = $tournees[0]['id'];
		$idTournee  = $tournees[0]['id_tournee'];

		$_SESSION['numTournee'] = $numTournee;
		$_SESSION['idTournee']  = $idTournee;

		// Nombre total de palette a receptionner.
		$palettes   = $DB->tquery("SELECT COUNT(id_tournee) as total FROM {$table} WHERE id_tournee={$idTournee}");
		$now        = strftime("%F %T");

		// Nombre de palettes restant à receptionner.
		$nb         = $DB->insert("UPDATE {$table} SET receive=1, dateheure_rec='{$now}' WHERE ean='{$ean}' AND receive=0");
		$aFaire     = $DB->tquery("SELECT COUNT(id_tournee) as total FROM {$table} WHERE id_tournee={$idTournee} AND receive=0");
		$nbPalettes = $palettes[0]['total'];
		$restant    = $aFaire[0]['total'];
	} else {
		echo "<div style='color:red'>La palette que vous venez de scanner est inconnue</div></br>";
		echo "<bgsound src='file://\Application\alert.wav'>";
	}
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Chargement</title>
    </head>
    <body OnLoad="document.reception.ean.focus()">
		<form method="POST" action="reception.php" name="reception">

			EAN : </br>
	     	<input type="text" name="ean" id="ean" maxlength="45"></br>

	     	<input type="submit" value="Valider">
	     	<button type="button" onclick="location.href='index.php'">Fin reception</button>
	    </form>


	    <?php
			echo("Tournée : $numTournee</br>");
			echo("Nb total palettes : $nbPalettes</br>");
			echo("Reste à flasher : $restant</br>");			
		 ?>
    </body>
</html>