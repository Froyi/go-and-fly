<?php 
// LOGIN

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "login.php";
$seitentitel = "go and fly - Login";

// --> Datenbankdefinition
require_once("connect/db.php");

// --> Datenbankzugriffe
// Abfragen zu Formulareingaben und Definitionen von Inhalten

// --> HEADER
include("header.php");
$re = query_variablen();
?>

    <div id="main">
    	<div id="login">
            <form action="sc.php/logging.sc.php" method="post" name="loginForm">
            	<p>E-Mail:<br/><input type="email" name="email" placeholder="E-Mail Adresse" /></p>
                <p>Passwort:<br/><input type="password" name="pw" placeholder="Passwort eingeben" /></p>
                <p><input type="submit" name="submit" value="Login" /></p>
            
            <?php
			if(isset($_GET["error"]) && $_GET["error"] == 1)
			{
				echo "<p>Sie haben leider keine E-Mailadresse eingegeben. Bitte versuchen Sie es erneut.</p>";
			}
			else if(isset($_GET["error"]) && $_GET["error"] == 2)
			{
				echo "<p>Sie haben leider ein falsches Passwort angegeben. Bitte versuchen Sie es erneut.</p>";
			}
			?></form>
            
    	</div> <!-- #impressum -->
    </div> <!-- #main -->

<?php
// --> FOOTER
include("footer.php");
?>