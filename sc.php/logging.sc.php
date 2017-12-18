<?php
// Session starten
session_start();

// header setzen
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

// Datenbank 
include_once("../connect/db.php");
include_once("../inc.php/functions.inc.php");

// Variablen definieren
$seite = "admin.php";
$email = $_POST["email"];
$pw = $_POST["pw"];

if(!isset($email) || empty($email))
{
	// emailaddy ist leer
	header("Location: ../login.php?error=1");
	exit;
}
else
{
		// Passwort verschlüsseln
		$pw = md5($pw);
		
		// in der Datenbank nach dem User schauen
		$eingabe = mysql_query("SELECT	*
								FROM	user
								WHERE	email = '$email'
								AND		pw = '$pw'");
		$anz = mysql_num_rows($eingabe);
		if($anz > 0)
		{
			$_SESSION["user_login"] = $email;
			header("Location: ../".$seite);
		}
		else
		{
			header("Location: ../login.php?error=2");
		}
		exit;		
}
?>