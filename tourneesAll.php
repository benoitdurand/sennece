<?php
	include 'includes.php';

	$table     = T_PALETTE;
	$DB->table = $table;

	if (isset($_POST) && (isset($_POST['date']))) {
		$range  = $_POST['date'];
		$jour   = date('w');
		// Penser a remettre $jour == 1

			if ($range == "jour") {
				$dateRange = ($jour == 1) ? 2 : 1;
				$day1 = date('Y-m-d', strtotime('now'));
				$day2 = date('Y-m-d', strtotime('-'.$dateRange.' days '));
				$title = "Chargements et receptions du ".date('d-m-y', strtotime('now'))." et du ".date('d-m-y', strtotime('-'.$dateRange.' days '));
			} elseif ($range == "semaine") {
				$day2 = date('Y-m-d', strtotime('Last Monday'));
				$day1 = date('Y-m-d', strtotime('Sunday'));
				$title = "Chargements et receptions du ".date('d-m-Y', strtotime('Last Monday'))." au ".date('d-m-Y', strtotime('Sunday'));
			} else {
				$day1 = date('Y-m-d', strtotime($range));
				$day2 = date('Y-m-d', strtotime($range));
				$title = "Chargements et receptions du ".$range;
			}

			$sql = "SELECT id_tournee, numtournee, count(id_tournee) as nbexp, sum(receive) as nbrec, min(dateheure_exp) as debutchargement, max(dateheure_exp) as finchargement, min(dateheure_rec) as debutreception, max(dateheure_rec) as finreception 
						from palette join tournee on palette.id_tournee=tournee.id WHERE date(dateheure_exp) BETWEEN '$day2' AND '$day1' group by id_tournee ORDER BY numtournee DESC";
			$listes = $DB->query($sql);
	}
	include 'header.php';

?>

<div class="container">
	<div class="row">
			<div class="alert alert-info text-center"><h1><?= $title; ?></h1></div>
			<table id="tabledb" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th></th>
						<th class="text-center" colspan="3"><strong>Chargement</strong></th>
						<th class="text-center" colspan="3"><strong>Reception</strong></th>
					</tr>
					<tr>
						<th class="text-center col-sm-2"><strong>Tournée</th>
						<th class="text-center col-sm-2"><strong>Début</strong></th>
						<th class="text-center col-sm-2"><strong>Fin</strong></th>
						<th class="text-center col-sm-1"><strong>Nb</strong></th>
						<th class="text-center col-sm-2"><strong>Debut</strong></th>
						<th class="text-center col-sm-2"><strong>Fin</strong></th>
						<th class="text-center col-sm-1"><strong>Nb</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listes as $liste): ?>
					<tr data-id="<?= $liste->id_tournee ?>" onclick="detailModal(<?= $liste->id_tournee ?>)">
							<?php
								$tourn = substr($liste->numtournee, -3) == "800"? " (G->S)" : " (S->G)";  
								if (empty($liste->debutreception)) {
									$now = strtotime(date('Y-m-d H:i:s'));
									$last = strtotime($liste->finchargement);
									$temp = (int)($now-$last)/60;
									if ($temp > 120) {
										echo "<td class='text-right danger'><span class='glyphicon glyphicon-time'></span> <strong>  $liste->numtournee $tourn</strong></td>";
									} else {
										echo "<td class='text-right warning'><strong>$liste->numtournee $tourn</strong></td>";
									}
								}  else {
										echo "<td class='text-right info'><strong>$liste->numtournee $tourn</strong></td>";
									}
							?>
							<td class="text-right"><?php echo texte::short_french_date_time($liste->debutchargement); ?></td>
							<td class="text-right"><?php echo texte::short_french_date_time($liste->finchargement); ?></td>
							<td class="text-right success"><?php echo $liste->nbexp; ?></td>
							<?php if (!empty($liste->debutreception)) {
								echo "<td class='text-right'>".texte::short_french_date_time($liste->debutreception)."</td>";
							} else {
								echo "<td class='text-center'>En cours</td>";
							} ?>

							<?php if (!empty($liste->finreception)) {
								echo "<td class='text-right'>".texte::short_french_date_time($liste->finreception)."</td>";
							} else {
								echo "<td class='text-center'>En cours</td>";
							} ?>
							<?php if ($liste->nbrec != $liste->nbexp) :?>
								<td class="text-right danger"><strong><?php echo $liste->nbrec; ?></strong></td>
							<?php else :?>
								<td class="text-right success"><?php echo $liste->nbrec; ?></td>
							<?php endif ?>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>		
	</div>
</div>

		<div class="modal fade detailModal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
  				<div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			          <h3 class="modal-title">DETAIL D'UNE TOURNEE</h3>
			    </div>
      				<div class="modal-body"></div>
	    			<div class="modal-footer">
	        			<button type='button' class='btn btn-primary' id ="exportcsv" onclick="exportcsv()">Exporter</button>
	        			<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
	      			</div>
    			</div>
  			</div>
		</div>

<script>

function exportCSV(id) {
	document.location.href = "exportcsv.php?tournee="+id;
}

function detailModal(id){
  	$.post ("getTournee.php", {tournee:id} , function(data){
  		$( ".modal-body" ).empty().append( data );
  		$( '#exportcsv').attr("onClick", "exportCSV("+id+")");
  	});

  $('.detailModal').modal({
    keyboard: true,
    backdrop: "static"
  });
};

$('.detailModal').on('shown.bs.modal', function () {
    $(this).find('.modal-dialog').css({width:'100%',
                               height:'auto', 
                              'max-height':'100%'});
});



</script>