<?php 
include 'includes.php'; 

$table     = T_PALETTE;
$DB->table = $table;

$jour = date('w');

if (isset($_GET['value'])) {
	$compteur  = $DB->getAndUpdateCompteur();
	$site = intval ($_GET['value']);
	$tournee = texte::right("0000".$compteur,5)."-";
	if ($site == 0) {
		$tournee .= (string) 1000 * $jour + 100;
	} else
	{
		$tournee .= (string) 1000 * $jour + 800;
	}
	$_SESSION['tournee']= $tournee;
}

if (isset($_GET['tournee'])) {
	$tournee = $_GET['tournee'];
	}

if (!empty($_POST) & !empty($_POST['ean']) & !empty($_POST['codemag'])) {
	$codemag = $_POST['codemag'];
	$ean     = str_pad($_POST['ean'],5,'0',STR_PAD_LEFT);
	$now     = strftime("%F %T");
	$data    = array('codemag'=>$codemag, 'ean'=>$ean, 'dateheure_exp'=>$now);       
	$nb      = $DB->insertIntoDB($data);
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Chargement</title>
    </head>
    <body>
		<h3>Chargement camion - <?= $_SESSION['tournee'] ?></h3>
	    <form method="POST" action="chargement.php" name="chargement">
	     	
	     	Code client : </br>
	     	<input type="text" name="codemag" id="codemag" onkeydown="if(event.keyCode==13) event.keyCode=9;"></br>

			EAN : </br>
	     	<input type="text" name="ean" id="ean"></br>

	     	<input type="submit" value="Valider">
	    </form>
    </body>
</html>