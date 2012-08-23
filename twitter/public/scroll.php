<?php

	require 'connection.php';
	
	 
	$i=1;
	if($_GET['hash']){
			$hash=$_GET['hash'];
			$date_query="";
			$user_query="";
						if(isset($_GET['user'])){
								$user_query="AND UserID='".$_GET['user']."'";
								
							}
						if(isset($_GET['year'])&&!isset($_GET['month'])){
							$date_query="AND FROM_UNIXTIME(DATETIME,'%Y')='".$_GET['year']."'";
							
						
						}else if(isset($_GET['year'])&&isset($_GET['month'])){
						$dateandmonth=$_GET['year'].",".$_GET['month'];
						$date_query="AND FROM_UNIXTIME(DATETIME,'%Y,%b')='".$dateandmonth."'";
						
						}
						
		if($_GET['lastComment']){
				$i=$_GET['lastComment']+1;
				$lastid=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hash' $date_query $user_query"));
				$last=$lastid['0'];
	
			if($last==$i){
			return false;
			
			}else{ 
?>
			<table  class="table-striped" bordercolor="#FFFFFF" border="1" cellpadding="5px" style="margin-left:0px">
			<?php
				$limit=mysql_real_escape_string($_GET['lastComment']+1);
				$sqlresult = mysql_query("SELECT UserName,UserID,Tweets,DateTime,image FROM infotweets WHERE HashTag='$hash' $date_query $user_query ORDER BY TweetID DESC LIMIT $limit,20");
		
				while($row = mysql_fetch_array($sqlresult)) { 
						$tweet=get_link($row['Tweets']); 
			?>
					<tr class='postedComment' id="<?php echo $i; ?>" >
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
							<p style="font-size:10px;float:right"><?php echo Date('H:m:s D,d M Y',(int)$row['DateTime']+20700); ?></p>
							<p><?php echo $tweet."<br/>"; ?></p>
						</td>
					</tr>
			<?php 
					$i++;

				}
			?> 
			</table> 
			
<?php 
			}
		}
	}

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
