<?php 
// DIAMIR

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "diamir.php";
$seitentitel = "go and fly - Diamir Reisen";


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
    
    	<div id="diamirReseller">
        <h2>Diamir Reisen direkt vom Veranstalter</h2>
			<iframe width="80%" height="700px" frameborder="0" src="https://www.diamir.de?agnr=35647&whitelabel=1"></iframe>
            </div>

        <p class="clear"></p>
    </div> <!-- #main -->

<?php
// --> FOOTER
include("footer.php");
?>