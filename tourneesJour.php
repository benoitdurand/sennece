<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;
$listes = $DB->query("SELECT count(distinct id_tournee) as tournee, date(dateheure_exp) as jour, count(ean) as totalEan, sum(receive) as recept from palette where id_tournee IS NOT NULL group by jour order by jour DESC");

?>

<!doctype html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Chargement</title>
            <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<div class="container">
	<div class="row">
		<div class="alert alert-info text-center"><h1>Détail par jour</h1></div>
		<table id="tabledb" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="text-center col-md-2"><strong>Date</strong></th>
					<th class="text-center col-md-1"><strong>NB Tournées</strong></th>
					<th class="text-center col-md-1"><strong>Chargement</strong></th>
					<th class="text-center col-md-1"><strong>Reception</strong></th>
					<th class="text-center col-md-1"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($listes as $liste): ?>
					<tr onclick="tourneeJour('<?= $liste->jour ?>')">
						<td class="text-right col-md-2"><?php echo $liste->jour; ?></td>
						<td class="text-right col-md-1"><?php echo $liste->tournee; ?></td>
						<td class="text-right col-md-1"><?php echo $liste->totalEan; ?></td>
						<td class="text-right col-md-1"><?php echo $liste->recept; ?></td>
						<td class='text-center col-md-1'><a href='export_journee_csv.php?date=<?php echo $liste->jour; ?>' type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-export'></span></a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/dataTables.bootstrap.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
    $('#tabledb').DataTable( {
		paging    	: true,
		searching	: false,
    	language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
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
    },
		"paging"		: true,
		"order"			: [[ 1, "desc" ]],
		"scrollCollapse": false,
		"lengthChange"	: false,
		"processing"	: true,
		"autoWidth"		: true
	})
} );

</script>
