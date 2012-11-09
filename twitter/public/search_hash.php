<?php
	
	require 'connection.php';
	
	if(isset($_GET['search'])){
			$search="#".$_GET['search'];
			$hashtag=mysql_query("SELECT HashTag FROM infomax  WHERE Active='1'  AND HashTag LIKE '$search%' ORDER BY HashTag");
	
		while($info=mysql_fetch_array($hashtag)) {
				$hash=$info['HashTag'];
				$hashcount=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash'"));
				$visited=mysql_fetch_array(mysql_query("SELECT View FROM infomax WHERE HashTag='$hash'"));
			if($hashcount['0']==0){
			
?>
				<tr class="q">
					<td ><a onclick="notweet()" ><b style="color:#0088cc"><?php echo $hash; ?></b></a></td>
						<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
						<td align="right"><b><?php echo $visited['View']; ?></b></td>
				</tr>
		<?php 
			} else { 
		?>
					<tr class="q">
						<td><a href="<?php echo "hashtag.php?hash=".urlencode($hash); ?>"><b style="color:#0088cc"><?php echo $hash; ?></b></a></td>
						<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
						<td align="right"><b><?php echo $visited['View']; ?></b></td>
					</tr>
		<?php
					}
		}	
		

		
	}


?>