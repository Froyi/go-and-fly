<?php 
// ADMIN

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "admin.php";
$seitentitel = "go and fly - Administration";

// --> Datenbankdefinition
require_once("connect/db.php");

// --> Datenbankzugriffe
// Abfragen zu Formulareingaben und Definitionen von Inhalten

// --> HEADER
include("header.php");

// Prüfen, ob der Nutzer eingeloggt ist
if(!loggedIn())
{
	echo "Sie sind leider nicht eingeloggt.";
}
else
{
?>

    <div id="main" class="containerAdmin">
    	<p>Willkommen im "go and fly" Admin Bereich. Hier können Sie Reisen anlegen, bearbeiten und löschen, sowie Ihre Neuigkeiten verwalten und sich um die Darstellung der Hauptgrafiken kümmern.</p>
		<div id="erstelleReise">
        	<h3 onClick="toggleAdmin('erstelleReiseContainer')">Eine Neue Reise erstellen</h3>
        	<div id="erstelleReiseContainer" style="display:none;">
                
                <form action="sc.php/admin.sc.php" name="erstelleReiseForm" method="post" enctype="multipart/form-data">
                    <div class="left">
                        <p>Titel: <br/><input type="text" name="titel" required placeholder="Titel der Reise" /></p>
                        <p>Beschreibung der Reise:<br/><textarea name="editorCKE" placeholder="Beschreibung der Reise" required>Beschreibung der Reise</textarea></p>
                        <p>Kurzbeschreibung der Reise:<br/><textarea name="kurzbeschreibung" id="erstelleReiseFormKurzbeschreibung" placeholder="Kurzbeschreibung der Reise" required></textarea></p>
                        <p>Reiseveranstalter der Reise:<br/><input type="text" name="veranstalter" placeholder="Reiseveranstalter" /></p>
                    </div> <!-- .left -->
                    <div class="right">
                        <p>Personenanzahl:<br/><input type="text" name="personen" required placeholder="Personenanzahl Bsp.: 4-6" /></p>
                        <p>Reisedauer in Tagen:<br/><input type="text" name="zeit" required placeholder="Reisedauer in Tagen Bsp.: 14" /></p>
                        <p>Flugdauer zum ersten Ziel:<br/><input type="text" name="flug" required placeholder="Flugdauer zum ersten Ziel in Stunden Bsp.: 4" /></p>
                        <p>Sprache der Reise:<br/><input type="text" name="sprache" required placeholder="Sprache der Reise Bsp.: deutsch / englisch" /></p>
                        <div class="terrainWertung">
                    <p class="left"><img src="img/terrain_1.png"/><br/><input type="radio" name="terrain" value="1" /></p>
                    <p class="left"><img src="img/terrain_2.png"/><br/><input type="radio" name="terrain" value="2" /></p>
                    <p class="left"><img src="img/terrain_3.png"/><br/><input type="radio" name="terrain" value="3"  /></p>
                    <p class="left"><img src="img/terrain_4.png"/><br/><input type="radio" name="terrain" value="4" /></p>
                    <p class="left"><img src="img/terrain_5.png"/><br/><input type="radio" name="terrain" value="5"  /></p>
					<p class="clear"></p>
                    </div> <!-- .terrainWertung -->
                        <p>Vorschau Bild auswählen:<br/><input type="file" name="vorschauBild" /></p>
                       
                        <p>Reiseregionen hinzufügen:<br/>
                        <select class="multipleSelect" name="region[]" multiple size="5" required>
                            <?php
                            // hole alle Kontinente
                            $kon = holeKontinente();
                            while($kontinent = mysql_fetch_assoc($kon))
                            {
                            ?>
                            <optgroup label="<?php echo $kontinent["name"]; ?>">
                                <?php 
                                // hole regionen des Kontinents
                                $reg = holeRegionen($kontinent["id"]);
                                while($regionen = mysql_fetch_assoc($reg))
                                {
                                ?>
                                <option value="<?php echo $regionen["id"]; ?>"><?php echo $regionen["titel"]; ?></option>
                                <?php
                                } // while regionen
                                ?>
                            </optgroup>
                            <?php
                            } // while kontinente
                            ?>
                        </select>
                        </p>
                        <p>Sichtbar bis:<br/>
                        <input type="date" name="sichtbar" placeholder="Sichtbar bis (Format: yyy-mm-dd)" /></p>
                    </div> <!-- .right --> 
                        <p class="clear"><input type="submit" name="submit" value="Absenden" /></p>
                    </form>
                </div> 
                <?php 
				if(isset($_GET["did"]) && $_GET["did"] == "1")
				{?>
                <p class="errorLog">Sie haben erfolgreich eine Reise angelegt.</p>
                <?php } ?>
        </div> <!-- #erstelleReise -->
        
        <div id="bearbeiteReise">
        	<h3>Suchen Sie sich die Reise heraus, die Sie bearbeiten wollen.</h3>
        	<?php
                if(isset($_GET["did"]) && $_GET["did"] == "12")
				{?>
                <p class="errorLog">Die Reise wurde erfolgreich gelöscht.</p>
                <?php } ?>
			<?php
			// Vorauswahl der zu bearbeitenden Reise
				$rei = holeReiseSuche(); 
				
				$regio = holeRegionen();
			?>
            <form name="holeReisedatenForm" method="post" action="admin.php#bearbeiteReise">
				<p>
                <select name="reiseAuswahl" id="holeReisedatenformAuswahl">
                	<option value="0">Bitte wählen Sie eine Reise aus</option>
                    
                    <?php
					while($reiRegionen = mysql_fetch_assoc($regio))
					{
					?>
                    	<optgroup label="<?php echo $reiRegionen["titel"]; ?>">
                    <?php
						// Reisen aus der Region holen
						$reiseRegion = holeReiseAusRegion2($reiRegionen["id"]);
						
						while($reise = mysql_fetch_assoc($reiseRegion))
						{
						?>
						<option value="<?php echo $reise["id"]; ?>" 
						<?php if((isset($_POST["reiseAuswahl"]) && $_POST["reiseAuswahl"] == $reise["id"]) || (isset($_GET["reiseAuswahl"]) && $_GET["reiseAuswahl"] == $reise["id"]) )
						{ 
							echo "selected"; 
						} ?>>
						<?php echo $reise["titel"]." - erstellt am ".dbDatumAusgabe($reise["eingestellt"])." ".$reise["veranstalter"]; ?>
						</option>
						<?php
						} // while
						?>
                        </optgroup>
                    <?php
					}				
					?>
                </select>
                </p>
            	<p><input type="submit" name="submit" value="Reise auswählen" /></p>
            </form>
        	<?php // Prüfen ob es Parameter gibt
	
				// 01 Prüfen auf vorhandensein von Bearbeitungsreisen
				if(isset($_POST["reiseAuswahl"]) || isset($_GET["reiseAuswahl"]))
				{
					if(isset($_POST["reiseAuswahl"]))
					{
						$bearbeiteReise = holeReiseSuche($_POST["reiseAuswahl"]);
					}
					else if(isset($_GET["reiseAuswahl"]))
					{
						$bearbeiteReise = holeReiseSuche($_GET["reiseAuswahl"]);
					}
				?>
                <h3 class="marginLeft">Reise bearbeiten</h3>
                <p>Bearbeiten Sie hier Ihre bereits erstellten Reisen. Egal ob Termine, Preise, Reiseverläufe oder bereits eingetragene Grunddaten.</p>
                <?php
                if(isset($_GET["did"]) && $_GET["did"] == "2")
				{?>
                <p class="errorLog">Die Reise wurde erfolgreich bearbeitet.</p>
                <?php } ?>
                <div class="left">
                    <form action="sc.php/admin.sc.php" method="post" name="bearbeiteReiseForm" enctype="multipart/form-data">
                    <p>Titel:<br/><input type="text" name="titel" required placeholder="Titel der Reise" value="<?php echo $bearbeiteReise["titel"]; ?>" /></p>
                    <p>Beschreibung der Reise:<br/><textarea name="editorCKE2" placeholder="Beschreibung der Reise" required><?php echo $bearbeiteReise["beschreibung"]; ?></textarea></p>
                    <p>Kurzbeschreibung der Reise:<br/>
                    <textarea name="kurzbeschreibung" id="bearbeiteReiseFormKurzbeschreibung" placeholder="Kurzbeschreibung der Reise" required><?php echo $bearbeiteReise["kurzbeschreibung"]; ?></textarea></p>
                    <p>Reiseveranstalter der Reise:<br/><input type="text" name="veranstalter" value="<?php echo $bearbeiteReise["veranstalter"]; ?>" placeholder="Reiseveranstalter" /></p>
                    <p>Karte uploaden:<br/><input type="file" name="kartenBild" /></p>
                    <p>Teaserbild uploaden:<br/><input type="file" name="teaserBild" /></p>
                    <p>Personenanzahl:<br/><input type="text" name="personen" required placeholder="Personenanzahl Bsp.: 4-6" value="<?php echo $bearbeiteReise["personen"]; ?>" /></p>
                    <p>Reisedauer in Tagen:<br/><input type="text" name="zeit" required placeholder="Reisedauer in Tagen Bsp.: 14" value="<?php echo $bearbeiteReise["zeit"]; ?>" /></p>
                    <p>Flugdauer zum ersten Ziel:<br/><input type="text" name="flug" required placeholder="Flugdauer bis zum ersten Ziel in Stunden Bsp.: 4" value="<?php echo $bearbeiteReise["flug"]; ?>" /></p>
                    <p>Sprache der Reise:<br/><input type="text" name="sprache" required placeholder="Sprache der Reise Bsp.: deutsch / englisch" value="<?php echo $bearbeiteReise["sprache"]; ?>" /></p>
                    <p>Terrainwertung:</p>
                    <div class="terrainWertung">
                    <p class="left"><img src="img/terrain_1.png"/><br/><input type="radio" name="terrain" value="1" <?php if($bearbeiteReise["terrain"] == 1) echo "checked"; ?>  /></p>
                    <p class="left"><img src="img/terrain_2.png"/><br/><input type="radio" name="terrain" value="2" <?php if($bearbeiteReise["terrain"] == 2) echo "checked"; ?>  /></p>
                    <p class="left"><img src="img/terrain_3.png"/><br/><input type="radio" name="terrain" value="3" <?php if($bearbeiteReise["terrain"] == 3) echo "checked"; ?>  /></p>
                    <p class="left"><img src="img/terrain_4.png"/><br/><input type="radio" name="terrain" value="4" <?php if($bearbeiteReise["terrain"] == 4) echo "checked"; ?>  /></p>
                    <p class="left"><img src="img/terrain_5.png"/><br/><input type="radio" name="terrain" value="5" <?php if($bearbeiteReise["terrain"] == 5) echo "checked"; ?>  /></p>
					<p class="clear"></p>
                    </div> <!-- .terrainWertung -->
                    <p>Neues Bild auswählen: <br/><input type="file" name="vorschauBild" /><br/> Derzeit ausgewähltes Bild: <br/><img src="img/reise/<?php echo $bearbeiteReise["bild"]; ?>" /></p>
                    <p>Reiseregionen hinzufügen:<br/>
                <?php // hole RegionsIds der Reise
					$regionsIds = holeRegionsIds($bearbeiteReise["id"]);
				?>
                <select class="multipleSelect" name="region[]" multiple size="5" required>
                	<?php
					// hole alle Kontinente
					$kon = holeKontinente();
					while($kontinent = mysql_fetch_assoc($kon))
					{
					?>
                    <optgroup label="<?php echo $kontinent["name"]; ?>">
                    	<?php 
						// hole regionen des Kontinents
						$reg = holeRegionen($kontinent["id"]);
						while($regionen = mysql_fetch_assoc($reg))
						{
							
						
						?>
                        <option value="<?php echo $regionen["id"]; ?>" 
						<?php 
						foreach($regionsIds as $regionsIdsValue)
						{ 
							if($regionsIdsValue == $regionen["id"])
							{
								echo "selected";
							}
						}
							?>
                        ><?php echo $regionen["titel"]; ?></option>
                        <?php
						} // while regionen
						?>
                    </optgroup>
                    <?php
					} // while kontinente
					?>
                </select>
                </p>
                <p>Sichtbar bis:<br/>
                        <input type="date" name="sichtbar" placeholder="Sichtbar bis (Format: yyy-mm-dd)" value="<?php echo $bearbeiteReise["sichtbar"]; ?>" /></p>
                <input type="hidden" name="reiseBearbeitung" value="<?php echo $bearbeiteReise["id"]; ?>" />
                <p><input type="checkbox" name="delete"/> Wollen Sie diese Reise komplett löschen?</p>
                <p><input type="submit" name="submit" value="Absenden" /></p>
                </form>
                
				</div> <!-- .left -->
                
                <div class="right">
                	<h3>Sidebar Informationen</h3>
                    <p>Hier erstellen Sie Fragen und Antworten aus der Sidebar.</p>
			<?php
				// Fragen & Antworten hinzufügen
			?>
            <?php
                if(isset($_GET["did"]) && $_GET["did"] == "3")
				{?>
                <p class="errorLog">Die Frage wurde erfolgreich eingetragen.</p>
                <?php } ?>
            	<div id="erstelleFragen">
                	<form action="sc.php/admin.sc.php" method="post" name="erstelleFragenReise">
                    	<p>Stellen Sie hier Ihre Frage:<br/><input type="text" name="frage" required placeholder="Stellen Sie hier Ihre Frage" /></p>
                        <p>Hier steht Ihre Antwort:<br/><textarea name="antwort" required placeholder="Hier steht Ihre Antwort" ></textarea></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                        <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>" />
                         <input type="hidden" name="modus" value="fragenErstellen" />
                    </form> 
                </div>	<!-- #erstelleFragen -->
                <?php 
				$fra = holeReisefragen($bearbeiteReise["id"]); 
				if(mysql_num_rows($fra) != 0)
				{
				?>
                <div id="bearbeiteFragen">
                	<p>Hier bearbeiten Sie Ihre Reisefragen</p>
                	<form action="admin.php#bearbeiteFragen" method="post" name="bearbeiteFragenReise">
                    	<p><select name="fragenListe">
                        	<option value="0">Bitte wählen Sie eine Frage aus</option>
                        	<?php 
								  while($fragen = mysql_fetch_assoc($fra))
								  {
                            ?>    
                            <option  value="<?php echo $fragen["id"]; ?>"
                            <?php 
							if((isset($_GET["fragenListe"]) && $_GET["fragenListe"] == $fragen["id"]) || (isset($_POST["fragenListe"]) && $_POST["fragenListe"] == $fragen["id"]))
							{
								echo "selected";
							}
							?>
                            ><?php echo $fragen["frage"]; ?></option>
                            <?php
								  }
							?>
                        </select></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                    	<input type="hidden" name="reiseAuswahl" value="<?php echo $bearbeiteReise["id"]; ?>" />
                    </form> 
                    
                    <?php
                    if(isset($_GET["fragenListe"]) || isset($_POST["fragenListe"]))
					{
						if(isset($_GET["fragenListe"]))
						{
							$holeFrage = holeReisefragen($bearbeiteReise["id"],$_GET["fragenListe"]); 
						}
						else
						{
			
							$holeFrage = holeReisefragen($bearbeiteReise["id"],$_POST["fragenListe"]); 
						}
						
						// Ausgabe der Fragen und Antworten
						?>
                        <form action="sc.php/admin.sc.php" name="bearbeiteFragenReise" method="post">
                        	<p><input type="text" name="frage" required placeholder="Stellen Sie hier Ihre Frage" value="<?php echo $holeFrage["frage"]; ?>" /></p>
                        	<p><textarea name="antwort" required placeholder="Hier steht Ihre Antwort" ><?php echo $holeFrage["antwort"]; ?></textarea></p>
                            <p><input type="checkbox" name="frageLoeschen" /> Möchten Sie diese Frage löschen?</p>
                       		<p><input type="submit" name="submit" value="Absenden" /></p>
                        	<input type="hidden" name="frageId" value="<?php echo $holeFrage["id"]; ?>" />
                            <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                           
                            <input type="hidden" name="modus" value="fragenBearbeiten" />
                        </form>
                    <?php    
					}
					?>
                </div>	<!-- #erstelleFragen -->
                <?php } // Bearbeite Fragen vorhanden??? ?>
                <?php // Erstelle Leistungen ?>
                <p>Hier erstellen Sie Reiseleistungen zu Ihrer Reise aus der Sidebar.</p>
                 <?php
                if(isset($_GET["did"]) && $_GET["did"] == "5")
				{?>
                <p class="errorLog">Die Leistung wurde erfolgreich eingetragen.</p>
                <?php } ?>
                <div id="erstelleLeistungen">
                <?php
					// Reiseleistung aus der Datenbank holen, falls vorhanden
					$lei = holeReiseleistungen($bearbeiteReise["id"]);
					?>
                	<form action="sc.php/admin.sc.php" method="post" name="erstelleLeistungenForm">
                    	<p><textarea name="editorCKE3" id="editorCKE3" required placeholder="Tragen Sie die Reiseleistung hier ein"><?php echo $lei["text"]; ?></textarea></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                           <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                           <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                    </form>
                </div> <!-- #erstelleLeistungen -->
                          
                 <?php // Erstelle Reiseverlauf ?>
                 <p>Hier erstellen Sie den Reiseverlauf zu Ihrer Reise aus der Sidebar.</p>
                 <?php
                if(isset($_GET["did"]) && $_GET["did"] == "6")
				{?>
                <p class="errorLog">Der Reiseverlauf wurde erfolgreich eingetragen.</p>
                <?php } ?>
                <div id="erstelleReiseverlauf">
                	<form action="sc.php/admin.sc.php" method="post" name="erstelleReiseverlaufForm">
                    	<p><input type="text" name="titel" required placeholder="Titel (Bsp.: Tag 1 - Ankunft)" /></p>
                        <p><textarea name="beschreibung" required placeholder="Beschreibung des Reiseverlaufes"></textarea></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                           <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                           <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                           <input type="hidden" name="reiseVerlauf" value="true" />
                    </form>
                </div> <!-- #erstelleReiseverlauf -->
                
                <?php // bearbeite und lösche den Reiseverlauf ?>
                <div id="bearbeiteReiseverlauf">
                	<p>Hier bearbeiten Sie Ihre Reiseverlauf</p>
                	<form action="admin.php#bearbeiteReiseverlauf" method="post" name="bearbeiteReiseverlaufReise">
                    	<p><select name="verlaufListe">
                        	<option value="0">Bitte wählen Sie eine Reiseverlauf aus</option>
                        	<?php 
								$ver = holeReiseverlauf($bearbeiteReise["id"]);
								  while($verlauf = mysql_fetch_assoc($ver))
								  {
                            ?>    
                            <option  value="<?php echo $verlauf["id"]; ?>"
                            <?php 
							if((isset($_GET["verlaufListe"]) && $_GET["verlaufListe"] == $verlauf["id"]) || (isset($_POST["verlaufListe"]) && $_POST["verlaufListe"] == $verlauf["id"]))
							{
								echo "selected";
							}
							?>
                            ><?php echo $verlauf["titel"]; ?></option>
                            <?php
								  }
							?>
                        </select></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                    	<input type="hidden" name="reiseAuswahl" value="<?php echo $bearbeiteReise["id"]; ?>" />
                    </form> 
                	<?php
                    if(isset($_GET["verlaufListe"]) || isset($_POST["verlaufListe"]))
					{
						if(isset($_GET["verlaufListe"]))
						{
							$holeVerlauf = holeReiseverlauf($bearbeiteReise["id"],$_GET["verlaufListe"]); 
						}
						else
						{
			
							$holeVerlauf = holeReiseverlauf($bearbeiteReise["id"],$_POST["verlaufListe"]); 
						}
					
                
                ?>
                	<form action="sc.php/admin.sc.php" method="post" name="bearbeiteReiseverlaufForm">
                        	<p><input type="text" name="leistungTitel" value="<?php echo $holeVerlauf["titel"]; ?>"/></p>
                            <p><textarea name="leistungBeschreibung" required placeholder="Beschreibung des Reiseverlaufes"><?php echo $holeVerlauf["beschreibung"]; ?></textarea></p>
                            <p><input type="checkbox" name="loescheVerlauf" /> Möchten Sie diese Reiseleistung löschen?</p>

                    	<input type="submit" name="submit" value="Absenden" />
                        <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                        <input type="hidden" name="verlaufId" value="<?php echo $holeVerlauf["id"]; ?>"/>
                        <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                        <input type="hidden" name="reiseVerlaufBearbeiten" value="true" />
                    </form>
                <?php } ?>
                </div> <!-- #bearbeiteReiseverlauf -->
                
                <p>Hier erstellen Sie Reisetermine und die dazugehörigen Preise aus der Sidebar.</p>
                 <?php
                if(isset($_GET["did"]) && $_GET["did"] == "7")
				{?>
                <p class="errorLog">Der Termin wurde erfolgreich eingetragen.</p>
                <?php } ?>
                
                <div id="erstelleTermine">
                	<form action="sc.php/admin.sc.php" method="post" name="erstelleTermineForm">
                    	<p><input type="date" name="start" placeholder="Startdatum Format: yyy-mm-dd" required /></p>
                        <p><input type="date" name="ende" required placeholder="Enddatum Format: yyy-mm-dd" /></p>
                    	<p><input type="text" name="preis" required placeholder="Preis in € (Bsp.: 1.999€)" /></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                           <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                           <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                           <input type="hidden" name="erstelleTermine" value="true" />
                           
                    </form>
                </div> <!-- #erstelleTermine -->
                
                <?php // bearbeite und lösche der Termine ?>
                <div id="bearbeiteReisetermine">
                	<p>Hier bearbeiten Sie Ihre Reisetermine</p>
                	<form action="admin.php#bearbeiteReisetermine" method="post" name="bearbeiteReisetermineReise">
                    	<p><select name="termineListe">
                        	<option value="0">Bitte wählen Sie einn Reisetermin aus</option>
                        	<?php 
								$ter = holeTermine($bearbeiteReise["id"]);
								  while($termin = mysql_fetch_assoc($ter))
								  {
                            ?>    
                            <option  value="<?php echo $termin["id"]; ?>"
                            <?php 
							if((isset($_GET["termineListe"]) && $_GET["termineListe"] == $termin["id"]) || (isset($_POST["termineListe"]) && $_POST["termineListe"] == $termin["id"]))
							{
								echo "selected";
							}
							?>
                            ><?php echo dbDatumAusgabe($termin["start"])." - ".dbDatumAusgabe($termin["ende"]).": ".$termin["preis"]; ?></option>
                            <?php
								  }
							?>
                        </select></p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                    	<input type="hidden" name="reiseAuswahl" value="<?php echo $bearbeiteReise["id"]; ?>" />
                    </form> 
                	<?php
                    if(isset($_GET["termineListe"]) || isset($_POST["termineListe"]))
					{
						if(isset($_GET["termineListe"]))
						{
							$holeTermine = holeTermine($bearbeiteReise["id"],$_GET["termineListe"]); 
						}
						else
						{
			
							$holeTermine = holeTermine($bearbeiteReise["id"],$_POST["termineListe"]); 
						}
					
                
                ?>
                	<form action="sc.php/admin.sc.php" method="post" name="bearbeiteReisetermineForm">
                        	<p>Startdatum:<br/><input type="date" name="start" value="<?php echo $holeTermine["start"]; ?>"/></p>
                            <p>Enddatum:<br/><input type="date" name="ende" value="<?php echo $holeTermine["ende"]; ?>"/></p>
                            <p>Preis:<br/><input type="text" name="preis" value="<?php echo $holeTermine["preis"]; ?>"/></p>
                            <p><input type="checkbox" name="loescheTermin" /> Möchten Sie diesen Termin löschen?</p>

                    	<input type="submit" name="submit" value="Absenden" />
                        <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                        <input type="hidden" name="terminId" value="<?php echo $holeTermine["id"]; ?>"/>
                        <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                        <input type="hidden" name="reiseTerminBearbeiten" value="true" />
                    </form>
                <?php } ?>
                </div> <!-- #bearbeiteReiseverlauf -->
                
                
                <p>Hier erstellen Sie die Tagzugehörigkeit der Reise für die Selektion auf der Startseite:</p>
                 <?php
                if(isset($_GET["did"]) && $_GET["did"] == "8")
				{?>
                <p class="errorLog">Die Tags wurden erfolgreich eingetragen.</p>
                <?php } ?>
                <div id="erstelleTags">
                	<form action="sc.php/admin.sc.php" method="post" name="erstelleTermineForm">
                    	<p>Tags hinzufügen:<br/>
                        <select name="tagAuswahl[]" multiple size="5" class="multipleSelect">
                            <?php
							// alle tags holen und ausgeben
							$tag = holeTag();
							
							while($tags = mysql_fetch_assoc($tag))
							{
							?>
                            <option  value="<?php echo $tags["id"]; ?>" <?php 
							$tagReise = tagReise($bearbeiteReise["id"]);
							while($tagR = mysql_fetch_assoc($tagReise))
							{
								if($tagR["tags_id"] == $tags["id"])echo "selected";
							}?>><?php echo $tags["name"]; ?></option>
                            <?php } // while($tags) ?>
                        </select>
                        </p>
                        <p><input type="submit" name="submit" value="Absenden" /></p>
                           <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                           <input type="hidden" name="reiseId" value="<?php echo $bearbeiteReise["id"]; ?>"/>
                           <input type="hidden" name="erstelleTags" value="true" />
                    </form>
                </div> <!-- #erstelleTags -->
            </div> <!-- .right -->
            <p class="clear"></p>
			<?php		
				}
			?>
            
        </div> <!-- #bearbeiteReise --> 
        
       
        <div id="erstelleNeuigkeit">
         	<h3 onClick="toggleAdmin('erstelleNeuigkeitenContainer')">Neuigkeiten erstellen</h3>
       		<div id="erstelleNeuigkeitenContainer" style="display:none;">
                <p>Hier können Sie Neuigkeiten erstellen und Bearbeiten.</p>
                <form action="sc.php/admin.sc.php" method="post" name="erstelleNeuigkeitForm">
                    <p>Titel der Neuigkeit:<br/>
                    <input type="text" name="titel" required placeholder="Titel der Neuigkeit" /></p>
                    <p>Beschreibung der Neuigkeit:<br/>
                    <textarea name="neuigkeitentext" class="neuigkeitBeschreibung" required placeholder="Beschreibung der Neuigkeit"></textarea></p>
                 <p><input type="submit" name="submit" value="Absenden" /></p>
                   <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                   <input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>"/>
                	<input type="hidden" name="erstelleNeuigkeit" value="true" />
                </form>
            </div> <!-- #erstelleNeuigkeitenContainer -->
             <?php
                if(isset($_GET["did"]) && $_GET["did"] == "9")
				{?>
                <p class="errorLog">Die Neuigkeit wurde erfolgreich eingetragen.</p>
                <?php } ?>
        </div> <!--#erstelleNeuigkeit -->
        
       
        <div id="bearbeiteNeuigkeit">
         <h3>Suchen Sie sich eine Neuigkeit heraus, die Sie bearbeiten wollen.</h3>
        	<form action="admin.php" method="post" name="bearbeiteNeuigkeitForm">
            	<p><select name="holeNeuigkeit" required>
                		<option value="0">Bitte wählen Sie eine Neuigkeit aus</option>
                        <?php
						// die letzten 10 Neuigkeiten holen
						$neu = holeNeuigkeiten();
						while($neuigkeit = mysql_fetch_assoc($neu))
						{
						?>
                        <option value="<?php echo $neuigkeit["id"]; ?>" <?php if(isset($_POST["holeNeuigkeit"]) && $_POST["holeNeuigkeit"] == $neuigkeit["id"]){ echo "selected"; } ?> ?><?php echo dbDatumAusgabe($neuigkeit["datum"])." - ".$neuigkeit["titel"]; ?></option>
						<?php	
						}
						?>
                </select>
                <p><input type="submit" name="submit" value="Absenden" /></p>
                   <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                   <input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>"/>
            </form>
             <?php
                if(isset($_GET["did"]) && $_GET["did"] == "11")
				{?>
                <p class="errorLog">Die Neuigkeit wurde erfolgreich geändert.</p>
                <?php } ?>
                 <?php
                if(isset($_GET["did"]) && $_GET["did"] == "10")
				{?>
                <p class="errorLog">Die Neuigkeit wurde erfolgreich gelöscht.</p>
                <?php } ?>
            <?php if(isset($_POST["holeNeuigkeit"])){ ?>
            <div id="bearbeiteNeuigkeitDetail">
            	<h3 class="marginLeft">Bearbeite Neuigkeit</h3>
            	<form action="sc.php/admin.sc.php" method="post" name="bearbeiteNeuigkeitDetailForm">
                <?php
				// holen der NeuigkeitenDaten
				$neuig = holeNeuigkeiten($_POST["holeNeuigkeit"]);
				?>
                	<p>Titel:<br/><input type="text" name="titel" value="<?php echo $neuig["titel"]; ?>" required /></p>
                    <p>Beschreibung der Neuigkeit:<br/><textarea class="neuigkeitBeschreibung" name="neuigkeitBeschreibung" required><?php echo $neuig["text"]; ?></textarea></p>
                    <p><input type="checkbox" name="loeschenNeuigkeit" /> Wollen Sie die Neuigkeit löschen?</p>
                    <p><input type="submit" name="submit" value="Absenden" /></p>
                   <input type="hidden" name="seite" value="<?php echo $seite; ?>"/>
                   <input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>"/>
                   <input type="hidden" name="neuigkeitenId" value="<?php echo $neuig["id"]; ?>" />
                	<input type="hidden" name="bearbeiteNeuigkeit" value="true" />
                </form>
            </div> <!-- #bearbeiteNeuigkeitDetail -->
            <?php } // isset($_POST["holeNeuigkeit"]) ?>
        </div> <!-- #bearbeiteNeuigkeit -->
    </div> <!-- #main -->

<?php
} // wenn eingeloggt end;
// --> FOOTER
include("footer.php");
?>