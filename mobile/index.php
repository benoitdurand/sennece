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
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no">
        <link rel="stylesheet" href="mobile.css">
    <head>
        <!-- <meta name="viewport" content="width=device-width"> -->
        <title>Chargement</title>
    </head>
    <body>
		<h3>TRANSIT SENNECE</h3>
		<a href="chargement.php" class="click">Chargement</a>
		<a href="reception.php" class="click">Reception</a>
		<a href="../../index.php" class="click">retour Menu</a>
    </body>
</html>