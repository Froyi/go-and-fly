<?php
// Session starten
session_start();

// header setzen
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

// Datenbank 
include_once("../connect/db.php");
include_once("../inc.php/functions.inc.php");
?>
<?php
//////////////////////////////////////////////////////////////////
/////	01 - REISE ERSTELLEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["titel"]) && !empty($_POST["titel"]) && (isset($_POST["editorCKE"]) && !empty($_POST["editorCKE"])))
{
	
	// Variablen definieren
	$titel = $_POST["titel"];
	$beschreibung = $_POST["editorCKE"];
	$kurzbeschreibung = $_POST["kurzbeschreibung"];
	$personen = $_POST["personen"];
	$zeit = $_POST["zeit"];
	$flug = $_POST["flug"];
	$sprache = $_POST["sprache"];
	$terrain = $_POST["terrain"];
	$veranstalter = $_POST["veranstalter"];
	$eingestellt = date("Y-m-d");
	if(empty($_POST["sichtbar"]))
	{
		$sichtbar = "0000-00-00";
	}
	else
	{
		$sichtbar = $_POST["sichtbar"];
	}
	
	$eingabe = mysql_query("INSERT INTO	reise (titel, beschreibung, kurzbeschreibung, personen, zeit, flug, sprache, terrain, eingestellt,  sichtbar, veranstalter) VALUES ('$titel','$beschreibung', '$kurzbeschreibung', '$personen', '$zeit', '$flug', '$sprache', '$terrain', '$eingestellt', '$sichtbar', '$veranstalter')");
	
	// Vorbereitung Bild Upload
	if(mysql_insert_id() >= 0)
	{
	$id = mysql_insert_id();
	$pre_path = "../img/reise/";
	
	if(move_uploaded_file($_FILES['vorschauBild']['tmp_name'],$pre_path.$_FILES['vorschauBild']['name']))
	{
		$bildPfad = $_FILES['vorschauBild']['name'];
	
		$eingabeBild = mysql_query("UPDATE reise SET bild = '$bildPfad' WHERE id = '$id'");
	}
	
	
	// Region eintragen
	$region = $_POST["region"];
	foreach($region as $regionId)
	{
		$e = mysql_query("INSERT INTO reise_region (reise_id, region_id) VALUES ('$id','$regionId')");
	}
		header("LOCATION: ../admin.php?did=1&error=false");
	}
	else
	{
		header("LOCATION: ../admin.php?did=1&error=true");
	}
}

//////////////////////////////////////////////////////////////////
/////	02 - REISE BEARBEITEN ODER LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["titel"]) && !empty($_POST["titel"]) && (isset($_POST["editorCKE2"]) && !empty($_POST["editorCKE2"])))
{
	$reise_id = $_POST["reiseBearbeitung"];
	
	if(isset($_POST["delete"]))
	{
		// löschen
		$eingabe = mysql_query("DELETE FROM reise WHERE id = '$reise_id'");
		
		header("Location: ../admin.php?did=12&error=false#bearbeiteReise");
		exit;
	}
	// Reise bearbeiten
	$titel = $_POST["titel"];
	$beschreibung = $_POST["editorCKE2"];
	$kurzbeschreibung = $_POST["kurzbeschreibung"];
	$personen = $_POST["personen"];
	$zeit = $_POST["zeit"];
	$flug = $_POST["flug"];
	$sprache = $_POST["sprache"];
	$terrain = $_POST["terrain"];
	$veranstalter = $_POST["veranstalter"];
	$eingestellt = date("Y-m-d");


	if(empty($_POST["sichtbar"]))
	{
		$sichtbar = "0000-00-00";
	}
	else
	{
		$sichtbar = $_POST["sichtbar"];
	}


	$eingabe = mysql_query("UPDATE reise SET titel = '$titel', beschreibung = '$beschreibung', kurzbeschreibung = '$kurzbeschreibung' , personen = '$personen' , zeit = '$zeit' , flug = '$flug' , sprache = '$sprache' , terrain = '$terrain', eingestellt = '$eingestellt', sichtbar = '$sichtbar' , veranstalter = '$veranstalter' WHERE id = '$reise_id'");
    echo "UPDATE reise SET titel = '$titel', beschreibung = '$beschreibung', kurzbeschreibung = '$kurzbeschreibung' , personen = '$personen' , zeit = '$zeit' , flug = '$flug' , sprache = '$sprache' , terrain = '$terrain', eingestellt = '$eingestellt', sichtbar = '$sichtbar' , veranstalter = '$veranstalter' WHERE id = '$reise_id'";
    exit;
	$pre_path = "../img/reise/";
	$pre_path_karte = "../img/reise/karte/";
	// hier muss nun noch das Bild geändert werden

	if(move_uploaded_file($_FILES['vorschauBild']['tmp_name'],$pre_path.$_FILES['vorschauBild']['name']))
	{
		$bildPfad = $_FILES['vorschauBild']['name'];

		$eingabeBild = mysql_query("UPDATE reise SET bild = '$bildPfad' WHERE id = '$reise_id'");
	}
	if(move_uploaded_file($_FILES['kartenBild']['tmp_name'],$pre_path_karte.$_FILES['kartenBild']['name']))
	{
		$kartenBildPfad = $_FILES['kartenBild']['name'];
		
		$eingabekartenBild = mysql_query("UPDATE reise SET karte = '$kartenBildPfad' WHERE id = '$reise_id'");
	}
	
	if(move_uploaded_file($_FILES['teaserBild']['tmp_name'],$pre_path.$_FILES['teaserBild']['name']))
	{
		$teaserBildPfad = $_FILES['teaserBild']['name'];
		
		$eingabekartenBild = mysql_query("UPDATE reise SET teaser = '$teaserBildPfad' WHERE id = '$reise_id'");
	}
	// Region eintragen
	
		// erst alle löschen
		$deleteRegionen = mysql_query("DELETE FROM reise_region WHERE reise_id = '$reise_id'");
		$region = $_POST["region"];
	
		foreach($region as $regionId)
		{
			$e = mysql_query("INSERT INTO reise_region (reise_id, region_id) VALUES ('$reise_id','$regionId')");
		}
	header("Location: ../admin.php?did=2&error=false&reiseAuswahl=".$reise_id."#bearbeiteReise");
}

