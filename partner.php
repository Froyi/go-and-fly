<?php 
// PARTNER

// ----------- Anmerkungen ---------------
// Für die Seite relevante Daten und Notizen
// To Do Liste
// Probleme

// SESSION starten
session_start();

// --> Variablen definieren
$seite = "partner.php";
$seitentitel = "go and fly - Partner";

// --> Datenbankdefinition
require_once("connect/db.php");

// --> Datenbankzugriffe
// Abfragen zu Formulareingaben und Definitionen von Inhalten

// --> HEADER
include("header.php");
$re = query_variablen();
?>

    <div id="main">
    	<div id="partner">
            <div id="chamaeleon" class="left">
                <a href="http://www.chamaeleon-reisen.de/?anr=106549"><img src="img/chamaeleon.jpg" /></a>
                <p><span>Das Besondere:</span> <br/>geführte Kleingruppenreisen 4-12 Personen</p>
                <p><span>Das Exklusive:</span> <br/>geführte Minigruppen 2-6 Personen</p>
                <p><span>Die Ziele:</span> <br/>weltweit, außer Europa, Nordamerika,Südsee</p>
                <p><span>Vor-Nachprogramme:</span> <br/>werden nach Wunsch individuell erstellt</p>
                <p><span>Verkehrssprache:</span> <br/>Deutsch</p>
                <p><span>Online:</span> <br/>über GO&FLY Hompage, Betreuung durch unsere Reisemanufaktur</p>
                
                <p class="partnerBeschreibung">CHAMÄLEON Reisen verbindet für uns das intensive Reiseerlebnis als geführte Gruppenreise mit geringer Teilnehmerzahl unter Einbindung von Spezialisten 	 				des jeweiligen Zielgebietes. Meist werden Reisevariaten zwischen 14 und 21 Tagen angeboten, die ausreichend  Informationen über Land und Leute bieten und dabei weit über Standards der  				Massenabieter hinaus gehen. Aktivitäten per Fahrzeug, zu Fuss oder per Rad orientieren sich an den örtlichen Bedingungen, richten sich überwiegend an Personen, die nicht an maximaler  				Leistung, sonder an Genuss Vorliebe finden.
                </p>
                <p><a href="http://www.chamaeleon-reisen.de/?anr=106549">www.chamaeleon-reisen.de</a></p>
        	</div> <!-- #studiosus -->
            
            <div id="diamir" class="left">
                <a href="https://www.diamir.de?agnr=35647"><img src="img/diamir.jpg" /></a>
                <p><span>Das Besondere:</span> <br/>Wandern,Trekking, Land-See Expeditionen</p>
                <p><span>Das Exklusive:</span> <br/>Privattouren ab 2 Personen </p>
                <p><span>Die Ziele:</span> <br/>welweit alle Regionen, auch seltene Destinationen</p>
                <p><span>Vor-und Nachprogramme:</span> <br/>für jedes Ziel nach Kundenwunsch</p>
                <p><span>Verkehrssprache:</span> <br/>Deutsch, Englisch tlw.mehrsprachig </p>
                <p><span>Online:</span> <br/>über GO&Fly Hompage,Betreuung durch unsere Reisemanufaktur</p>
    			
                <p class="partnerBeschreibung">DIAMIR ist unser Partner für aktive Reisvarinaten in Europa und den Interessantesten Zielen der gesamten Erde. Gegründet und geführt durch 3 	  			 				Bergsteiger, waren zunächt die Gebirgsregionen der Anden Südameikas, die Kilimadscharo Region, sowie der Himalaja/Nepal. Inzwischen sind Expeditionen und körperlich stark  	  	    			beanspruchende Touren zur Ausnahme geworden. Egal wohin Sie reisen möchten, "aktiv reisen - einander verstehen" könnte dem Reisstil treffend beschreiben.
                </p>

                <p><a href="https://www.diamir.de?agnr=35647">Partnerangebot Diamir</a></p>
            </div> <!-- #chamaeleon -->
            
            <div id="studiosus" class="left">
                <a href="http://www.studiosus.com/?agnr=71043"><img src="img/studiosus.jpg" /></a>
                <p><span>Das Besondere:</span> <br/>Studienreisen mit speziell qualifizierten Reiseleiten</p>
                <p><span>Das Exklusive:</span> <br/>"Service Plus": Mehrleistung und Spitzenunterkunft </p>
                <p><span>Die Ziele:</span> <br/>etwa 50% Europa ergänzt durch die übrigen Erdteile</p>
                <p><span>Vor-und Nachprogramme:</span> <br/>beschränkt möglich, variable Ausflugselemente</p>
                <p><span>Verkehrssprache:</span> <br/>Deutsch, Reisleiter sprich immer die Landessprache</p>
                <p><span>Online:</span> <br/>über GO&FLY Homepage, Bereuung durch unsere Reisemanufaktur</p>
                
                <p class="partnerBeschreibung">STUDIOSUS gilt als einer der renomiertesten Studienreisenabieter weltweit. Die Reiseleiterqualität ist immer überdurchschnittlich hoch. Soziale Kompetenz, Zielgebietsspezifische 		 				Ausbildung und überdurchschnittliche Allgemeinbildung sind immer zu erwarten. Die Wissensvermittlung geschieht dosiert in Kombination mit freier Zeit für den Gast.
                Die Gruppengröße ist i.d.Regel größer als 12. Aktivitäten sind eher erholsam oder umfassender bei der Produktlinie "Marco Polo" zugeordnet.
                </p>
                    
                <p><a href="http://www.studiosus.com/?agnr=71043">www.studiosus.com</a></p>
            </div> <!-- #diamir -->
            <p class="clear"></p>
    	</div> <!-- #partner -->
    </div> <!-- #main -->

<?php
// --> FOOTER
include("footer.php");
?>