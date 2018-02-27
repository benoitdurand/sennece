<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

if (isset($_GET) && isset($_GET['tournee'])) {
	$tournee = $_GET['tournee'];

	$listes = $DB->tquery("SELECT ean, id_tournee, numtournee, dateheure_exp, dateheure_rec from palette join tournee on tournee.id=id_tournee WHERE id_tournee={$tournee}");


	header("Content-type: application/csv; charset=utf-8");
    header('Content-Disposition: attachment; filename=export_tournee_'.$listes[0]['numtournee'].'.csv');

    $handle = fopen('php://output', 'w');
    fputcsv($handle, [
        'Tournee',
        'Ean Palette',
        'Date Chargement',
        'Date Reception'
      ]);

    foreach($listes as $v){
      fputcsv($handle, [
          $v['numtournee'],
          $v['ean'],
          $v['dateheure_exp'],
          $v['dateheure_rec']
        ]);
    }

    fclose($handle);exit;

	}
?>