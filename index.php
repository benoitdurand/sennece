<?php 
include 'includes.php'; 

$table     = T_CAMION;
$DB->table = $table;

if (!empty($_POST) & !empty($_POST['ean']) & !empty($_POST['codemag'])) {
	$codemag = $_POST['codemag'];
	$ean     = $_POST['ean'];
	$now     = strftime("%F %T");
	$data    = array('codemag'=>$codemag, 'ean'=>$ean, 'dateheure'=>$now);       
	$nb      = $DB->insertIntoDB($data);
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Chargement</title>
        <style type="text/css">
			.bouton{
				height: 50px;
				width: 100%;
				margin-bottom: 20px;
			}
			h3 {
				text-align: center;
			}
        </style>
    </head>
    <body>
		<h3>MENU</h3>
		<button type="button" onclick="location.href='chargement.php?value=0'" class="bouton">Chargement pour Salon</button> 
		<button type="button" onclick="location.href='chargement.php?value=1'" class="bouton">Chargement pour Grans</button> 
		<button type="button" onclick="location.href='reception.php'"class="bouton">Reception</button> 
    </body>
</html>