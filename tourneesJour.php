<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;
	$listes = $DB->query("SELECT count(distinct id_tournee) as tournee, date(dateheure_exp) as jour, count(ean) as totalEan, sum(receive) as recept from palette where id_tournee IS NOT NULL group by jour order by jour DESC");

include 'header.php';

?>

<script>
	$(document).ready(function() 
    { 
        $('#tabledbJour').DataTable( {
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
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    },
		"order"			: [[ 0, "desc" ]],
		"searching"		: true,
		"scrollCollapse": false,
		"paging"		: false,
		"lengthChange"	: false,
		"processing"	: true,
		"autoWidth"		: false
	})
});

</script>
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
							<td class='text-center col-md-1'><a href='export_tournee_csv.php?date=<?php echo $liste->jour; ?>' type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-export'></span></a></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
	<div>
</div>