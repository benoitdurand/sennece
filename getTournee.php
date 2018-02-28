<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

if (isset($_POST) && isset($_POST['tournee'])) {
	$tournee = $_POST['tournee'];
	$stats = $DB->tquery ("SELECT id_tournee, numtournee, count(id_tournee) as nbexp, sum(receive) as nbrec, min(dateheure_exp) as debutchargement, max(dateheure_exp) as finchargement, min(dateheure_rec), max(dateheure_rec) from palette join tournee on palette.id_tournee=tournee.id  WHERE id_tournee={$tournee} group by id_tournee");

	$listes = $DB->query("SELECT ean, id_tournee, numtournee, dateheure_exp, dateheure_rec from palette join tournee on tournee.id=id_tournee WHERE id_tournee={$tournee} ORDER BY dateheure_exp DESC");
	}
?>

	<div class="row">
		<?php $tourn = "";   ?>
		<div class="alert alert-warning"><h2>Tournée : <?= $stats[0]['numtournee'].$tourn ?></h2></div>
		<?php
				if ($stats[0]['nbrec'] != $stats[0]['nbexp']) {
					$result = $stats[0]['nbexp'] - $stats[0]['nbrec'];
					$msg = "<div class='bs-callout bs-callout-danger'>Il manque <strong>".$result."</strong> ";
					if ($result >1) {
						$msg .= "</strong> palettes</div>";
					} else {
						$msg .= "</strong> palette</div>";
					}
					echo $msg;
				}
		?>
        <div class="col-md-12">
		<table id="tabledbdetail" class="table table-hover table-striped">
			<thead>
				<tr>
					<th class="text-center col-sm-1"><strong>#</strong></th>
					<th class="text-center col-sm-1"><strong>EAN</strong></th>
					<th class="text-center col-sm-2"><strong>Chargement</strong></th>
					<th class="text-center col-sm-2"><strong>Reception</strong></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$nbLignes = 1;
				foreach ($listes as $liste): ?>
				<tr>
						<td class="text-right"><strong><?php echo str_pad($nbLignes,3,"0",STR_PAD_LEFT); ?></strong></td>
						<td class="text-right"><strong><?php echo $liste->ean; ?></strong></td>
						<td class="text-right"><?php echo texte::short_french_date_time($liste->dateheure_exp); ?></td>
						<?php if (!empty($liste->dateheure_rec)) {
							echo "<td class='text-right'>".texte::short_french_date_time($liste->dateheure_rec)."</td>";
						} else {
							echo "<td class='text-center danger'><strong><span class='glyphicon glyphicon-time'></span></strong></td>";
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
    $('#tabledbdetail').DataTable({
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
		"searching"		: true,
		"scrollCollapse": false,
		"paging"		: true,
		"lengthChange"	: true,
		"processing"	: true,
		"autoWidth"		: true
	})
} );
</script>