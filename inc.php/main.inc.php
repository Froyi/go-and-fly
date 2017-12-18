<?php
// Tags werden ausgegeben
?>
<div class="container">
    	<?php 
		$counter = 0; // für das Clear nach der ersten Zeile
		while ($reise = mysql_fetch_assoc($re))
		{
			// Reise wird ausgegeben
			
			// Kurzbeschreibung wird gekürzt
			$kurzbeschreibung = kuerzen($reise["kurzbeschreibung"], $kurzLimit);
			
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
		if($counter == 0)
		{
			// keine Reise verfügbar
		?>
        	<div id="keineReise">
            	<p>Wir haben leider zu Ihren Angaben keine passende Reise gefunden. Bitte verringern Sie die Schlagwörter oder schauen Sie in einer weiteren Region nach einer entsprechenden Reise.</p>			
                <p>Hinweis: Wenn die Schlagwörter in roter Farbe dargestellt sind, haben Sie diese ausgewählt. Klicken Sie erneut auf ein rotes Wort, um es aus Ihrer Auswahl zu entfernen.</p>
            </div> <!-- #keineReise -->
        <?php	
		}
		?>
        <p class="clear"></p>
		</div> <!-- #container --> 
        
        <!-- Ab hier werden die Reisen als Liste ausgegeben -->
        <div id="reiseListeContainer" class="left">
        	<?php 
			$counter = 0; // für das Clear nach der ersten Zeile
			while ($reise = mysql_fetch_assoc($re2))
			{
				if($counter >= 3 && $counter < 10)
				{
					// Ausgabe der Reise
					// Kurzbeschreibung wird gekürzt
					$kurzbeschreibung = kuerzen($reise["kurzbeschreibung"], $kurzLimit);
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
                            <img src="img/zeit.png" title="Reisedauer"/>
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
				}
				$counter ++;
			}
			?>
        </div> <!-- #reiseListeContainer -->
        <div class="right">
        	<?php 
			if($counter >= 3)
			{
				include("sidebar.inc.php");
			}
			?>
        </div>
        <div class="clear"></div>