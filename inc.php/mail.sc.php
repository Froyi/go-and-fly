<?php
// Leistung abschicken
session_start();

header("Content-Type: text/html; charset=utf-8");
include("../connect/db.php");

if(isset($_POST["kontaktForm"]))
{
	// Variablen holen
	$anrede = $_POST["anrede"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["name"];
	$email = $_POST["email"];
	$telefon = $_POST["telefon"];
	$plz = $_POST["plz"];
	$ort = $_POST["ort"];
	$adresse = $_POST["adresse"];
	$frage = $_POST["frage"];
	$seite = "../kontakt.php";
	
	$to = "go.and.fly@t-online.de";
	$message = 	$anrede." ".$vorname." ".$nachname."\r\n".
				$email."\r\n".
				$telefon."\r\n".
				$adresse."\r\n".
				$plz." ".$ort."\r\n".
				"\r\n".
				"Frage: \r\n".$frage;
	
	$header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
			'Reply-To: Kontakt <'.$mail.'>' . "\r\n" .
			"Content-Type: text/plain; charset=utf-8"); 
	
	$subject = "Kontaktformular - www.go-and-fly.de";
	
	mail($to, $subject, $message, $header);
	
	header("LOCATION: ".$seite."?mailsend=true");
	exit;	
}

if(isset($_POST["adresse"]))
{
	// Variablen holen
	$anrede = $_POST["anrede"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["name"];
	$email = $_POST["email"];
	$telefon = $_POST["telefon"];
	$adresse = $_POST["adresse"];
	$plz = $_POST["plz"];
	$ort = $_POST["ort"];
	$termin = $_POST["termin"];
	$anmerkung = $_POST["anmerkung"];
	$seite = $_POST["seite"];
	$titel = $_POST["titel"];
	
	$to = "go.and.fly@t-online.de";
	
	$message = 	$titel."\r\n".
				$anrede." ".$vorname." ".$nachname."\r\n".
				$email."\r\n".
				$telefon."\r\n".
				$adresse."\r\n".
				$plz." ".$ort."\r\n".
				"\r\n".
				"Termin: ".$termin."\r\n".
				"Anmerkungen: ".$anmerkung;
	
	
	$header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
			'Reply-To: Kontakt <'.$mail.'>' . "\r\n" .
			"Content-Type: text/plain; charset=utf-8"); 
	$subject = "Kontaktformular - www.go-and-fly.de";
	
	mail($to, $subject, $message, $header);
	
	header("LOCATION: ".$seite."&mailsend=true");
	exit;	
}
// Mail aus Kontakt versenden
$seite = "../index.php?sendmail=true#footer";

$name = $_POST['name'];
$mail = $_POST['email'];
$nachricht = $_POST['nachricht'];

if (strlen(trim($nachricht)) > 5) {

    $to = "go.and.fly@t-online.de";

    $message = $name." schrieb: \r\n".$nachricht;

    $header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
        'Reply-To: Kontakt <'.$mail.'>' . "\r\n" .
        "Content-Type: text/plain; charset=utf-8");
    $subject = "Kontaktformular - www.go-and-fly.de";

    mail($to, $subject, $message, $header);
}

header("Location: ".$seite);
?>