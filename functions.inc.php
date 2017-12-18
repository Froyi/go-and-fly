<?php
// Funktionen für die Webseite 
?>
<?php
// VARIABLEN
$kurzLimit = 350; // Limit an Zeichen für die Kurzbeschreibung
?>
<?php

// GET Variablen holen
function query_variablen()
{
	if(isset($_GET["konti_id"])){
		// Kontinent angeklickt --> Reisen aus der DB holen
		$result = holeKontinente($_GET["konti_id"]); // Zwischenspeicher
		return $re = holeReiseAusKontinenten($result["id"]); 
	}
	else if(isset($_GET["re_id"])){
		$result = holeRegion($_GET["re_id"]);  // Zwischenspeicher 
		return $re = holeReiseAusRegion($result["id"]);
	}
	else
	{
		return $re = holeReiseAusRegion();
	}
}

function query_reise()
{
	if(isset($_GET["re_id"]))
	{
		// es gibt eine Reise
		return $re = holeReise($_GET["re_id"]);
	}
	else
	{
		return false;	
	}
}

// KONTINENTE HOLEN
function holeKontinente($id = "alle")
{
	if($id == "alle")
	{
		// alle Kontinente holen
		//  --> header.php (Smartphone)
		
		return $eingabe = mysql_query("SELECT	*
									   FROM		kontinente
									   ORDER BY	id ASC");	
	}
	else
	{
		// einen Kontinent holen
		// --> index.php (TEST)
		return $eingabe = mysql_fetch_assoc(mysql_query("SELECT	*
									   					 FROM	kontinente
									   					 WHERE	id = '$id'"));
	}
		
}

// REGIONEN EINES KONTINENTEN HOLEN
function holeRegionen($id = "alle")
{
	if($id == "alle")
	{
		// alle Regionen holen
		// 
		
		return $eingabe = mysql_query("SELECT	*
									   FROM		region
									   ORDER BY	id ASC");	
	}
	else
	{
		// bestimmte Regionen eines Kontinenten holen
		// --> header.php (Smartphone)
		
		return $eingabe = mysql_query("SELECT	*
									   FROM		region
									   WHERE	kontinente_id = '$id'");
	}		
}

// REGIONEN EINER REISE HOLEN
function holeRegionAusReise($reise_id)
{
	return $eingabe = mysql_query("SELECT	*
								   FROM		reise_region rr, region r
								   WHERE	rr.region_id = r.id
								   AND		rr.reise_id = '$reise_id'");	
}
function holeRegionsIds($reise_id)
{
	$ids = array();
	
	$eingabe = mysql_query("SELECT	r.id
								   FROM		reise_region rr, region r
								   WHERE	rr.region_id = r.id
								   AND		rr.reise_id = '$reise_id'");
	$count = 0;
	while($a = mysql_fetch_assoc($eingabe))
	{
		$ids[$count] = $a["id"];
		$count++;
	}
	return $ids;	
}
// EINE REGION HOLEN
function holeRegion($id)
{
		// bestimmte Region holen
		// --> index.php (TEST)
		
		return $eingabe = mysql_fetch_assoc(mysql_query("SELECT	*
									   					 FROM	region
									   					 WHERE	id = '$id'"));	
}

// REISE AUS REGIONS ID HOLEN
function holeReiseAusRegion($id="alle")
{
	$sichtbardate = date("Y-m-d");
	if($id == "alle")
	{
		// alle Reisen holen, die es in der Datenbank gibt
		$quer = "SELECT DISTINCT	r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.sichtbar, r.bild, r.teaser
									   FROM		reise r, region re, reise_region rere, reise_tags rt, tags t
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id
									   AND		r.kurzbeschreibung != ''
									   AND		r.beschreibung != ''
									   AND		r.titel != ''
									   AND		r.personen != ''
									   AND		r.zeit != ''
									   AND		r.flug != ''
									   AND		r.sprache != ''
									   AND		r.terrain != ''
									   AND		r.teaser != ''
									   AND		(r.sichtbar >= '$sichtbardate' OR r.sichtbar = '0000-00-00')
									   ";
		if(isset($_SESSION["tagListe"]) && !empty($_SESSION["tagListe"]))
		{
			$tagListe = $_SESSION["tagListe"];
			/*var_dump($tagListe);*/
			$c = 0; // Counter, um herauszufinden, ob am Ende eins hinzu kam
			for($i=0; $i< sizeof($tagListe); $i++)
			{
				
				if($tagListe[$i] == 1 && $c == 0)
				{
					$quer = $quer."  AND r.id = rt.reise_id AND t.id = rt.tags_id AND (rt.tags_id = ".($i+1);
					$c ++;
				}
				else if ($tagListe[$i] == 1)
				{
					$quer = $quer." AND rt.tags_id = ".($i+1);
					$c ++;
				}
			}
			if($c > 0)
			{ 
				$quer .= ")";
			}
		}
		$quer .= " ORDER BY	r.eingestellt DESC, r.id DESC";
		return $eingabe = mysql_query($quer);
	}
	else
	{
		// bestimmte Reisen aus Region holen
		$quer = "SELECT DISTINCT	r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.sichtbar, r.bild, r.teaser
									   FROM		reise r, region re, reise_region rere,  reise_tags rt, tags t
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id
									   AND		re.id = '$id'
									   AND		r.kurzbeschreibung != ''
									   AND		r.beschreibung != ''
									   AND		r.titel != ''
									   AND		r.personen != ''
									   AND		r.zeit != ''
									   AND		r.flug != ''
									   AND		r.sprache != ''
									   AND		r.terrain != ''
									   AND		r.teaser != ''
									   AND		(r.sichtbar >= '$sichtbardate' OR r.sichtbar = '0000-00-00')";
		if(isset($_SESSION["tagListe"]) && !empty($_SESSION["tagListe"]))
		{
			$tagListe = $_SESSION["tagListe"];
			/*var_dump($tagListe);*/
			$c = 0; // Counter, um herauszufinden, ob am Ende eins hinzu kam
			for($i=0; $i< sizeof($tagListe); $i++)
			{
				
				if($tagListe[$i] == 1 && $c == 0)
				{
					$quer = $quer."  AND r.id = rt.reise_id AND t.id = rt.tags_id AND (rt.tags_id = ".($i+1);
					$c ++;
				}
				else if ($tagListe[$i] == 1)
				{
					$quer = $quer." AND rt.tags_id = ".($i+1);
					$c ++;
				}
			}
			if($c > 0)
			{ 
				$quer .= ")";
			}
		}
		$quer .= " ORDER BY	r.eingestellt";
		/*echo $quer; exit;*/
		return $eingabe = mysql_query($quer);
	}			
}

function holeReiseAusRegion2($id="alle")
{
	$sichtbardate = date("Y-m-d");
	if($id == "alle")
	{
		// alle Reisen holen, die es in der Datenbank gibt
		$quer = "SELECT DISTINCT	r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.sichtbar, r.bild, r.teaser, r.veranstalter
									   FROM		reise r, region re, reise_region rere, reise_tags rt, tags t
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id
									   AND		r.kurzbeschreibung != ''
									   AND		r.beschreibung != ''
									   AND		r.titel != ''
									   
									   ";
		if(isset($_SESSION["tagListe"]) && !empty($_SESSION["tagListe"]))
		{
			$tagListe = $_SESSION["tagListe"];
			/*var_dump($tagListe);*/
			$c = 0; // Counter, um herauszufinden, ob am Ende eins hinzu kam
			for($i=0; $i< sizeof($tagListe); $i++)
			{
				
				if($tagListe[$i] == 1 && $c == 0)
				{
					$quer = $quer."  AND r.id = rt.reise_id AND t.id = rt.tags_id AND (rt.tags_id = ".($i+1);
					$c ++;
				}
				else if ($tagListe[$i] == 1)
				{
					$quer = $quer." AND rt.tags_id = ".($i+1);
					$c ++;
				}
			}
			if($c > 0)
			{ 
				$quer .= ")";
			}
		}
		$quer .= " ORDER BY	r.eingestellt DESC, r.id DESC";
		return $eingabe = mysql_query($quer);
	}
	else
	{
		// bestimmte Reisen aus Region holen
		$quer = "SELECT DISTINCT	r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id, r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt, r.sichtbar, r.bild, r.teaser, r.veranstalter
									   FROM		reise r, region re, reise_region rere,  reise_tags rt, tags t
									   WHERE	r.id = rere.reise_id
									   AND		re.id = rere.region_id
									   AND		re.id = '$id'
									   AND		r.kurzbeschreibung != ''
									   AND		r.beschreibung != ''
									   AND		r.titel != ''
									  ";
		
		$quer .= " ORDER BY	r.eingestellt";
		return $eingabe = mysql_query($quer);
	}			
}

// REISE AUS KONTINENTEN ID HOLEN
function holeReiseAusKontinenten($id)
{
	$sichtbardate = date("Y-m-d");
	// alle Reisen eines Kontinentes holen
	return $eingabe = mysql_query("SELECT DISTINCT	r.kurzbeschreibung, r.beschreibung, r.titel, r.personen, r.id r.zeit, r.flug, r.sprache, r.terrain, r.karte, r.eingestellt r.sichtbar, r.bild
								   FROM		reise r, region re, reise_region rere
								   WHERE	r.id = rere.reise_id
								   AND		re.id = rere.region_id
								   AND		b.reise_id = r.id
								   AND		re.kontinente_id = '$id'
								   AND		(r.sichtbar >= '$sichtbardate OR r.sichtbar = '0000-00-00')
								   ORDER BY	r.eingestellt");
}


//////////////////////////////////////////////////////////////////////////////////////////////////
// SLIDER
//////////////////////////////////////////////////////////////////////////////////////////////////

// ANZAHL DER REISEN IM TEASER
function anzahlTeaserReisen()
{
	// alle Reisen des Teasers für die randomisierte Ausgabe
	
	// maximale Anzahl aus der DB holen
	$count = mysql_fetch_assoc(mysql_query("SELECT	count(*) as 'anzahl'
											FROM	teaser
											WHERE	teaser.aktiv = '1'"));
	return $a = rand(1,$count["anzahl"]);
	
}

// AUSGABE DER AUSGEWÄHLTEN REISE
function reiseRandomTeaser($reise)
{
	// die ausgewählte randomisierte Reise wird ausgegeben
	$reise--; // Anpassung an die id in der Datenbank
	
	return mysql_fetch_assoc(mysql_query("SELECT	*
										  FROM		teaser t, reise r
										  WHERE		t.reise_id = r.id
										  AND		t.aktiv = '1'
										  LIMIT		$reise,1"));	
}


//////////////////////////////////////////////////////////////////////////////////////////////////
// TAG LISTEN
//////////////////////////////////////////////////////////////////////////////////////////////////

// TAGS AUSGEBEN
function holeTag($id="alle")
{
	if($id == "alle")
	{
		// alle Tags holen, die es in der Datenbank gibt
		return $eingabe = mysql_query("SELECT	*
									   FROM		tags");
	}
	else
	{
		// bestimmte Tag aus DB holen
		return $eingabe = mysql_query("SELECT	*
									   FROM 	tags
									   WHERE	id = '$id'");
	}			
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// REISE
//////////////////////////////////////////////////////////////////////////////////////////////////

function holeReiseSuche($id="alles")
{
	if($id == "alles")
	{
		// alle Reisen anzeigen
		return $eingabe = mysql_query("SELECT	*
									   FROM		reise r	
									   ORDER BY r.eingestellt DESC");	
	}
	else
	{
	$eingabe = mysql_query("SELECT 	*
							FROM	reise r
							WHERE 	r.id = '$id'
							");
	return mysql_fetch_assoc($eingabe);	
	}
}
function holeReise($id="alles")
{
	if($id == "alles")
	{
		// alle Reisen anzeigen
		return $eingabe = mysql_query("SELECT	*
									   FROM		reise r	
									   ORDER BY r.eingestellt DESC");	
	}
	else
	{
	$eingabe = mysql_query("SELECT 	*
							FROM	reise r
							WHERE 	r.id = '$id'
							");
	return mysql_fetch_assoc($eingabe);	
	}
}
function holeKarte($reise_id)
{
	// hole die Karte der angegebenen Reise
	$eingabe = mysql_query("SELECT	karte
							FROM	reise
							WHERE	id = '$reise_id'");
	$ausgabe = mysql_fetch_assoc($eingabe);	
	return $ausgabe["karte"];
}
function holeReiseverlauf($re_id, $ver_id = "alles")
{
	if($ver_id == "alles")
	{
	return $eingabe = mysql_query("SELECT	*
								   FROM		reiseverlauf
								   WHERE	reise_id = '$re_id'
								  ");	
	}
	else
	{
		$eingabe = mysql_query("SELECT	*
								   FROM		reiseverlauf
								   WHERE	reise_id = '$re_id'
								   AND		id = '$ver_id'
								  ");	
								  return $a = mysql_fetch_assoc($eingabe);
	}
}
function holeTermine($re_id, $ter_id = "alles")
{
	if($ter_id == "alles")
	{
	return $eingabe = mysql_query("SELECT	*
								   FROM		termine
								   WHERE	reise_id = '$re_id'");	
	}
	else
	{
		$eingabe = mysql_query("SELECT	*
								   FROM		termine
								   WHERE	reise_id = '$re_id'
								   AND		id = '$ter_id'
								  ");	
		return $a = mysql_fetch_assoc($eingabe);
	}
}
function holeReiseleistungen($re_id)
{
		$eingabe = mysql_query("SELECT	*
								   FROM		leistungen
								   WHERE	reise_id = '$re_id'");
		return $ausgabe = mysql_fetch_assoc($eingabe);						   	
}
function holeReisefragen($re_id, $fragenId = "alles")
{
	if($fragenId == "alles")
	{

		return $eingabe = mysql_query("SELECT	*
								   	   FROM		fragen
								       WHERE	reise_id = '$re_id'");	
	}
	else
	{
	
		 $eingabe = mysql_query("SELECT	*
								   	   FROM		fragen
								       WHERE	id = '$fragenId'");
		return $ausgabe = mysql_fetch_assoc($eingabe);
	}
}
function tagReise($reId)
{
	// Tags aus Reise
	return $eingabe = mysql_query("SELECT tags_id  FROM reise_tags WHERE reise_id = '$reId'");
}
//////////////////////////////////////////////////////////////////////////////////////////////////
// SIDEBAR
//////////////////////////////////////////////////////////////////////////////////////////////////
function holeNeuigkeiten($id = "alles")
{
	if($id == "alles")
	{
		return $eingabe = mysql_query("SELECT	*
									   FROM		neuigkeiten
									   ORDER BY datum DESC
									   LIMIT 0,10");	
	}
	else
	{
		$eingabe = mysql_query("SELECT	*
							    FROM	neuigkeiten
								WHERE	id = '$id'");
		return $ausgabe = mysql_fetch_assoc($eingabe);
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// SNIPPETS
//////////////////////////////////////////////////////////////////////////////////////////////////

// KÜRZEN EINES TEXTES
function kuerzen($text,$limit)
{
	// Vorgegebener Text wird auf Zeichen des $limit gekürzt	
	return $text = substr($text, 0, $limit)." ...";	
}

function dbDatumAusgabe($datum)
{
	$datum = explode("-",$datum);
	return $d = $datum[2].".".$datum[1].".".$datum[0];
}

// EINGELOGGT?
function loggedIn()
{
	if(isset($_SESSION["user_login"]) && !empty($_SESSION["user_login"]))
	{return true;}else{return false;}
}