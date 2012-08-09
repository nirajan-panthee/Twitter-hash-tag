<html>
	<head>
		<link rel="stylesheet" href="css/basic.css">
		<link rel="stylesheet" href="css/visualize.css">
		<link rel="stylesheet" href="css/visualize-dark.css">
		<link rel="stylesheet" href="css/visualize-light.css">
		
		<script type="text/javascript" src="jquery-latest.js"></script>
		<script type="text/javascript" src="js/visualize.jQuery.js"></script>
		<script type="text/javascript">
			$(function(){
				$('#year').visualize({type: 'line', width: '420px'});
			});
				
		
		</script>
		<style>
		.visualize{
				margin-top:0px;
			}
			td, th{
				border:none;
				text-align:left;
		
			}
			#users{
				width:300px;
			
				margin:0px;
		
			}
		
			.clearfix:after {
				content: ".";
				display: block;
				clear: both;
				visibility: hidden;
				line-height: 0;
				height: 0;
			}
 
			.clearfix {
				display: inline-block;
			}
 
			html[xmlns] .clearfix {
				display: block;
			}
 
			* html .clearfix {
				height: 1%;
			}
			
			body{
				background-color:#339DFF;
			}
		</style>
	</head>
	
	
	<body>
		<?php
			include 'connection.php';
			$hash=$_GET['hash'];
			$year=$_GET['year'];
		
			$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%b')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY dates");
			while($row=mysql_fetch_array($date_day)){
				$month[]=$row;
				
			}?>
			<div style="width:500px;overflow:hidden;margin:0px;float:left">
			<table id="year" style="display:none">
			<caption><?php echo "Graph OF ".$year." OF ".$hash; ?></caption>
				<thead>
					<tr><?php
						foreach($month as $y){?>
			
							<th><a href="graph_day.php?month=<?php echo $y['0']; ?>&hash=<?php echo urlencode($hash);?>&year=<?php echo $year;?>"><?php echo $y['0']; ?></a></th><?php
			
						}?>
					</tr>
				</thead>
				<tbody>
					<tr><?php
						foreach($month as $y){?>
			
							<td><?php echo $y['1']; ?></td><?php
			
						}?>
					</tr>
				</tbody>
			</table>
			</div>
			<div style="float:left;background-color:#F2F2F2;border-radius:10px;padding:10px;width:400px;margin-left:10px">
			<h2 align="center">Top Users</h2><?php
		
			$date_day=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
			
			$total=0;
			
			while($row=mysql_fetch_array($date_day)){
					//var_dump($row);
					$total+=$row['count'];
					$user_count['users'][$row['users']]=$row['count'];
				
					$user=$row['users'];
					$image=mysql_fetch_array(mysql_query("SELECT Image FROM infotweets WHERE UserID='$user'"));?>
				
				<div class="clearfix"style="margin-bottom:20px;">
					<div style="float:left;margin-right:10px">
						<img src='<?php echo $image['Image']; ?>'/>
						
					</div>
					<div style="float:left;width:300px;background-color:#FFFFFF">
						<div id="<?php echo $user; ?>" style="width:0px;height:48px;background-color:#A8A2A0">
						</div>
					</div>
					<div><b><?php echo $row['users'].":".$row['count']." tweets" ; ?></b> </div>
				</div><?php
			} 
			
			$user_count['total']=$total;
			//var_dump($user_count);?>
			
			</div>
			
			<script>
				var data=<?php echo json_encode($user_count);?>;
				$( function(){
				
					$.each(data['users'], function(key,value) {
							var divwidth= (value/ data['total'])*100+"%";
					
						$('#'+key).animate({
							width: divwidth
						}, 2000);
					
					});
				});
			
			</script>
	</body>
</html>