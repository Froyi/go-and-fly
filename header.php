<?php include("inc.php/functions.inc.php"); ?>
<?php 
$tagL = "";
$tagCounter = 1;
if(isset($_SESSION["tagListe"]) && !empty($_SESSION["tagListe"]))
	{
		/*var_dump($_SESSION["tagListe"]);*/
		foreach($_SESSION["tagListe"] as $value)
		{
			if($value == 1)
			{
				$tagL .= "1,";
			}
			else
			{
				if($tagCounter != 12)
				{
					$tagL.=",";
				}
			}
			$tagCounter ++;
		}		
	}
	/*var_dump($tagL);
	echo "</br>";*/
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6 ie"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 ie"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 ie"> <![endif]-->
<!--[if IE 9 ]>    <html class="no-js ie9 ie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=0.67, maximum-scale=1.0" />
<title><?php echo $seitentitel; ?></title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<script src="js/jquerymin1.6.1.js"></script>
<script src="js/jquery.pageslide.min.js" type="text/javascript"></script>
<script src="js/xmlhttprequestobjekt.js" language="JavaScript" type="text/javascript"></script>

<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<script src="ckeditor/ckeditor.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
		CKEDITOR.replace( 'editorCKE' );
		CKEDITOR.replace( 'editorCKE2' );
		CKEDITOR.replace( 'editorCKE3' );
		
		
	});
</script>
</head>
<body <?php if($seite == "index.php"){ ?>onLoad="tagList('<?php echo $tagL; ?>')" <?php } ?>>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1&appId=292092680810799";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="wrapper">
	<div id="header">
    	<div class="container">
        	<!-- Menü -->
            <a class="open" href="#nav"><img src="img/nav_world.png"  /></a>
            <img id="menueBig" src="img/globus.png"  onClick="toggleMenue();" />
            
            <!-- Logo -->
            <div id="logo">
                <a href="index.php"><img src="img/logo_smartphone.png"/></a> 
                <p>Mit uns fliegen Sie raus ...</p>
            </div> <!-- #logo -->
            <div id="logo_big" class="left">
            	<a href="index.php"><img src="img/logo.jpg"/></a>
            </div> <!-- #logo_big -->
            
            <!-- Hotline -->
            <div id="hotline" class="right">
            	<img src="img/hotline.png" />
            </div>
            <p class="clear"></p>
            
            <!-- Navigation small -->
            <div id="navigation">
        		<div id="nav">
                	<?php 
					// Kontinente holen
					$ko = holeKontinente();
					while ($kontinente = mysql_fetch_assoc($ko))
					{
					?>
                    <div class="kontinent">
                    <a href="index.php?konti_id=<?php echo $kontinente["id"]; ?>"><img src="img/smartphone/kontinente/<?php echo $kontinente["bild"]; ?>" width="220"/></a>
                    <table width="200">
                    	<?php 
						// Regionen holen
						$count_re = 0;
						$re = holeRegionen($kontinente["id"]);
						while ($regionen = mysql_fetch_assoc($re))
						{
							if($count_re % 2 == 0)
							{
								// gerade Anzahl an Elementen
								echo "<tr>";
								
							}
						?>
                        <td><a href="index.php?re_id=<?php echo $regionen["id"]; ?>"><?php echo $regionen["titel"]; ?></a></td>                       	
                        
                        <?php 
						if($count_re % 2 != 0)
						{
							// gerade Anzahl an Elementen
							echo "</tr>";
						
						}
						$count_re ++;
						} // while() Regionen ?>
                        </tr>
                    </table>
                    </div> <!-- .kontinent -->
					<?php } // while() Kontinente ?>
                </div> <!-- #nav -->
        	</div> <!-- #navigation -->
        </div> <!-- .container -->
    </div> <!-- #header -->
        <div id="teaser">
        	<!-- Navigation big -->
            <div id="navigationBig">
            	<div class="left">
				<?php 
					// Kontinente holen
					$ko = holeKontinente();
					while ($kontinente = mysql_fetch_assoc($ko))
					{
				?>
                	<p onClick="toggleRegionen('<?php echo $kontinente["id"]; ?>');" onMouseOver="toggleKontinent('<?php echo $kontinente["bild"]; ?>');" id="<?php echo "kontinent_".$kontinente["id"]; ?>"><?php echo $kontinente["name"]; ?></p>
                <?php
					} // while()
				?>
                </div> <!-- .left -->
                
                <div id="regionenAusgabe" class="left">
                	<!-- Platzhalter Welt einfügen -->
                    <img src="img/kategorie/world.png" width="800" style="margin-top:71px;" id="world_map" />
                </div> <!-- #regionenAusgabe -->
            </div> <!-- #navigationBig --> 
            
            <?php
			// randomisierte Ausgabe der Reisen
			$anzahlReisen = anzahlTeaserReisen();
			?>            
            <div id="teaserRightBar">   
            	<?php
				// hier sollen die drei anderen Reisen ausgegeben werden
				
				?>   
      		</div> <!-- #teaserRightBar -->
            <?php 
			if($seite == "index.php")
			{
				// holen der Reise, welche ausgegeben wird (INDEX)
				$reiseTeaser = reiseRandomTeaser($anzahlReisen); 
			?>
        		<img src="img/<?php echo $reiseTeaser["pfad"]; ?>" />
            <?php 
			} 
			else if($seite == "reise.php" && isset($_GET["re_id"]))
			{
				// hole reiseteaser
				$reiseTeaser = holeReise($_GET["re_id"]);
			?>
            	<img src="img/reise/<?php echo $reiseTeaser["teaser"]; ?>" />
            <?php } 
			else if($seite == "partner.php" || $seite == "ueber_uns.php" || $seite == "kontakt.php" || $seite == "impressum.php" || $seite = "login.php" )
			{ ?>
				<img src="img/partner_teaser.jpg"/>
			<?php 
			}
			?>
        </div> <!-- #teaser -->  
        <?php 
			// Wenn es die Indexseite ist, sollen Tags ausgegeben werden 
			if($seite == "index.php") include("inc.php/tag.inc.php"); 
		?>
    	
        
   