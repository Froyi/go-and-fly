<?php
// Session starten
session_start();

// header setzen
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

// Datenbank 
include_once("../connect/db.php");
include_once("../inc.php/functions.inc.php");
$seite = "index.php";
$join = "";

$tagListe = explode(",",$_GET["tagListe"]);
/*echo "</br></br>";
var_dump($tagListe);
*/$_SESSION["tagListe"] = $tagListe;	
$join = "";
$c = 0; // Counter, um herauszufinden, ob am Ende eins hinzu kam
for($i=0; $i< sizeof($tagListe); $i++)
{
	
	if($tagListe[$i] == 1)
	{
		if($c == 0)
		{
			$join .= "JOIN reise_tags rt".($i+1)." on rt.reise_id = rt".($i+1).".reise_id ";
			$quer_temp = $quer_temp."  AND r.id = rt.reise_id AND t.id = rt.tags_id AND (rt.tags_id = ".($i+1);
			$c ++;
		}
		else 
		{
			$join .= "JOIN reise_tags rt".($i+1)." on rt.reise_id = rt".($i+1).".reise_id ";
			$quer_temp = $quer_temp." AND rt".($i+1).".tags_id = ".($i+1);
			$c ++;
		}
	}
}
if($c > 0)
{ 
	$quer_temp .= ")";
}

if (empty($join) === true) {
    $quer = "SELECT	DISTINCT r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.bild
									   FROM		reise r, region re, reise_region rere
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id ".$quer_temp;
} else {
    $quer = "SELECT	DISTINCT r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.bild
									   FROM		reise r, region re, reise_region rere,  tags t, reise_tags rt ".$join." 
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id ".$quer_temp;
}

if($_GET["re_id"] > 0)
{
	$quer .= " AND rere.region_id = ".$_GET["re_id"]." ";
}

$sichtbardate = date("Y-m-d");
$quer .= " AND		(r.sichtbar >= '$sichtbardate' OR r.sichtbar = '0000-00-00') ORDER BY	r.eingestellt";
/*echo $quer; exit;*/
$re = mysql_query($quer);
$re2 = mysql_query($quer);

include("../inc.php/main.inc.php"); 

?>