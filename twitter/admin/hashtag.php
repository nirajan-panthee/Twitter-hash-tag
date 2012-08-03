<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset= utf-8">
		
		<link rel="stylesheet" href="css/bootstrap.css">
		
		<link rel="stylesheet" href="css/hashtag.css">

		<script type="text/javascript" src="js/jquery-latest.js"></script> 
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript">

			var hashtag='<?php echo urlencode($_GET['hash']); ?>';	
		</script>
		<script type="text/javascript" src="js/hashtag.js"></script>

	</head>

	<body>
		<div  class="head">  
			<a href="index.php">
				<h2>
					<img src="img/Capture.jpg"  alt="twitter logo" />Twitter # Tag
				</h2>
			</a>

		</div></br></br>


		<?php 
			require 'connection.php';
			
			

			if(isset($_GET['hash'])) {

					$check = str_split($_GET['hash']);

				if($check['0']=='#') {

					if(isset($_POST['hashtag'])&& isset($_POST['newtag'])){
			
							$hash=mysql_real_escape_string(strtolower($_POST['hashtag']));
							$chk_dec=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$hash' AND Active='0'"));
			
							$check=str_split($hash,1);
							$chk_hash=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$hash' AND Active='1'"));
		
						if($chk_hash['0']==$hash){ ?>
			
							<p id="message"><b>The HashTag <?php echo $hash; ?> has been already Added</b></p> <?php
		
						}
						else if($chk_dec['0']==$hash){ ?>
			
							<p id="suggest"><b>The HashTag <?php echo $hash; ?> 
								has been already Added and is deactive if you like to activate press the button below</b>
			
								<form method="POST" action="index.php" style="margin-left:406px;background-color:#FFFFFF;width:300px;padding-left:150px">
									<input type="hidden" name="hash" value="<?php echo $hash; ?>">	
									<input type="submit" class="btn" name="activate" value="" style="background-image:url(img/activate.png);height:23px;background-repeat:no-repeat;" title="Activate the HashTag">
								</form>
							</p> <?php
						} 
		
						else{
							if($check[0]=='#'){
			
								mysql_query("INSERT INTO infomax (HashTag) VALUES ('$hash')"); ?>
					
								<p id="message"><b>The HashTag <?php echo $hash; ?> has been Added</b></p> <?php
							}
						}
					} ?>


		<div class="container">

			<div class="right">
				<div class="add">
					<form id="addnewtag" action="hashtag.php?hash=<?php echo urlencode($_GET['hash']); ?>" method="POST" onsubmit="return addHash(this.name)" name="newHash" >
						<input type="text" name="hashtag" placeholder="Type New # Tag to Add in list..." style="">
						<button type="submit" class="btn btn-info"  name="newtag"  ><b>Add</b></button>
					</form> <?php
					
					$input=$_GET['hash']; 
					$tweet_no=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$input'"));
	
					$new=mysql_fetch_array(mysql_query("SELECT HashTag FROM infomax WHERE HashTag='$input'"));
					$view=mysql_fetch_array(mysql_query("SELECT View FROM infomax WHERE HashTag='$input'"));
	
					$view_num=$view['View']+1;
					mysql_query("UPDATE infomax SET View = $view_num WHERE HashTag='$input'"); ?>



				</div>


				<div class="tbl">

					<h3>
						List of All # Tag 
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
					
						<tbody id="data"> <?php
					
							$hashtag=mysql_query("SELECT HashTag FROM infomax ORDER BY HashTag");
	
							while($info=mysql_fetch_array($hashtag)) {
			
									$hash=$info['HashTag'];
									$hashcount=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash'"));
									$visited=mysql_fetch_array(mysql_query("SELECT View FROM infomax WHERE HashTag='$hash' ORDER BY View"));
								if($hashcount['0']==0){ ?>

									<tr>
										<td><a onclick="notweet()" ><b><?php echo $hash; ?></b></a></td>
										<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
										<td align="right"><b><?php echo $visited['View']; ?></b></td>
									</tr><?php 
							
								} 
								else { ?>
							
									<tr>
										<td><a href="<?php echo "hashtag.php?hash=".urlencode($hash); ?>""><b><?php echo $hash; ?></b></a></td>
										<td align="right"><b><?php echo $hashcount['0']; ?></b></td>
										<td align="right"><b><?php echo $visited['View']; ?></b></td>
									</tr> <?php
 
								}
							} ?>
						
						</tbody>
					</table>
					</br>
				</div>
			</div>





			<div class="info" style="">
				<div class="clearfix" id="bodywraper">
					<div class="count" style="">	
						<h2><?php echo $_GET['hash']; ?></h2>
						<h6><?php echo $tweet_no['0']." "; ?> tweets Available</h6>
					</div>
		
					<div class="update"> <?php 
 
						if($new==0){
								echo "<h4 style='color:#CC6C66;'>The hash tag entered is not available if you like to add press the add buttom below.</h4>"; ?>

								<h4 style="color:#CC6C66">Welcome to Twitter # Tag.</h4>
								<h5 style="color:#C6C6C6">Find out <?php echo "what's"; ?> happening, right now, with the people and organizations you care about.</h5>
						
								<form action="index.php" method="POST" style="margin-left:300px;margin-top:20px" >
									<input type="hidden" name="hashtag" value="<?php echo $_GET['hash']; ?>" >
									<input type="submit" class="btn btn-info" value="add" name="newtag">
								</form>


					</div> <?php
					
						} 
						else { ?>
						
							<h6 align="right" title="json format" ><a href="tweetapi.php?hash=<?php echo urlencode($input); ?>">Json</a></h6>

							<form method="POST" action="index.php" style="margin:10px 0 0 100px">
								<input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
								<a  href="<?php echo "csv.php?hash=".urlencode($_GET['hash']); ?>" title="Download as csv File">
									<input type="submit" value="" class="btn" style="background-image:url(img/download.png);height:23px">
								</a> <?php

								
									$test=mysql_fetch_array(mysql_query("SELECT Active FROM infomax WHERE HashTag='$input'"));
					
								if($test['0']==1){ ?>
					
					
									<input type="submit" class="btn" name="deact" value="" style="background-image:url(img/dactivate.png);background-repeat:no-repeat;height:23px;" title="Deactivate the HashTag" formaction="deactivated.php" formmethod="POST"> <?php  
									
								} 
								else {   ?>
					
									<input type="submit" class="btn" name="activate" value="" style="background-image:url(img/activate.png);height:23px;background-repeat:no-repeat;" title="Activate the HashTag"> <?php 
									
								} ?>
					
								<input type="submit" class="btn" title="Delete the hashtag" name="delete" value=""  onclick="return deleteHash()" style="background-image:url(img/delete.png);height:23px">
					
							</form>
				</div>
			</div>
		</div>
		
		<div id="postedComments">

			<table class="table-striped" bordercolor="#FFFFFF" border="1" cellpadding="5px"> <?php 
			
					$hash = mysql_real_escape_string(strtolower($_GET['hash']));
					$result = mysql_query("SELECT UserName,UserID,Tweets,DateTime,image FROM infotweets WHERE HashTag='$hash' ORDER BY TweetID DESC LIMIT 0,20");
					$i=1;
				while($row = mysql_fetch_array($result)){   
		
						$tweet=get_link($row['Tweets']); ?>		
	
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
						<b style="display:inline"><?php echo $row['UserName']; ?></b> <?php 
						
						$time=str_replace("+0000","+0545",$row['DateTime']); ?>
			
						<p style="font-size:10px;float:right"><?php echo Date('H:m:s D,d M Y',strtotime($time)); ?></p>
						<p><?php echo $tweet."<br/>"; ?></p>
					</td>
				</tr> <?php 
				
						$i++; 
				}   ?>
			</table><br/>
	
		</div>
		
		<div id="loadMoreComments"> 
			<center>
				<p>loading...</p>
				<img src="img/loading31.gif"/>
			</center>
		</div> <?php 
						} 
				} 
				
			} ?>

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
		mysql_close($con);
	?>



</body>
</html>