<?php 
	include '../includes.php'; 

	if(isset($_SESSION['tournee'])){
		unset($_SESSION['tournee']);
	}

	if(isset($_SESSION['numTournee'])){
		unset($_SESSION['numTournee']);
	}

	if(isset($_SESSION['numPalette'])){
		unset($_SESSION['numPalette']);
	}

	if(isset($_SESSION['idTournee'])){
		unset($_SESSION['idTournee']);
	}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Chargement</title>
        <style type="text/css">
			.bouton{
				height: 40px;
				width: 100%;
				margin-bottom: 10px;
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