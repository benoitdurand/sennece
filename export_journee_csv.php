<?php
include 'includes.php';

$table     = T_PALETTE;
$DB->table = $table;

if (isset($_GET) && isset($_GET['date'])) {
	$dateExport = $_GET['date'];

    $sql = "SELECT `numtournee` AS tournee, CONCAT('\'',ean) AS support, dateheure_exp AS chargement, dateheure_rec AS reception FROM `palette` JOIN `tournee` ON id_tournee = `tournee`.`id` WHERE DATE(`dateheure_exp`) = '{$dateExport}' ORDER BY numtournee, `ean`";

	$listes = $DB->tquery($sql);

	header("Content-type: application/csv; charset=utf-8");
    header('Content-Disposition: attachment; filename=export_journee_'.$dateExport.'.csv');

    $handle = fopen('php://output', 'w');
    fputcsv($handle, [
        'Tournee',
        'Support',
        'Date Chargement',
        'Date Reception'
      ]);

    foreach($listes as $v){
      fputcsv($handle, [
          $v['tournee'],
          $v['support'],
          $v['chargement'],
          $v['reception']
        ]);
    }

    fclose($handle);exit;

	}
?>