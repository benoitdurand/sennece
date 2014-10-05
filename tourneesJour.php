<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

// select c.ean, c.codemag, clt.libelle, dateheure from camion as c JOIN client as clt ON RIGHT('00000'+c.codemag,5) = RIGHT('00000'+clt.codecli,5);

// $listes = $DB->query("SELECT * FROM ".T_CAMION." ORDER BY dateheure DESC");
	$listes = $DB->query("SELECT c.ean, c.codemag, clt.libelle, dateheure_exp, dateheure_rec, c.id_tournee, t.numtournee FROM {$table} AS c LEFT JOIN ".T_CLIENT." AS clt ON RIGHT('00000'+c.codemag,5) = RIGHT('00000'+clt.codecli,5) JOIN ".T_TOURNEE." AS t ON c.id_tournee=t.id WHERE DATE(dateheure_exp)=CURDATE() ORDER BY dateheure_exp DESC");

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
		"order"			: [[ 4, "desc" ]],
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
	
			<h1>Liste des chargements du jour</h1>
			<table id="tabledb" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="text-center col-lg-1 col-md-1"><strong>Tournée</th>
						<th class="text-center col-lg-2"><strong>EAN Palette</strong></th>
						<th class="text-center col-lg-1 col-md-1"><strong>Code client</strong></th>
						<th class="text-center col-lg-3"><strong>Magasin</strong></th>
						<th class="text-center col-lg-1 col-md-1"><strong>Exp.</strong></th>
						<th class="text-center col-lg-1 col-md-1"><strong>Rec.</strong></th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($listes as $liste): ?>
					<tr>
							<td class="text-right col-lg-1 col-md-1"><?php echo $liste->numtournee; ?></td>
							<td class="text-right col-lg-2 col-md-1"><?php echo $liste->ean; ?></td>
							<td class="text-right col-lg-1 col-md-1"><?php echo $liste->codemag; ?></td>
							<td class="text-left col-lg-3 col-md-1"><?php echo $liste->libelle; ?></td>
							<td class="text-right col-lg-1 col-md-1"><?php echo texte::extract_time($liste->dateheure_exp); ?></td>
							<?php if (!empty($liste->dateheure_rec)) {
								echo "<td class='text-right col-lg-1 col-md-1'>".texte::extract_time($liste->dateheure_rec)."</td>";
							} else {
								echo "<td class='text-center col-lg-1 col-md-1'>En cours</td>";
							} ?>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
	<div>
</div>