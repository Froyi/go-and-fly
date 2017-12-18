<?php 
// REISE

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "reise.php";
$seitentitel = "go and fly - Reiseansicht";

// --> Datenbankdefinition
require_once("connect/db.php");

// --> Datenbankzugriffe
// Abfragen zu Formulareingaben und Definitionen von Inhalten

// --> HEADER
include("header.php");
$re = query_reise();
if($re == false)
{
	echo "Sie haben keine Reise Ausgewählt. Bitte gehen Sie zurück zur Startseite.";
	exit;
}
?>

    <div id="main">
		<div id="reiseContainer">
        	<div class="left" id="reiseContent">
            	<div class="zurueck"><a href="index.php">Zurück zur Reiseauswahl</a></div>
            	<h3><?php echo $re["titel"]; ?></h3>
            	<div><?php echo $re["beschreibung"]; ?></div>
            	<div id="reiseFormular">
                <p>Wenn Sie sich für diese Reise interessieren, dann schreiben Sie uns:</p>
                	<form action="inc.php/mail.sc.php" method="post">
                    	<p><select name="anrede" required>
                        		<option value="0" selected>Bitte auswählen</option>
                                <option value="Frau">Frau</option>
                                <option value="Herr">Herr</option>
                            </select>
                        <p><input type="text" name="vorname" placeholder="Ihr Vorname" required /></p>
                    	<p><input type="text" name="name" placeholder="Ihr Name"  required/></p>
                        <p><input type="email" name="email" placeholder="Ihre E-Mail" required /></p>
                        <p><input type="tel" name="telefon" placeholder="Ihre Telefonnummer" required /></p>
                        <p><input type="text" name="adresse" placeholder="Ihre Straße und Hausnummer" required /></p>
                        <p><input type="text" name="plz" placeholder="Ihre Postleitzahl" required /></p>
                        <p><input type="text" name="ort" placeholder="Ihr Ort" required /></p>
                        <p><select name="termin">
                        		<option value="0" selected>Termin ist zweitrangig</option>
                                <?php
								// Preiskategorien holen
								$terminPreis = holeTermine($_GET["re_id"]);
								while($terminP = mysql_fetch_assoc($terminPreis))
								{
								?>
                                <option value="<?php echo dbDatumAusgabe($terminP["start"])." - ".dbDatumAusgabe($terminP["ende"])." ".$terminP["preis"]; ?>"><?php echo dbDatumAusgabe($terminP["start"])." - ".dbDatumAusgabe($terminP["ende"])." ".$terminP["preis"]; ?></option>
                                <?php
								} //while
								?>
                            </select></p>
                        <p><textarea name="anmerkung" placeholder="Hier ist Platz für Ihre Anmerkungen bzw. Wünsche zu dieser Reise." ></textarea></p>
                        <input type="hidden" name="titel" value="<?php echo $re["titel"]; ?>" />
                        <input type="hidden" name="seite" value="../reise.php?re_id=<?php echo $_GET["re_id"]; ?>" />
                        <p><input type="submit" name="submit" value="Nachricht absenden" /></p>
                        <?php if(isset($_GET["mailsend"]) && $_GET["mailsend"] == "true") echo "<p>Vielen Dank für Ihr Interesse. Wir werden uns schnellstmölichst mit Ihnen in Verbindung setzen.</p>" ?>
                        <!--<p><input type="submit" name="submit" placeholder="Senden" /></p>-->
                    </form>
                </div> <!-- #reiseFormular -->
            </div>
            <div class="right" id="reiseSidebar">
            	<div id="reiseSidebarKarte">
                	<a href="img/reise/karte/<?php echo holeKarte($_GET["re_id"]); ?>" class="fancybox"><img src="img/reise/karte/<?php echo holeKarte($_GET["re_id"]); ?>" /></a>
                </div> <!-- #reiseSidebarKarte -->
                
                <div id="reiseSidebarKurzinformation">
                	<table class="left">
                    	<tr>
                        	<td><img src="img/person.png" title="Personengruppen" /></td>
                            <td><img src="img/zeit.png" title="Reisedauer" /></td>
                            <td><img src="img/flug.png" title="Flugdauer bis zum ersten Ziel" /></td>
                            <td><img src="img/sprache.png" title="Die Reise wird in folgender Sprache gehalten." /></td>
                        </tr>
                        <tr>
                        	<td><?php echo $re["personen"]; ?></td>
                            <td><?php echo $re["zeit"]."t"; ?></td>
                            <td><?php echo $re["flug"]."h"; ?></td>
                            <td><?php echo $re["sprache"]; ?></td>
                        </tr>
                    </table>
                	<img class="left" src="img/terrain_<?php echo $re["terrain"].".png"; ?>" title="Terrain Wertung - Beschreibt die körperliche Anstrengung bei dieser Reise" />
                    <p class="clear"></p>
                </div> <!-- #reiseSidebarKurzinformation -->
                
                <div id="reiseSidebarReiseverlauf" class="reiseSidebarContainer">
                	<h3>Reiseverlauf</h3>
                    <p>Für mehr Details klicken Sie auf einen Reiseverlauf.</p>
                    <div id="reiseverlaufDetail">
                    <?php
					// hole Reiseverlauf
					$re_verl = holeReiseverlauf($_GET["re_id"]);
					$countReiseVerlauf = 0;
					while($reiseVerlauf = mysql_fetch_assoc($re_verl))
					{
						// gibt den Reiseverlauf zurück	
					?>
                    <p><span onClick="showVerlauf('<?php echo $reiseVerlauf["id"]; ?>');"><?php echo $reiseVerlauf["titel"]; ?>: </span></p>
					<p style="display:none;" id="verlauf<?php echo $reiseVerlauf["id"]; ?>" class="verlauf"><?php echo $reiseVerlauf["beschreibung"]; ?></p>
                    <?php
					$countReiseVerlauf ++;
					}
					?>
                    </div> <!-- #reiseverlaufDetail -->
                    <?php
				// schauen, ob ein mehr hin muss
				if($countReiseVerlauf > 15)
					{
						?>
                        <style>
                        	#reiseverlaufDetail
							{
								height:490px;
								overflow:hidden;
							}
                        </style>
                        <?php
						echo "<p onClick=\"showReiseverlauf();\" id=\"reiseverlaufMehr\">mehr ...</p>";	
					}
				
				?>
                </div> <!-- #reiseSidebarReiseverlauf -->
                
                <div class="reiseSidebarContainerAfter"></div>
                
                <div id="reiseSidebarHotline">
                	<img src="img/hotlineSidebar.png" />
                </div> <!-- #reiseSidebarHotline -->
                
                <div id="reiseSidebarTermine" class="reiseSidebarContainer">
                	<div id="reiseTerminContainer">
                        <h3>Termine und Preise</h3>
                        <table>
                        <?php
                        // hole Termine
                        $re_term = holeTermine($_GET["re_id"]);
                        $countTermine = 0;
                        while($reiseTermine = mysql_fetch_assoc($re_term))
                        {
                            // gibt den ReiseTermine zurück	
                        ?>
                       <tr>
                        <td><?php echo dbDatumAusgabe($reiseTermine["start"]); ?></td>
                        <td> - </td>
                        <td><?php echo dbDatumAusgabe($reiseTermine["ende"]); ?></td>
                        <td><?php echo $reiseTermine["preis"]; ?></td>
                       </tr>
                        <?php
                        $countTermine ++;
                        }
                        ?>
                        </table>
                    </div> <!-- #reiseTerminContainer -->
                     <?php
				// schauen, ob ein mehr hin muss
				if($countTermine > 10)
					{
						?>
                        <style>
                        	#reiseTerminContainer
							{
								height:235px;
								overflow:hidden;
							}
                        </style>
                        <?php
						echo "<p onClick=\"showTermine();\" id=\"termineMehr\">mehr ...</p>";	
					}
				
				?>
                </div> <!-- #reiseSidebarTermine -->  
                <div class="reiseSidebarContainerAfter"></div>
                
                <div id="reiseSidebarLeistungen">
                	<h3>Leistungen</h3>
                    <div id="reiseSidebarLeistungenContainer">
						<?php
                        // hole Reiseleistungen
                        $re_leis = holeReiseleistungen($_GET["re_id"]);
						$counter = strlen($re_leis["text"]);
						
                        ?>
                        <?php echo $re_leis["text"]; ?>
					</div>
                    <?php 
					if($counter > 500)
					{
						echo "<p onClick=\"showLeistungen();\" id=\"leistungenMehr\">mehr ...</p>";	
					}
					?>
                </div> <!-- #reiseSidebarLeistungen -->
                
                <div id="reiseSidebarFragen" class="reiseSidebarContainer">
                	<h3>Fragen und Antworten</h3>
                    <?php
                    // hole Fragen
					$re_frag = holeReisefragen($_GET["re_id"]);
					while($reiseFragen = mysql_fetch_assoc($re_frag))
					{
						// gibt den ReiseFragen zurück	
					?>
                    	<p><span><?php echo $reiseFragen["frage"]; ?></span><br/> <?php echo $reiseFragen["antwort"]; ?></p>
                    <?php
					}
					?>
                </div> <!-- #reiseSidebarFragen-->
                <div class="reiseSidebarContainerAfter"></div>
            </div>
            <p class="clear"></p>
            
            <div id="reiseRecommender">
        		<h2>Diese Reisen könnte Sie auch interessieren</h2>
                <div id="reiseRecommenderContainer">
                    <div class="container">
    	<?php 
		$counter = 0; // für das Clear nach der ersten Zeile
		$reis = holeReiseAusRegion();
		while ($reise = mysql_fetch_assoc($reis))
		{
			// Reise wird ausgegeben
			
			// Kurzbeschreibung wird gekürzt
			$kurzbeschreibung = kuerzen($reise["kurzbeschreibung"], $kurzLimit);
			if($_GET["re_id"] != $reise["id"])
			{
			// wenn Counter über 3 ist, dann soll es ein Clear geben
			if($counter >= 3)
			{
				
				echo "<p class=\"clear\"></p>";
				break;
			}
		?>
        <div class="reise">
        	<a href="reise.php?re_id=<?php echo $reise["id"]; ?>">
                <img src="img/reise/<?php echo $reise["bild"]; ?>" />
            </a>
                <h3><a href="reise.php?re_id=<?php echo $reise["id"]; ?>"><?php echo $reise["titel"]; ?></a></h3>
                <p><?php echo $kurzbeschreibung; ?></p>
                <p class="whiteLine"></p>
                <div class="reiseKurzinformation">
                    <div>
                        <img src="img/person.png" title="Personengruppen" />
                        <p><?php echo $reise["personen"]; ?></p>
                    </div> <!--personen-->
                    <div>
                        <img src="img/zeit.png" title="Reisedauer" />
                        <p><?php echo $reise["zeit"]."t"; ?></p>
                    </div> <!--reisezeit-->
                    <div>
                        <img src="img/flug.png" title="Flugdauer bis zum ersten Ziel" />
                        <p><?php echo $reise["flug"]."h"; ?></p>
                    </div> <!--flug-->
                    <div>
                        <img src="img/terrain_<?php echo $reise["terrain"].".png"; ?>" title="Terrain Wertung - Beschreibt die körperliche Anstrengung bei dieser Reise" />
                    </div> <!--terrain-->
                    <p class="clear"></p>
                </div> <!-- #reiseKurzinformation -->
            </div> <!-- #reise -->	
        <?php
		$counter ++;
			}
		}
		?>
        <p class="clear"></p>
		</div> <!-- #container --> 
                </div> <!-- #reiseRecommenderContainer -->
        	</div> <!-- #reiseRecommender --> 
        </div> <!-- #reiseContainer -->
       
    </div> <!-- #main -->

<?php
// --> FOOTER
include("footer.php");
?>