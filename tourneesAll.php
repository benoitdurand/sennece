<?php
	include 'includes.php';

	$table     = T_PALETTE;
	$DB->table = $table;

	$listes = $DB->query("SELECT id_tournee, numtournee, count(id_tournee) as nbexp, sum(receive) as nbrec, min(dateheure_exp) as debutchargement, max(dateheure_exp) as finchargement, min(dateheure_rec) as debutreception, max(dateheure_rec) as finreception, timestampdiff(MINUTE,min(dateheure_exp),max(dateheure_exp)) as tempschargement, timestampdiff(MINUTE, min(dateheure_rec), max(dateheure_rec)) as tempsreception, timestampdiff(MINUTE,max(dateheure_exp),min(dateheure_rec)) as attente,timestampdiff(MINUTE,min(dateheure_exp),max(dateheure_rec)) as total from palette join tournee on palette.id_tournee=tournee.id group by id_tournee ORDER BY numtournee DESC");
	include 'header.php';

?>

<div class="container">
	<div class="row">
			<h1>Liste des chargements et receptions</h1>
			<table id="tabledb" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th></th>
						<th class="text-center" colspan="3">Chargement</th>
						<th class="text-center" colspan="3">Reception</th>
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
							<td class="text-right warning col-sm-1"><strong><?php echo $liste->numtournee; ?></strong></td>
							<td class="text-right col-sm-1"><?php echo texte::short_french_date_time($liste->debutchargement); ?></td>
							<td class="text-right col-sm-1"><?php echo texte::short_french_date_time($liste->finchargement); ?></td>
							<td class="text-right success col-sm-1"><?php echo $liste->nbexp; ?></td>
							<?php if (!empty($liste->debutreception)) {
								echo "<td class='text-right col-sm-1'>".texte::short_french_date_time($liste->debutreception)."</td>";
							} else {
								echo "<td class='text-center col-sm-1'>En cours</td>";
							} ?>

							<?php if (!empty($liste->finreception)) {
								echo "<td class='text-right col-sm-1'>".texte::short_french_date_time($liste->finreception)."</td>";
							} else {
								echo "<td class='text-center' col-sm-1>En cours</td>";
							} ?>
							<?php if ($liste->nbrec != $liste->nbexp) :?>
								<td class="text-right danger col-sm-1"><strong><?php echo $liste->nbrec; ?></strong></td>
							<?php else :?>
								<td class="text-right success col-sm-1"><?php echo $liste->nbrec; ?></td>
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
	        			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
	        			<button type="button" class="btn btn-primary" id ="exportpdf" onClick="exportpdf()" data-dismiss="modal">PDF</button>
	        			<button type='button' class='btn btn-primary' id ="exportcsv" onclick="exportcsv()">Exporter</button>
	      			</div>
    			</div>
  			</div>
		</div>

<script>

function exportCSV(id) {
	document.location.href = "exportcsv.php?tournee="+id;
}

function exportPDF(id) {
	document.location.href = "exportpdf.php?tournee="+id;
}

function detailModal(id){
  	$.post ("getTournee.php", {tournee:id} , function(data){
  		$( ".modal-body" ).empty().append( data );
  		$( '#exportcsv').attr("onClick", "exportCSV("+id+")");
  		$( '#exportcsv').attr("onClick", "exportPDF("+id+")");
  	});

  $('.detailModal').modal({
    keyboard: true,
    backdrop: "static"
  });
};

$('.detailModal').on('shown.bs.modal', function () {
    $(this).find('.modal-dialog').css({width:'90%',
                               height:'auto', 
                              'max-height':'100%'});
});

</script>