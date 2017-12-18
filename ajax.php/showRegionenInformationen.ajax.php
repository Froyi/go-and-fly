<?php
// Session starten
session_start();

// header setzen
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

// Datenbank 
include_once("../connect/db.php");
include_once("../inc.php/functions.inc.php");

$regionenId = $_GET["regionenId"];

// Regionen zu dem Kontinent holen
$reg = holeRegion($regionenId);
?>
<p><?php echo utf8_encode($reg["beschreibung"]); ?></p>
