<!DOCTYPE html>
<html lang="eng">

	<head>
		<meta charset='utf-8' />
		<meta http-equiv="X-UA-Compatible" content="chrome=1" />
		<meta name="description" content="Codaslider : JQuery Slider Plugin" />
		
		<link rel="stylesheet" href="css/bootstrap.css">
		
		<link rel="stylesheet" type="text/css" media="screen" href="./css/coda-slider.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="css/jquery-ui-1.8.22.custom.css">

		
		
		<script src="./js/jquery-1.7.2.min.js"></script>
		<script src="./js/jquery-ui-1.8.20.custom.min.js"></script>
		<script src="./js/jquery.coda-slider-3.0.js"></script>
		<script type="text/javascript" src="js/ui.min.js"></script>
		<?php
			if(isset($_GET['panel'])){
				$panel=$_GET['panel'];
			}
			else{
				$panel=1;
			}
		 
			if(isset($_GET['query'])){ 
				$query=$_GET['query'];
				//echo $query;
			} 
		?>
	 
		
		<script type="text/javascript">
				var title=<?php echo $panel;?>;
				var check='active';
				
				$(function() {
		
			
					$.ajax({
							url: "auto.php?active=true" ,
						success: function(value) {
							if(value){
									var tags=$.parseJSON(value);
								$( "#tw-input-text" ).autocomplete({
									source: tags
								});
							}
						}
					});
	
		
				});
		</script>
		<script src="js/index.js"></script>
	
		
	</head>
	
	<body>
	
	
		<div class="header">
			<div class="logo">
				<a href="index.php" >
					<h2 style="color:#FFFFFF">
						<img src="img/twitter.png" style="width:20px;height:20px;" alt="<h6>twitter logo<h6>" />Twitter # Tag
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
	
		<div class="content">
			<div class="add-wrap">
				<div class="add" style="box-shadow:0 0 15px black">
      	
					<form id="addnewtag" action="index.php" method="POST" onsubmit="return addHash(this.name)" name="newHash">
						<label><h2>Add New # Tag</h2></label>
						<input type="text" name="hashtag" placeholder="Type New # Tag to Add in list...">
						<button type="submit" class="btn" name="newtag" ><b>Submit</b></button>
					</form> <?php
					
	
					require 'connection.php';
	
					
	
					if(isset($_POST['hashtag'])&& isset($_POST['newtag'])){
			
							$hash=mysql_real_escape_string(strtolower($_POST['hashtag']));
							$chk_dec=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$hash' AND Active='0'"));
			
							$check=str_split($hash,1);
							$chk_hash=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$hash' AND Active='1'"));
		
						if($chk_hash['0']==$hash){ ?>
			
							<p id="message" ><b>The HashTag <?php echo $hash; ?> has been already Added</b></p> <?php
						}
						else if($chk_dec['0']==$hash){ ?>
			
								<p><b>The HashTag <?php echo $hash; ?> 
									has been already Added and is deactive if you like to activate press the button below</b></p>
			
								<form id="suggest" method="POST" action="index.php">
									<input type="hidden" name="hash" value="<?php echo $hash; ?>">	
									<input type="submit" class="btn" name="activate" value="" title="Activate the HashTag">
								</form> <?php
						} 
						else {
							if($check[0]=='#'){
			
								mysql_query("INSERT INTO infomax (HashTag) VALUES ('$hash')"); ?>
								
								<p id="message"><b>The HashTag <?php echo $hash; ?> has been Added</b></p> <?php
							}	
						}
	
					}
					
					$result=mysql_query("SELECT HashTag FROM infomax");
						while($tag=mysql_fetch_array($result)){
								$hash_tag=mysql_real_escape_string(strtolower($tag['HashTag']));
			
							if(isset($_POST['deact'])){
								if($_POST['hash']==$hash_tag){
			
									mysql_query("UPDATE infomax SET Active = '0' WHERE HashTag='$hash_tag'");?>
					
									<p id="message"><b>The HashTag <?php echo $hash_tag; ?> has been deactivated</b></p> <?php
								}
							}

							if(isset($_POST['activate'])){
				
								if($_POST['hash']==$hash_tag){
			
								mysql_query("UPDATE infomax SET Active = '1' WHERE HashTag='$hash_tag'"); ?>
					
								<p id="message"><b>The HashTag <?php echo $hash_tag; ?> has been activated<b></p> <?php
								}	
							} 
			
							if(isset($_POST['delete'])){
								if($_POST['hash']==$hash_tag){
					
									$backup=mysql_query("SELECT * FROM infomax WHERE HashTag='$hash_tag'");
									$back_up=mysql_query("SELECT * FROM infotweets WHERE HashTag='$hash_tag'");

									$filename = "backup/"."infomax_".$hash_tag.".csv";
									$file_name = "backup/"."infotweets_".$hash_tag.".csv";
	
									$handle1 = fopen($filename, 'w+');
									$handle2 = fopen($file_name, 'w+');
	
									while ($row = mysql_fetch_assoc($backup)) fputcsv($handle1, $row);
									while ($row = mysql_fetch_assoc($back_up)) fputcsv($handle2, $row);

									fclose($handle1);
									fclose($handle2);
					
									mysql_query("DELETE FROM infomax WHERE HashTag='$hash_tag'");
									mysql_query("DELETE FROM infotweets WHERE HashTag='$hash_tag'"); ?>
									<p id="message"><b>The HashTag <?php echo $hash_tag; ?> has been deleted</b></p> <?php
								}
							}
			
						} ?>
	
				</div>
			</div>
		
			<div class="clearfix" id="bodywraper" style="box-shadow:0 0 15px black">
				<div class="menu">
					<div id="deactive">
						<a href="deactivated.php">
							<b>View Deactive</b>
						</a>
					</div>
					<div id="active">
						<a href="index.php">
							<b>View Active</b>
						</a>
					</div>

				</div>
		
				<div class="coda-slider" id="slider-id"> <?php
		
					$hashtag=mysql_query("SELECT HashTag FROM infomax WHERE Active='1' ORDER BY HashTag");
					$notags=mysql_num_rows($hashtag);
					$i=0;
					$j=1;
	

					while($info=mysql_fetch_array($hashtag)) {
							$hash=$info['HashTag'];
							$hashcount=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash'"));
						if(($i%9)==0) {

								echo "<div>"; 
								echo "<h2 class='title'>".$j."</h2>";
								$j++;
				
						} ?>
						
						<div class="hash" align="center" id="<?php echo $hash;?>"> <?php 
			
							if($hashcount['0']==0){ ?>
				
									<a onclick="notweet()" ><h3><?php echo $hash; ?> </h3></a><p style=""><?php echo "(".$hashcount['0'].")";?> </p> <?php
									
							} 
							else { ?>
			
								<a href="<?php echo "hashtag.php?hash=".urlencode($hash);  ?>"><h3><?php echo $hash; ?> </h3></a><p style=""><?php echo "(".$hashcount['0'].")"; ?></p> <?php
								
							} ?>
				
							<form method="POST" action="index.php">
								<input type="hidden" name="hash" value="<?php echo $hash; ?>">
								<a href="<?php echo "csv.php?hash=".urlencode($hash); ?>" title="Download as csv File" ><button  type="button" value="" class="btn" id="csv"></button></a>
								<input type="submit" id="deac" class="btn" name="deact" value="" title="Deactivate the HashTag">
								<input id="delete" type="submit" class="btn" title="Delete the hashtag" name="delete" value=""  onclick="return deleteHash()">
					
							</form>
				
			
						</div> <?php 
							
							$i++;
			
							if(($i%9)==0) {
									echo "</div>"; 
							}
			
							if($i==$notags) {
									echo "</div>"; 
							}
					} 
					
					mysql_close($con);?>
			
			
			
			
				</div>
		
	
		
		
			</div>
		
	
			<script type="text/javascript">
				var query = '<?php echo "#".$query; ?>' ;
				document.getElementById(query).style.backgroundColor = '#32ffcc';
			</script>
	
	</body>
</html>