<?php
// Sidebar
?>
<?php
// Partner werden ausgegeben
?>
<?php
	if($seite == "index.php")
	{
		// Ausgabe für die Startseite
	?>
	<div id="mainSidebar">
    	<img src="img/schildSidebar.png" id="schildSidebar" />
    	<h3>Neuigkeiten</h3>
        <div id="neuigkeitenContainer">
        <?php
			// Neuigkeiten holen
			$ne = holeNeuigkeiten();
			while($neuigkeit = mysql_fetch_assoc($ne))
			{
		?>
        <div class="neuigkeit">
        	<!--<p class="right"><span><?php // echo dbDatumAusgabe($neuigkeit["datum"]); ?></span></p>-->
            <p class="left"><span><?php echo $neuigkeit["titel"]; ?></span></p>
            
            <p class="clear"><?php echo $neuigkeit["text"]; ?><!--<img src="img/pfeilSidebar.png" />--></p>
            <p class="whiteLine"></p>
        </div> <!-- .neuigkeit -->
        <?php
			} 
		?>
        </div> <!-- #neuigkeitenContainer -->
    </div> <!-- #sidebar -->
    <?php	
	}
	else
	{
?>
<div id="sidebar">
	<a href="http://www.chamaeleon-reisen.de/?anr=106549"><img src="img/partner/chamaeleon.png" width="100%" /></a>
    <a href="https://www.diamir.de?agnr=35647"><img src="img/partner/diamir.jpg" width="100%" /></a>
    <a href="http://www.studiosus.com/?agnr=71043"><img src="img/partner/studiosus.png" width="100%" /></a>
    <a href="http:www.portfolio-ms.de"><img src="img/partner/ms.png" width="100%" /></a>
</div> <!-- #sidebar -->
<?php
	}
?>