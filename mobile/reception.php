<?php
include '../includes.php';

$numTournee = "";
$nbPalettes = 0;
$restant    = 0;

if (!empty($_POST) & !empty($_POST['ean'])) {
	$table     = T_PALETTE;
	$DB->table = $table;
	$ean       = $_POST['ean'];

	// Recherche du n° de tournée à partir de l'ean scanné.
	$tournees = $DB->tquery("SELECT `t1`.`id`, `t1`.`id_tournee`, `t2`.`numtournee`
		FROM ".$table." AS t1 JOIN ".T_TOURNEE." AS t2 ON `t1`.`id_tournee` = `t2`.`id` WHERE `ean` = '{$ean}' AND `receive` = 0");
	if (!empty($tournees)) {
		// Palette trouvée -> Mettre à jour.
		$numTournee = $tournees[0]['numtournee'];
		$idPalette  = $tournees[0]['id'];
		$idTournee  = $tournees[0]['id_tournee'];

		$_SESSION['numTournee'] = $numTournee;
		$_SESSION['idTournee']  = $idTournee;

		// Nombre total de palette a receptionner.
		$palettes   = $DB->tquery("SELECT COUNT(*) as total FROM {$table} WHERE id_tournee={$idTournee}");
		$now        = strftime("%F %T");

		// Nombre de palettes restant à receptionner.
		$DB->insert("UPDATE {$table} SET receive = 1, dateheure_rec = '{$now}' WHERE ean = '{$ean}' AND receive = 0");
		// $sql="UPDATE tournee SET start_receipt = 1 WHERE numtournee = {$idTournee} AND start_receipt = 0";
		// var_dump($sql);
		// die();
		$DB->insert("UPDATE tournee SET start_receipt = 1 WHERE id = '{$idTournee}' AND start_receipt = 0");

		$aFaire     = $DB->tquery("SELECT COUNT(*) as total FROM {$table} WHERE id_tournee = {$idTournee} AND receive = 0");
		$nbPalettes = $palettes[0]['total'];
		$restant    = $aFaire[0]['total'];
	} else {
		$erreur = "Palette inconnue, contacter le responsable.";
		echo "<bgsound src='file://\Application\alert.wav'>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	    <meta name="viewport" content="user-scalable=no">
	    <link rel="stylesheet" href="mobile.css">
	    <title>Réception</title>
    </head>
    <body OnLoad="document.reception.ean.focus()">
		<form method="POST" action="reception.php" name="reception">
			<h4>reception</h4>
	     	<input type="text" name="ean" id="ean" class="input-support" maxlength="20" ></br>
	     	<?php if (isset($erreur)) : ?>
                <div id="error"><strong><?= $erreur; ?></strong></div>
            <?php endif ?>

	     	<!-- <button id="button" type="submit"><strong>Valider</strong></button> -->
	     	<a href="index.php" class="click">Fin reception</a>
	     	<!-- <button type="button" onclick="location.href='index.php'"><strong>Fin reception</strong></button> -->
	    </form>

	    <?php
			echo("Tournée : $numTournee</br>");
			echo("Nb total palettes : $nbPalettes</br>");
			echo("Reste à flasher : $restant</br>");
		 ?>
    </body>
</html>