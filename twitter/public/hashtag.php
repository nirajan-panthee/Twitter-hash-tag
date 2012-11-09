<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
						if(isset($_GET['hash'])){
								$url="&a";
								$input=$_GET['hash'];
								$user_query="";
								$userID="";
							if(isset($_GET['user'])){
								$user_query="AND UserID='".$_GET['user']."'";
								$userID="@".$_GET['user'];
								$url="&user=".$_GET['user'];
							}
							$date_query="";
							if(isset($_GET['year'])&&!isset($_GET['month'])){
									$date_query="AND FROM_UNIXTIME(DATETIME,'%Y')='".$_GET['year']."'";
									$url=$url="&year=".$_GET['year'];
						
							}else if(isset($_GET['year'])&&isset($_GET['month'])){
									$dateandmonth=$_GET['year'].",".$_GET['month'];
									$date_query="AND FROM_UNIXTIME(DATETIME,'%Y,%b')='".$dateandmonth."'";
									$url="&year=".$_GET['year']."&month=".$_GET['month'];
							}
						}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Hash Tag</title>
		<meta http-equiv="Content-Type" content="text/html; charset= utf-8">
		
		<link rel="stylesheet" href="css/custom_hash.css">
		<link rel="stylesheet" href="css/hashtag.css">
		
		<script type="text/javascript" src="js/jquery-latest.js"></script>
		
		
		<script type="text/javascript">
			
			var hashtag='<?php echo urlencode($_GET['hash']); ?>';	
		
		
		
		
						var link='<?php echo $url; ?>';
		
					
					</script>
					<script type="text/javascript" src="js/hashtag.js"></script>
		
	</head>

	<body>
		<div  class="head" style="z-index:33">  
			<a href="index.php">
				<h2>
					<img src="img/twitter.png"  alt="twitter logo"  />Twitter # Tag
				</h2>
			</a>

		</div></br></br>


	<?php 
		require 'connection.php';
		
		
		if(isset($_GET['hash'])) {
				$check = str_split($_GET['hash']);

			if($check['0']=='#') {

				
	?>


				<div class="container" >

					<div class="right" >


					<?php
						
						
						
					
					
						 
						
						$tweet_no=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$input' $user_query $date_query"));
						$new=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$input'"));
						$view=mysql_fetch_array(mysql_query("SELECT View FROM infomax WHERE HashTag='$input'"));
						$view_num=$view['View']+1;
						mysql_query("UPDATE infomax SET View = $view_num WHERE HashTag='$input'");
					?>
					





						<div class="tbl">
							<div><?php include 'bar_graph.php'; ?></div>

							<h3>List of All # Tag 
								<input type="text" id="search" placeholder="search"  />
							</h3>

							<table class="table-striped" id="tblS" cellpadding="5px" >
	
								<thead>
									<tr >
										<th align="left" style="background-position:center;" onclick="sort(0)">Hashtag</th>
										<th align="center"  onclick="sort(1)">Count</th>
										<th align="center"  onclick="sort(2)" >View</th>
			
									</tr>
								</thead>
								<tbody id="data">
  
								<?php
									$hashtag=mysql_query("SELECT HashTag FROM infomax  WHERE Active='1' ORDER BY HashTag");
	
									while($info=mysql_fetch_array($hashtag)) {
											$hash=$info['HashTag'];
											$hashcount=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash'"));
											$visited=mysql_fetch_array(mysql_query("SELECT View FROM infomax WHERE HashTag='$hash' ORDER BY View"));
										if($hashcount['0']==0){
			
								?>
										<tr>
											<td ><a onclick="notweet()" ><b style="color:#0088cc"><?php echo $hash; ?></b></a></td>
											<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
											<td align="right"><b><?php echo $visited['View']; ?></b></td>
										</tr>
								<?php 
										} else { 
								?>
												<tr>
													<td><a href="<?php echo "hashtag.php?hash=".urlencode($hash); ?>"><b style="color:#0088cc"><?php echo $hash; ?></b></a></td>
													<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
													<td align="right"><b><?php echo $visited['View']; ?></b></td>
												</tr>
								<?php
 
												}
									}	
		
								?>
								</tbody>
							</table>
							</br>
						</div>
					</div>


					<div class="info" >
						<div class="clearfix" id="bodywraper">
							<div class="count">
								<h2>
									<?php 
									
									
									echo "<a href='hashtag.php?hash=".urlencode($_GET['hash'])."'>".$_GET['hash']."</a> " ?>
								</h2>
								
								<h4>
								<?php echo $userID; ?>
								</h4>

								<h6>
									<?php echo $tweet_no['0']." "; ?> tweets Available
								</h6>
								
							</div>
							<div class="update">
							<?php 
 
								if($new==0){
									header("Location: https://twitter.com/search/".urlencode($_GET['hash']));
								} else { 

							?>
								<h6 align="right" title="json format" >
									<a href="tweetapi.php?hash=<?php echo urlencode($input); ?>" target="_blank">Json</a>
								</h6>
								<h6 id="hover" align="right" title="embed code"  >Embed</h6>
								
								
								<a href="csv.php?hash=<?php echo urlencode($_GET['hash']); ?>"><button value="" title="download as CSV" style="background-image:url(img/download.png);width:25px;height:25px;border-radius:5px;cursor:pointer"></button></a>
								
	
								<div id="embed" style="z-index:3" >
									<b>&lt;iframe width="460" height="315" src="http://localhost/Twitter-hash-tag/twitter/public/embeded.php?hash=<?php echo urlencode($_GET['hash']); ?>&num=5"
									frameborder="0" allowfullscreen>&lt;/iframe&gt;</b>
								</div>
							</div>
							<?php include 'graph.php'; ?>
						</div>
						
					</div>
					
					<div id="postedComments" >

						<table class="table-striped" bordercolor="#FFFFFF" border="1" cellpadding="5px">
						<?php 
			
							$hash = mysql_real_escape_string(strtolower($_GET['hash']));
							
							$result = mysql_query("SELECT UserName,UserID,Tweets,DateTime,image FROM infotweets WHERE HashTag='$hash' $user_query $date_query ORDER BY TweetID DESC LIMIT 0,20");
							$i=1;
							while($row = mysql_fetch_array($result)){   
		
								$tweet=get_link($row['Tweets']);
							?>		
	
								<tr class='postedComment' id="<?php echo $i; ?>">
									<td width="200px">
										<div style="display:inline;float:left;margin:5px;">
											<img src="<?php echo $row['image'] ?>"/>
										</div>
										<div style="padding:5px">
											<b><?php echo "@".$row['UserID'];?></b>
										</div>
									</td>
			
									<td>
										<b style="display:inline"><?php echo $row['UserName']; ?></b>
										<?php 
											$time=(int)$row['DateTime']+20700; 
										?>
			
										<p style="font-size:10px;float:right"><?php echo Date('H:m:s D,d M Y',$time); ?></p>
										<p><?php echo $tweet."<br/>"; ?></p>
									</td>
									
								</tr>
								
	
	

						<?php 
								$i++; 		
							}   
						?>
						</table>
						<br/>
	
					</div>
					<div id="loadMoreComments"> 
						<center>
							<p>loading...</p>
							<img src="img/loading31.gif"/>
						</center>
					</div>

	<?php
										} 
			} 
		}
		mysql_close($con);
	?>

				</div>

