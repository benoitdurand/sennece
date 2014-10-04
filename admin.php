<?php
include 'includes.php';

$table     = T_CAMION;
$DB->table = $table;

// select c.ean, c.codemag, clt.libelle, dateheure from camion as c JOIN client as clt ON RIGHT('00000'+c.codemag,5) = RIGHT('00000'+clt.codecli,5);

// $listes = $DB->query("SELECT * FROM ".T_CAMION." ORDER BY dateheure DESC");
	$listes = $DB->query("SELECT c.ean, c.codemag, clt.libelle, dateheure FROM ".T_CAMION." AS c LEFT JOIN ".T_CLIENT." AS clt ON RIGHT('00000'+c.codemag,5) = RIGHT('00000'+clt.codecli,5) ORDER BY dateheure DESC");

include 'header.php';

?>

<script>
	$(document).ready(function() 
    { 
        $("#tabledb").tablesorter(
        	{
        		dateFormat: 'pt',
        		widgets: ["zebra", "filter","saveSort"],
        		theme: 'blue',
        		widgetOptions : {
        			filter_hideFilters : false,
        			filter_reset : '.reset',
        			filter_saveFilters : false,
        		},
        		headers: {
        			3: {                
                		sorter: false 
            		}
        		}
        	}
        ).tablesorterPager(
        	{
        		container: $("#pager"),
        		output: '{startRow} - {endRow}',
        		page: 0,
        		size: 15,
        		fixedHeight: true,
        	}); 
    });
</script>
<div class="container">
	<div class="row">
	<div class="col-xs-0 col-sm-1 col-md-1 col-lg-0"></div>
		<div class="col-xs-12 col-sm-10 col-md-10 col-lg-12 input">
			<h1>Liste des chargements</h1>
			<table id="tabledb" class="table table-bordered tablesorter">
				<thead>
					<tr>
						<th class="text-center col-lg-2"><strong>EAN Palette</th>
						<th class="text-center col-lg-1"><strong>Code client</strong></th>
						<th class="text-center col-lg-3 filter-select filter-onlyAvail"><strong>Magasin</strong></th>
						<th class="text-center col-lg-1 filter-false"><strong>Expedition</strong></th>

					</tr>
				</thead>
				<tbody>
					<tr>
					<?php foreach ($listes as $liste): ?>
							<td class="text-right col-lg-2"><?php echo $liste->ean; ?></td>
							<td class='text-right col-xs-1'><?php echo $liste->codemag; ?></td>
							<td class='text-left col-xs-3'><?php echo $liste->libelle; ?></td>
							<td class='text-right col-xs-1'><?php echo texte::short_french_date_time($liste->dateheure); ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<div id="pager" class="pager">
				<form>
					<img src="img/first.png" class="first"/>
					<img src="img/prev.png" class="prev"/>
					<span class="pagedisplay"></span>
					<img src="img/next.png" class="next"/>
					<img src="img/last.png" class="last"/>
				</form>
			</div>
		</div>
	<div>


</div>