//////////////////////////////////////////////////////////////////
/////	02 1 - FRAGEN & ANTWORTEN ERSTELLEN
//////////////////////////////////////////////////////////////////

if(isset($_POST["frage"]) && !empty($_POST["frage"]) && isset($_POST["modus"]) && $_POST["modus"] == "fragenErstellen")
{
	// Variablen holen
	$frage = $_POST["frage"];
	$antwort = $_POST["antwort"];
	$reiseId = $_POST["reiseId"];
	
	$erstelleFragenReise = mysql_query("INSERT INTO	fragen (reise_id, frage, antwort) VALUES ('$reiseId','$frage','$antwort')");
	
	$fragenId = mysql_insert_id();
	
	header("Location: ../admin.php?did=3&error=false&reiseAuswahl=".$reiseId."#bearbeiteFragen");
}

//////////////////////////////////////////////////////////////////
/////	02 2 - FRAGEN & ANTWORTEN BEARBEITEN ODER LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["modus"]) && $_POST["modus"] == "fragenBearbeiten")
{
	$frage = $_POST["frage"];
	$antwort = $_POST["antwort"];
	$frageId = $_POST["frageId"];
	$reiseId = $_POST["reiseId"];
	
	if(isset($_POST["frageLoeschen"]))
	{
		$eingabe = mysql_query("DELETE FROM	fragen WHERE id = '$frageId'");
		header("Location: ../admin.php?did=12s&error=false&reiseAuswahl=".$reiseId."#bearbeiteFragen");
		exit;
	}
	
	$bearbeiteFragenReise = mysql_query("UPDATE	fragen SET frage = '$frage', antwort = '$antwort' WHERE id = '$frageId'");	
	
	header("Location: ../admin.php?did=4&error=false&reiseAuswahl=".$reiseId."&fragenListe=".$fragenId."#bearbeiteFragen");
}

//////////////////////////////////////////////////////////////////
/////	03 - LEISTUNGEN ERSTELLEN, BEARBEITEN & LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["editorCKE3"]) && !empty($_POST["editorCKE3"]) && isset($_POST["reiseId"]) && !empty($_POST["reiseId"]))
{
	// Variablen
	$leistung = $_POST["editorCKE3"];	
	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	
	$e = mysql_query("SELECT * FROM	leistungen WHERE reise_id = '$reiseId'");
	/*echo "SELECT * FROM	leistungen WHERE reise_id = 'reiseId'";exit;*/
	if(mysql_num_rows($e) != "0")
	{
		// es gibt noch kein Eintrag
		$eingabe = mysql_query("UPDATE leistungen SET text = '$leistung' WHERE reise_id = '$reiseId'");
	
		header("Location: ../admin.php?did=13&error=false&reiseAuswahl=".$reiseId."#erstelleLeistungen");	
	}
	else
	{
		$eingabe = mysql_query("INSERT INTO leistungen (reise_id,text) VALUES ('$reiseId','$leistung')");
	
		header("Location: ../admin.php?did=5&error=false&reiseAuswahl=".$reiseId."#erstelleLeistungen");
	}
}

//////////////////////////////////////////////////////////////////
/////	04 - REISEVERLAUF ERSTELLEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["titel"]) && !empty($_POST["titel"]) && isset($_POST["reiseVerlauf"]) && !empty($_POST["reiseVerlauf"]))
{
	// Variablen
	$titel = $_POST["titel"];	
	$beschreibung = $_POST["beschreibung"];
	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	
	$eingabe = mysql_query("INSERT INTO reiseverlauf (reise_id,titel,beschreibung) VALUES ('$reiseId','$titel','$beschreibung')");
	
	header("Location: ../admin.php?did=6&error=false&reiseAuswahl=".$reiseId."#erstelleReiseverlauf");
}

