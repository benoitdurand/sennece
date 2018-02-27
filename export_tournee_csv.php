<?php

function dateDiff($date1, $date2){
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();

    $tmp = $diff;
    $retour['second'] = str_pad($tmp % 60,2,'0',STR_PAD_LEFT);

    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = str_pad($tmp % 60,2,'0',STR_PAD_LEFT);

    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = str_pad($tmp % 24,2,'0',STR_PAD_LEFT);

    return $retour;
}

	include 'includes.php';

	$table     = T_PALETTE;
	$DB->table = $table;

	if (isset($_GET) && (isset($_GET['date']))) {
		$range  = $_GET['date'];

			$sql = "SELECT id_tournee, numtournee, count(id_tournee) as nbexp, sum(receive) as nbrec, min(dateheure_exp) as debutchargement, max(dateheure_exp) as finchargement, min(dateheure_rec) as debutreception, max(dateheure_rec) as finreception
						from palette join tournee on palette.id_tournee=tournee.id WHERE date(dateheure_exp) = '$range' group by id_tournee ORDER BY numtournee";

			$listes = $DB->query($sql);


	header("Content-type: application/csv; charset=utf-8");
    header('Content-Disposition: attachment; filename=export_tournee_'.$range.'.csv');

    $jours = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
    $handle = fopen('php://output', 'w');
    fputcsv($handle, [
    	'Jour',
        'Tournee',
        'Date Chgt Debut',
        'Heure Chgt Debut',
        'Date Chgt Fin',
        'Heure Chgt Fin',
        'Duree Chgt',
        'Nb',
        'Date Recep. Debut',
        'Heure Recep. Debut',
        'Date Recep. Fin',
        'Heure Recep. Fin',
        'Duree Recep',
        'Nb',
        'Interval',
        'Duree totale',
        'Ecart',
        'Qte'
      ]);

    foreach($listes as $v){
    	$numJour = date('w', strtotime($range));
    	$jourLong = $jours[$numJour];
    	$tourn = $v->numtournee;
    	$tourn .= "";
    	$diff1 = dateDiff(strtotime($v->finchargement), strtotime($v->debutchargement));
    	$diff2 = dateDiff(strtotime($v->finreception), strtotime($v->debutreception));
    	$diff3 = dateDiff(strtotime($v->debutreception), strtotime($v->finchargement));
    	$diff4 = dateDiff(strtotime($v->finreception), strtotime($v->debutchargement));
    	$diff5 = intval($v->nbexp) - intval($v->nbrec);
    	if (intval($diff5) > 0) {
          	$txt = "X Supports non receptionnes";
          } else {
          	$txt = "OK";
          }
      fputcsv($handle, [
      	  $jourLong,
          $tourn,
          texte::extract_date($v->debutchargement),
          texte::extract_time($v->debutchargement),
          texte::extract_date($v->finchargement),
          texte::extract_time($v->finchargement),
          $diff1['hour'].':'.$diff1['minute'].':'.$diff1['second'],
          $v->nbexp,
          texte::extract_date($v->debutreception),
          texte::extract_time($v->debutreception),
          texte::extract_date($v->finreception),
          texte::extract_time($v->finreception),
          $diff2['hour'].':'.$diff2['minute'].':'.$diff2['second'],
          $v->nbrec,
          $diff3['hour'].':'.$diff3['minute'].':'.$diff3['second'],
          $diff4['hour'].':'.$diff4['minute'].':'.$diff4['second'],
          $txt,
          $diff5
        ]);
    }

    fclose($handle);exit;

	}

?>