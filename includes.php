<?php 
session_start();

require 'config.inc.php';
require 'classes/db.php';
require 'classes/texte.php';
require 'classes/user.php';

setlocale (LC_TIME, 'fr_FR','fra'); 
setlocale(LC_CTYPE, 'fr_FR.UTF8');
setlocale (LC_ALL, 'fr_FR.utf8');
date_default_timezone_set('Europe/Paris');
mb_internal_encoding("UTF-8");

$DB = new DB();
