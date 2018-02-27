<?php
include '../includes.php';

$table     = T_PALETTE;
$DB->table = $table;

	$listes = $DB->tquery("SELECT c.ean, dateheure_exp, dateheure_rec, c.id_tournee, t.numtournee FROM {$table} AS c JOIN ".T_TOURNEE." AS t ON c.id_tournee=t.id ORDER BY dateheure_exp DESC");

    $now = strftime("%d-%m-%y_%Hh%M");
	  header("Content-type: application/csv");
    header('Content-Disposition: attachment; filename=export_full_'.$now.'.csv');

    $handle = fopen('php://output', 'w');
    fputcsv($handle, [
        'Tournée',
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
?>