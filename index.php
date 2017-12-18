<?php 
// INDEX

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "index.php";
$seitentitel = "go and fly - Startseite";


// --> Datenbankdefinition
require_once("connect/db.php");

// --> Datenbankzugriffe
// Abfragen zu Formulareingaben und Definitionen von Inhalten

// --> HEADER
include("header.php");
$re = query_variablen();
$re2 = query_variablen();
?>

    <div id="main">
    	<?php include("inc.php/main.inc.php"); ?>
    </div> <!-- #main -->

<?php
// --> FOOTER
include("footer.php");
?>