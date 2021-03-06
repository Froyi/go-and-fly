	<div id="footer"> 
    	<div class="container">
            <div>
                <img src="img/dieter_rosenbusch.png" />
                <div>
                    <h3>Dieter Rosenbusch</h3>
                    <p>ist Inhaber der Firma GO and Fly, die seit 1992 besteht und mit seiner Frau Renate geführt wird. </p>
                </div>
                <p class="clear"></p>
                 <ul>
                    <li><a href="ueber_uns.php">Über Uns</a></li>
                    <li><a href="partner.php">Partner</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="impressum.php">Impressum</a></li>
                </ul>
            </div> <!-- Rosenbusch -->
            <div class="line"></div>
            
            <div id="kontaktform">
            <h3>Kontaktformular</h3>
            <form name="kontakt" method="post" action="inc.php/mail.sc.php">
                <input type="text" name="name" required placeholder="Name"><br/>
                <input type="email" name="email" required placeholder="E-Mail"><br/>
                <textarea name="nachricht" placeholder="Nachricht" required></textarea><br/>
                <input type="hidden" name="seite" value="<?php echo $seite; ?>">
                <input type="submit" name="submit" value="Senden">
                <input type="hidden" name="footerForm" value="true" />
            </form>
            <?php
			if(isset($_GET["sendmail"]) && $_GET["sendmail"] == "true")
			{
				echo "<p>Vielen Dank für Ihr Interesse, wir werden uns bei Ihnen melden.</p>";
			}
			?>
            </div> <!-- Kontakt -->
            <div class="line"></div>
            
            <div id="partner_footer">
                <h3>Unsere Partner - hier online buchbar!</h3>
                <div class="left">
                	<a href="http://www.studiosus.com/?agnr=71043">Studienreisen:<br/> <img src="img/partner/studiosus.png" /></a>
                </div>
                <div class="left">
                	<a href="http://www.chamaeleon-reisen.de/?anr=106549">Kleingruppen: <br/><img src="img/partner/chamaeleon.png" /></a>
                </div>
                <div class="left">
                <!--<a href="http://www.portfolio-ms.de"><img src="img/partner/ms.png" /></a>-->
				<a href="https://www.diamir.de?agnr=35647">Aktivreisen:<br/> <img src="img/partner/diamir.jpg" /></a>
                </div>
                <div class="left">
                <a href="http://goandfly-bus.blueandwhite.de/">Bus/Flug:<br/> <img src="img/partner/bw.png" id="bw" /></a>
                </div>
                <p class="clear"></p>
				<div class="fb-like" data-href="https://www.facebook.com/goandflyhalle" data-width="150" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>    
                </div> <!-- Partner & 2nd Navigation -->
        </div> <!-- .container -->
        <p class="clear"></p>
    </div> <!-- #footer -->
</div> <!-- #wrapper -->
<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>-->
<script src="js/jquery.pageslide.min.js" type="text/javascript"></script>
<script src="js/xmlhttprequestobjekt.js" language="JavaScript" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
	});
</script>
<script type="text/javascript" src="js/behavior.js"></script>
<script type="text/javascript">
	$(".open").pageslide();
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46208813-1', 'go-and-fly.de');
  ga('send', 'pageview');

</script>
</body>
</html>