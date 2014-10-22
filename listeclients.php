<?php
include 'includes.php';

$table     = T_CLIENT;
$DB->table = $table;

// select c.ean, c.codemag, clt.libelle, dateheure from camion as c JOIN client as clt ON RIGHT('00000'+c.codemag,5) = RIGHT('00000'+clt.codecli,5);

// $listes = $DB->query("SELECT * FROM ".T_CAMION." ORDER BY dateheure DESC");
	$listes = $DB->query("SELECT codecli, libelle FROM {$table} ORDER BY codecli");

include 'header.php';

?>

<script>
	$(document).ready(function() 
    { 
        $('#tabledb').DataTable( {
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
		"pagingType"	: "full",
		"scrollY"		: "700px",
		"scrollX"		: true,
		"scrollCollapse": false,
		"paging"		: false
	})
});
</script>
<div class="container">
	<div class="row">
	
			<h1>Liste des chargements</h1>
			<table id="tabledb" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="text-center col-lg-1 col-md-1"><strong>Code Client</th>
						<th class="text-center col-lg-4"><strong>Libelle</strong></th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($listes as $liste): ?>
					<tr>
							<td class="text-right col-lg-1 col-md-1"><?php echo $liste->codecli; ?></td>
							<td class="text-left col-lg-2 col-md-1"><?php echo $liste->libelle; ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
	<div>
</div>