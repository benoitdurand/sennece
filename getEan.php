<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

if (isset($_POST) && isset($_POST['ean'])) {
	$ean = substr($_POST['ean'], 0, 20);

	$listes = $DB->query("SELECT `ean`, `id_tournee`, `numtournee`, `dateheure_exp`, `dateheure_rec` FROM `palette` JOIN `tournee` ON `tournee`.`id` = `id_tournee` WHERE `ean` LIKE '%".$ean."%'");
	}
?>
<!doctype html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Recherche</title>
            <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<div class="container">
	<div class="row">
		<div class="alert alert-success text-center">
			<h1>RESULTAT DE LA RECHERCHE</h1>
			<h2>Palette : <?= $ean ?></h2>
		</div>
		<table id="tabledbdetail" class="table table-hover">
			<thead>
				<tr>
					<th class="text-center col-sm-1"><strong>Palette</strong></th>
					<th class="text-center col-sm-1"><strong>Tournée</strong></th>
					<th class="text-center col-sm-2"><strong>Chargement</strong></th>
					<th class="text-center col-sm-2"><strong>Reception</strong></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$nbLignes = 1;
				foreach ($listes as $liste): ?>
				<tr>
					<td class="text-right"><strong><?php echo $liste->ean; ?></strong></td>
					<td class="text-right"><strong><?php echo $liste->numtournee; ?></strong></td>
					<td class="text-right"><?php echo texte::short_french_date_time($liste->dateheure_exp); ?></td>
					<?php if (!empty($liste->dateheure_rec)) {
						echo "<td class='text-right'>".texte::short_french_date_time($liste->dateheure_rec)."</td>";
					} else {
						echo "<td class='text-center danger'><strong>Non receptionné</strong></td>";
					} ?>
				</tr>
				<?php
				$nbLignes ++;
				endforeach ?>
			</tbody>
		</table>
	</div>
</div>

    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {
    $('#tabledbdetail').DataTable( {
    	language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:     "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    },
		"order"			: [[ 2, "desc" ]],
		"searching"		: false,
		"scrollCollapse": false,
		"paging"		: true,
		"lengthChange"	: false,
		"processing"	: true,
		"autoWidth"		: true
	})
} );
</script>