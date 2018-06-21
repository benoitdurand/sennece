<?php
include '../includes.php';
include_once '../classes/db.php';

$database = trim(strtolower($_GET['database']));
if (in_array($database, ['tournee'])) {
    switch ($database) {
        case 'tournee' :
            $db = new db();
            $listes = $db->getTourneeID();
        break;
        default :
            //  $listes = [{"id":"","libelle":"vide"}];
        break;
    }
}
echo json_encode($listes);
