<?php
// Session starten
session_start();

// header setzen
header("Content-Type: text/html; charset=utf-8");
header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

// Datenbank 
include_once("../connect/db.php");
include_once("../inc.php/functions.inc.php");

$kontinentId = $_GET["kontinentenId"];

// Daten zu dem Kontinent holen
$kon = holeKontinente($kontinentId);

// Regionen zu der Region holen
$reg = holeRegionen($kontinentId);
?>

<!-- AUSGABE DER NAVIGATION -->
<div class="left">
	<!-- Ausgabe der Liste an Regionen mit Beispielen -->
    <?php
		while($region = mysql_fetch_assoc($reg))
		{
	?>
    	<div onMouseOver="showNavigationRegion('<?php echo $region["bild"]; ?>', '<?php echo $region["id"]; ?>');">
        	<a <?php if($region["id"] == 57 ){?>href="http://goandfly-bus.blueandwhite.de/" <?php }else{ ?> href="index.php?re_id=<?php echo $region["id"]; ?>"<?php } ?>>
            <p><?php echo $region["titel"]; ?></p>
            <span><?php echo $region["beispiellaender"] ?></span></a>
		</div>
    <?php 
		} // while() 
	?>
</div>

<div class="right">
	<!-- Ausgabe des Kontinents mit Daten -->
    <img id="navigationBild" src="img/kategorie/<?php echo $kon["bild"]; ?>" style=" width:
	<?php 
	if($kon["name"] == "Afrika" || $kon["name"] == "S&uuml;damerika")
		{ echo "229px !important";} 
	else if($kon["name"] == "Europa" || $kon["name"] == "Nordamerika")
		{ echo "360px";} 
	else if($kon["name"] == "Asien" || $kon["name"] == "Mittelamerika")
	{ echo "340px";}
	else if($kon["name"] == "Antarktis" || $kon["name"] == "Pazifik" || $kon["name"] == "Arktis")
	{ echo "320px";}
	else if($kon["name"] == "Orient")
	{ echo "270px";}
	?>; float:right; margin-top: 2em; margin-right: 15px"/>
    
    <div id="kontinentInformation">
    	<h2><?php echo $kon["name"]; ?></h2>
    	<p><span>Fläche:</span><br/><?php echo utf8_encode($kon["flaeche"]); ?></p>
        <p><span>Gliederung:</span><br/><?php echo utf8_encode($kon["gliederung"]); ?></p>
        <p><span>Tourismus:</span><br/><?php echo utf8_encode($kon["tourismus"]); ?></p>
        <p><span>Klima/Reisezeit:</span><br/><?php echo utf8_encode($kon["klima"]); ?></p>
    </div> <!-- #kontinentInformation -->
</div>
<div class="clear"></div>