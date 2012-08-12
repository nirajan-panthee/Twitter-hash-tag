<?php 
	
	if(isset($_GET['hash'])){
			
			include '../connection.php';
			$hash=$_GET['hash'];
	
		
		if(isset($_GET['year'])&&!isset($_GET['month'])){
			
			
				$year=$_GET['year'];
				$index=$hash." in ".$year;
				$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%b')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY dates");
		
			while($row=mysql_fetch_array($date_day)){
				
					$y=$row['dates'];
					$year_month=$year.",".$y;
					$yearname="<a href=\"graph.php?hash=".urlencode($hash)."&year=".$year."&month=".$y."\">".$y."</a>";
					
					$data['year'][]=$yearname;
					$data['tweets'][]=(int)$row['tweetcount'];
					$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
				
					$i=0;
					$topuser="<b>Top user</b><br/>";
				while($row1=mysql_fetch_array($date_user)){
					
					$topuser.= "<b style=\"color:red\">".$row1['users'].":</b> ".$row1['count']." tweets<br/>";
					$i++;
					
				}
				$data[$yearname]=$topuser;
					 
			}
	
		} 
		else if(isset($_GET['year'])&&isset($_GET['month'])) {

				$year=$_GET['year'];
				$month=$_GET['month'];
				$year_month=$year.",".$month;
			
				$index=$hash." in ".$month.",".$year;
				$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%d')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY dates");
		
			while($row=mysql_fetch_array($date_day)){
				
					$y=$row['dates'];
					$year_day=$year.",".$month.",".$y;
					$yearname=$y;
					
					$data['year'][]=$yearname;
					$data['tweets'][]=(int)$row['tweetcount'];
					$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b,%d')='$year_day' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
				
					$i=0;
					$topuser="<b>Top user</b><br/>";
			
				while($row1=mysql_fetch_array($date_user)){
					
					$topuser.= "<b style=\"color:red\">".$row1['users'].":</b> ".$row1['count']." tweets<br/>";
					$i++;
					
				}
				$data[$yearname]=$topuser;
					 
			}
		}
		else{
		
				$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
				$index=$hash;
			
			while($row=mysql_fetch_array($date_day)){
		
					$y=$row['dates'];
					$yearname="<a href=\"graph.php?hash=".urlencode($hash)."&year=".$y."\">".$y."</a>";
					$data['year'][]=$yearname;
		
					$data['tweets'][]=(int)$row['tweetcount'];
					$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$y' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
					$i=0;
			
					$topuser="<b>Top user</b><br/>";
			
				while($row1=mysql_fetch_array($date_user)){
				
						$topuser.= "<b style=\"color:red\">".$row1['users'].":</b> ".$row1['count']." tweets<br/>";
						$i++;
				}
				$data[$yearname]=$topuser;
					 
					
			}
		}
		mysql_close($con);
	}
	


?>
<html>
	<head>
		<script type="text/javascript" src="jquery-latest.js"></script>
		<script type="text/javascript">
				
				var data=<?php echo json_encode($data);?>;
				
				$(function () {
						var chart;
					$(document).ready(function() {
						chart = new Highcharts.Chart({
							chart: {
								renderTo: 'container',
								type: 'line',
								marginRight: 130,
								marginBottom: 25
							},
							title: {
								text: 'Time line Graph OF <?php echo $index; ?>',
								x: -20 //center
							},
							//subtitle: {
							//	text: 'Source: WorldClimate.com',
							//	x: -20
							//},
							xAxis: {
								categories: data['year']
							},
							yAxis: {
								title: {
									text: 'Tweet Count'
								},
								plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}]
							},
							tooltip: {
									formatter: function() {
										return '<b>'+ this.series.name +'</b><br/>'+
													this.x +': '+ this.y +'tweets<br/>'+data[this.x];
									}
							},
							legend: {
									layout: 'vertical',
									align: 'right',
									verticalAlign: 'top',
									x: -10,
									y: 100,
									borderWidth: 0
							},
							series: [{
								name: '<?php echo $hash; ?>',
								data: data['tweets']
							}]
						});
					});
    
				});
		</script>
		<script src="highcharts.js"></script>
		<script src="modules/exporting.js"></script>
	</head>
	
	
	<body>
	
		
		<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	</body>
</html>