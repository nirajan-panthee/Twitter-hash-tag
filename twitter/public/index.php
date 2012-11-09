<!DOCTYPE html>
<html lang="eng">

	<head>
		<meta charset='utf-8' />
		<meta http-equiv="X-UA-Compatible" content="chrome=1" />
		<meta name="description" content="Codaslider : JQuery Slider Plugin" />
		
		
		<link rel="stylesheet" type="text/css" media="screen" href="./css/coda-slider.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/index.css">
		
		<script src="./js/jquery-1.7.2.min.js"></script>
		<script src="./js/jquery-ui-1.8.20.custom.min.js"></script>
		<script src="./js/jquery.coda-slider-3.0.js"></script>
		
		<link rel="stylesheet" href="css/jquery-ui-1.8.22.custom.css">

	
	<script type="text/javascript" src="js/ui.min.js"></script>
	<script type="text/javascript">
	

</script>
		<?php
			if(isset($_GET['panel'])){
				$panel=$_GET['panel'];
			}
			else{
				$panel=1;
			}
		?>
	
		<?php 
			if(isset($_GET['query'])){ 
				$query=$_GET['query'];
				
			} 
		?>
	 
		<script type="text/javascript">
				var title=<?php echo $panel;?>;
				var check='active';
		</script>
		<script src="js/index.js"></script>
	
		
	</head>
	
	<body>
	
	
		<div class="header" >
			<div class="logo">
				<a href="index.php">
					<h2>
						<img src="img/twitter.png" alt="<h6>twitter logo<h6>"  />Twitter # Tag
					</h2>
				</a>
			</div>
		
			<div class="search">
				<form id="tw-form" action="index.php" method="post" onsubmit="return searchbyhash()" name="search">
					<input id="tw-input-text" type="text" name="query"  placeholder="Search" />
					<input id="tw-input-submit" type="submit" value="" />
				</form>
			</div>
		</div>
	
		<div class="content" >
	
	
	
		<?php
	
			require 'connection.php';
	
			
	
		?>
	
		
		
			<div class="clearfix" id="bodywraper" >

				<div class="coda-slider" id="slider-id">
				<?php
					$hashtag=mysql_query("SELECT HashTag FROM infomax WHERE Active='1' ORDER BY HashTag");
					$notags=mysql_num_rows($hashtag);
					$i=0;
					$j=1;
	

					while($info=mysql_fetch_array($hashtag)) {
							$hash=$info['HashTag'];
							$hashcount=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash'"));
						if(($i%12)==0) {

							echo "<div>"; 
							echo "<h2 class='title'>".$j."</h2>";
							$j++;
				
						}
			
			
			
				?>
					<div class="hash" align="center" id="<?php echo $hash;?>">
					<?php 
						if($hashcount['0']==0){
					?>
							<a onclick="notweet()" ><h3 style="color:#0088CC"><?php echo $hash; ?> </h3></a><p><?php echo "(".$hashcount['0'].")";?> </p>
					<?php
						} else { 
					?>
							<a href="<?php echo "hashtag.php?hash=".urlencode($hash);  ?>"><h3 style="color:#0088CC"><?php echo $hash; ?> </h3></a><p ><?php echo "(".$hashcount['0'].")"; ?></p>
			
					<?php 
							} 
					?>
				
				
			
					</div>
			
				<?php 
						$i++;
						if(($i%12)==0){
							echo "</div>"; 
						}
						if($i==$notags){
							echo "</div>"; 
						}
					}
					mysql_close($con);
				?>
			
				</div>
		
	
		
		
			</div>
		
	
			<script type="text/javascript">
				var query = '<?php echo "#".$query; ?>' ;
				document.getElementById(query).style.backgroundColor = '#32ffcc';
			</script>
	
	</body>
</html>