<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

if (isset($_POST) && isset($_POST['codecli'])) {
	$codecli = $_POST['codecli'];

	$listes = $DB->query("SELECT ean, codemag, libelle, id_tournee, numtournee, dateheure_exp, dateheure_rec from palette join client on LPAD(client.codecli,5,'0')=LPAD(palette.codemag,5,'0') join tournee on tournee.id=id_tournee WHERE codemag LIKE '%".$codecli."%'");
	}
include 'header.php';
?>

<div class="container">
	<div class="row">
		<div class="alert alert-success text-center">
			<h1>RESULTAT DE LA RECHERCHE</h1>
			<h2>Client : <?= '<strong>'.$codecli.' - '.$listes[0]->libelle.'</strong>' ?></h2>
		</div>
		<table id="tabledb" class="table table-hover">
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
				<?php endforeach ?>
			</tbody>
		</table>		
	</div>
</div>

<script>
$(document).ready(function() {
    $('#tabledb').DataTable( {
		paging		: true,
		searching	: false,
    	language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichagee de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichagee de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
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
		"order"			: [[ 1, "desc" ]],
		"scrollCollapse": false,
		"lengthChange"	: false,
		"processing"	: true,
		"autoWidth"		: true
	})
} );
</script>