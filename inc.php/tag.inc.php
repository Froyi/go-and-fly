<?php
// Tags werden ausgegeben
?>
<?php

// Tags aus der Datenbank holen
$tags = holeTag();

// gibts ne re_id?
if(isset($_GET["re_id"]) && $_GET["re_id"] > 0)
{
	$re_id = $_GET["re_id"];
}
else
{
	$re_id = 0;
}

?>

<!-- Ausgabe der Tags -->
<div id="tagListe">
    <table>
    <?php
	$counter = 0;
	while($tag = mysql_fetch_assoc($tags))
	{
		if($counter == 7)
		{
			echo "</tr>";
		}
		if($counter == 0)
		{
			?>
			<tr>
				<td id="<?php echo "tag".$tag["id"]; ?>" 
				<?php if($tag["id"] != 7){?> 
                	onClick="tags('<?php echo $tag["id"]; ?>', '<?php echo $re_id; ?>')" 
				<?php } ?>
                ><?php if($tag["id"] == 7){?><a href="http://goandfly-bus.blueandwhite.de/"><?php } ?><?php echo $tag["name"]; ?><?php if($tag["id"] == 7){?></a><?php } ?></td>
			<?php
		}
		else
		{
			?>
			<td id="<?php echo "tag".$tag["id"]; ?>"
			<?php if($tag["id"] != 7){?>  
            	onClick="tags('<?php echo $tag["id"]; ?>', '<?php echo $re_id; ?>')"
			<?php } ?>
            ><?php if($tag["id"] == 7){?><a href="http://goandfly-bus.blueandwhite.de/"><?php } ?><?php echo $tag["name"]; ?><?php if($tag["id"] == 7){?></a><?php } ?></td>
			<?php
		}
		?>
	<?php 
	$counter ++;
	} // while ?>
    </table>
	</ul>
</div> <!-- #tagListe --> 