//////////////////////////////////////////////////////////////////
/////	04 01- REISEVERLAUF BEARBEITEN & LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["reiseVerlaufBearbeiten"]))
{
	// Variablen
	$titel = $_POST["leistungTitel"];
	$beschreibung = $_POST["leistungBeschreibung"];
	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	$verlaufId = $_POST["verlaufId"];
	
	if(isset($_POST["loescheVerlauf"]))
	{
		// Verlauf löschen
		$eingabe = mysql_query("DELETE FROM reiseverlauf WHERE id = '$verlaufId'");
		header("Location: ../admin.php?did=14&error=false&reiseAuswahl=".$reiseId."#bearbeiteReiseverlauf");
	}
	else
	{
		// Verlauf bearbeiten
		$eingabe = mysql_query("UPDATE reiseverlauf SET titel = '$titel' , beschreibung = '$beschreibung' WHERE id = '$verlaufId'");
		header("Location: ../admin.php?did=15&error=false&reiseAuswahl=".$reiseId."&verlaufListe=".$verlaufId."#bearbeiteReiseverlauf");
	}
}
//////////////////////////////////////////////////////////////////
/////	05 - REISETERMINE ERSTELLEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["erstelleTermine"]) && !empty($_POST["erstelleTermine"]))
{
	// Variablen
	$start = $_POST["start"];	
	$ende = $_POST["ende"];
	$preis = $_POST["preis"];	

	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	
	$eingabe = mysql_query("INSERT INTO termine (reise_id,start,ende,preis) VALUES ('$reiseId','$start','$ende','$preis')");
	
	header("Location: ../admin.php?did=7&error=false&reiseAuswahl=".$reiseId."#erstelleTermine");
}

//////////////////////////////////////////////////////////////////
/////	05 01- REISETERMIN BEARBEITEN & LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["reiseTerminBearbeiten"]))
{
	// Variablen
	$start = $_POST["start"];
	$ende = $_POST["ende"];
	$preis = $_POST["preis"];
	
	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	$terminId = $_POST["terminId"];
	
	if(isset($_POST["loescheTermin"]))
	{
		// Verlauf löschen
		$eingabe = mysql_query("DELETE FROM termine WHERE id = '$terminId'");
		header("Location: ../admin.php?did=16&error=false&reiseAuswahl=".$reiseId."#bearbeiteReisetermine");
	}
	else
	{
		// Verlauf bearbeiten
		$eingabe = mysql_query("UPDATE termine SET start = '$start' , ende = '$ende', preis = '$preis' WHERE id = '$terminId'");
		header("Location: ../admin.php?did=17&error=false&reiseAuswahl=".$reiseId."&termineListe=".$terminId."#bearbeiteReisetermine");
	}
}
//////////////////////////////////////////////////////////////////
/////	06 - REISETAGS ERSTELLEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["erstelleTags"]) && !empty($_POST["erstelleTags"]))
{
	// Variablen
	$tags = $_POST["tagAuswahl"];		

	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	
	$ei = mysql_query("DELETE FROM reise_tags WHERE reise_id = '$reiseId'");
	
	foreach($tags as $tagsValue)
	{
		$eingabe = mysql_query("INSERT INTO reise_tags (reise_id,tags_id) VALUES ('$reiseId','$tagsValue')");
	}
	header("Location: ../admin.php?did=8&error=false&reiseAuswahl=".$reiseId."#erstelleTags");
}

//////////////////////////////////////////////////////////////////
/////	07 - NEUIGKEITEN ERSTELLEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["erstelleNeuigkeit"]) && !empty($_POST["erstelleNeuigkeit"]))
{
	// Variablen
	$titel = $_POST["titel"];	
	$text = $_POST["neuigkeitentext"];	

	$seite = "../admin.php";
	$reiseId = $_POST["reiseId"];
	$date = $_POST["date"];
	
	$eingabe = mysql_query("INSERT INTO neuigkeiten (titel,datum,text) VALUES ('$titel','$date','$text')");
	
	header("Location: ../admin.php?did=9&error=false#erstelleNeuigkeitenContainer");
}

//////////////////////////////////////////////////////////////////
/////	08 - NEUIGKEITEN BEARBEITEN ODER LÖSCHEN
//////////////////////////////////////////////////////////////////
if(isset($_POST["bearbeiteNeuigkeit"]) && !empty($_POST["bearbeiteNeuigkeit"]))
{
	// Variablen 
	$titel = $_POST["titel"];	
	$text = $_POST["neuigkeitBeschreibung"];	

	$seite = "../admin.php";
	$id = $_POST["neuigkeitenId"];
	$date = $_POST["date"];
	if(isset($_POST["loeschenNeuigkeit"]))
	{
		// löschen
		$eingabe = mysql_query("DELETE FROM neuigkeiten WHERE id = '$id'");
		header("Location: ../admin.php?did=10&error=false#bearbeiteNeuigkeitDetail");
	}
	else
	{
		$eingabe = mysql_query("UPDATE neuigkeiten SET titel = '$titel', datum = '$date' , text = '$text' WHERE id = '$id'");
		header("Location: ../admin.php?did=11&error=false#bearbeiteNeuigkeitDetail");
	}
}
?>