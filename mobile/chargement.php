<!--
	12/10/14 : Modification du calcul du numéro de tournée.
	
-->
<?php 
include '../includes.php'; 

if (isset($_GET['value'])) {
	$jour     = date('w');
	$compteur = $DB->getAndUpdateCompteur();
	$site     = intval ($_GET['value']);
	$tournee  = str_pad($compteur,5,"0",STR_PAD_LEFT)."-";
	
	if ($site == 0) {
		// Grans vers SALON
		$calcul = 1000 * $jour + 800;
		$tournee .= str_pad($calcul,4,"0",STR_PAD_LEFT);
	} else {
		// Salon vers GRANS
		$calcul = 1000 * $jour + 100;
		$tournee .= str_pad($calcul,4,"0",STR_PAD_LEFT);
	}

	$_SESSION['tournee']    = $tournee;
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
	$listes = $DB->tquery("SELECT id FROM ".$table." WHERE ean='{$ean}' AND id_tournee='{$_SESSION['numTournee']}' AND receive=0");
	// ean & numTournée déja existants -> mettre à jour code client et la date
	if (!empty($listes)) {
		$id  = $listes[0]['id'];
		$now = strftime("%F %T");
		$nb  = $DB->updateDB(array('codemag' => $codemag, 'dateheure_exp'=>$now), $id);
	} else {
		// Si ean, numéro de tournéee et code magasin existent on ne fait rien sinon nouvel enregistrement.
		$listes = $DB->tquery("SELECT id FROM {$table} WHERE ean='{$ean}' AND id_tournee='{$_SESSION['numTournee']}' AND codemag='{$codemag}' AND receive=0");
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
		
	    <form method="POST" action="chargement.php" name="chargement" onsubmit="return validateEAN()">
	     	
	     	Code client : </br>
	     	<input type="text" name="codemag" id="codemag" maxlength="5" onkeydown="if(event.keyCode==13) event.keyCode=9;" onchange="return libelleMagasin()"></br>
			<div id="libellemag"></div>

			EAN (8 car. mini...) : </br>
	     	<input type="text" name="ean" id="ean" maxlength="15"></br>
	     	<div id="erreurEan" style ='color:red'></div>

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


	function libelleMagasin()
	{
	var codeMagasin = document.getElementById("codemag").value;
	if (codeMagasin.length >= 3){
	var xhr;
	 if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	    xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE 8 and older
	    xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = "codeMagasin=" + codeMagasin;
	     xhr.open("POST", "recherche-mag.php", true); 
	     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
	     xhr.send(data);
		 xhr.onreadystatechange = afficherMagasin;
		function afficherMagasin() {
		 if (xhr.readyState == 4) {
	      if (xhr.status == 200) {
		  document.getElementById("libellemag").innerHTML = xhr.responseText;
		  return true;
	      } else {
	        alert('Problème de connexion.');
	        return false;
	      }
	     }
		}
	} else {
		alert ("Le code magasin doit faire au moins 3 caractères !");
		document.chargement.codemag.focus();
		return false;
	}
}
</script>
</html>