<?php 

	function get_link($string){

			$str = preg_split('/ /', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

		foreach($str as $cha){

				$hash=str_split($cha['0']);
				$len=count($hash);
			if($len>=4){
				
					$http=$hash['0'].$hash['1'].$hash['2'].$hash['3'];
			
				if($http=='http'){
					$hp[]=$cha['0'];

				}
			}

			if ($hash['0']=='#'){
				$hash_tag[]=$cha['0'];
			}

			if($hash['0']=='@'){
				$user[]=$cha['0'];
		
			}

		}

		if(isset($hash_tag)){
			foreach($hash_tag as $lk){
				$link= "<a target='_blank' href=hashtag.php?hash=".urlencode($lk).">".$lk."</a>";
				$string=str_replace($lk,$link,$string);
			}
		}
		if(isset($hp)){
			foreach($hp as $lk2){
				$link2= "<a target='_blank' href=".$lk2. " >".$lk2."</a>"; 
				$string=str_replace($lk2,$link2,$string); 
			}
		}
		if(isset($user)){
			foreach($user as $lk3){
				$link3="<a target='_blank' href=https://twitter.com/search/".urlencode($lk3).">".$lk3 ."</a>"; 
				$string=str_replace($lk3,$link3,$string);
		
			}
		}
	
		return $string;
	}

?>

<script type="text/javascript" src="js/jquery.tablesorter.js"></script>

</body>
</html>