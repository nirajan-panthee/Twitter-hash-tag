<?php 
	
	if(isset($_GET['hash'])){
			
			include 'connection.php';
			$hash=$_GET['hash'];
			$goto="All Time";
	
		
		if(isset($_GET['year'])&&!isset($_GET['month'])){
			
				$goto="<a href=\"graph.php?hash=".urlencode($hash)."\" class=\"graph\">Go Back</a>";
				
				$year=$_GET['year'];
				$index=$year;
				$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%b')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY dates ORDER BY dates DESC");
		
			while($row=mysql_fetch_array($date_day)){
				
					$y=$row['dates'];
					$year_month=$year.",".$y;
					$yearname="<a  href=\"graph.php?hash=".urlencode($hash)."&year=".$year."&month=".$y."\">".$y."</a>";
					
					$data['year'][]=$yearname;
					$data['tweets'][]=(int)$row['tweetcount'];
					$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
				
					$i=0;
					$topuser="<b>Top user</b><br/>";
				while($row1=mysql_fetch_array($date_user)){
					
					$topuser.= "<b><a  style=\"color:red\" href=\"../public/hashtag.php?hash=".urlencode($hash)."&user=".$row1['users']."\">".$row1['users']."</a>:</b> ".$row1['count']." tweets<br/>";
					$i++;
					
				}
				$data[$yearname]=$topuser;
					 
			}
	
		} 
		else if(isset($_GET['year'])&&isset($_GET['month'])) {

				$year=$_GET['year'];
				$month=$_GET['month'];
				$year_month=$year.",".$month;
				$goto="<a href=\"graph.php?hash=".urlencode($hash)."&year=".$year."\" class=\"graph\">Go Back</a>";
				$index=$month.",".$year;
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
					
					$topuser.= "<b><a   style=\"color:red\" href=\"../public/hashtag.php?hash=".urlencode($hash)."&user=".$row1['users']."\">".$row1['users']."</a>:</b> ".$row1['count']." tweets<br/>";
					$i++;
					
				}
				$data[$yearname]=$topuser;
					 
			}
		}
		else{
		
				$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
				$index="";
			
			while($row=mysql_fetch_array($date_day)){
		
					$y=$row['dates'];
					$yearname="<a  href=\"graph.php?hash=".urlencode($hash)."&year=".$y."\">".$y."</a>";
					$data['year'][]=$yearname;
		
					$data['tweets'][]=(int)$row['tweetcount'];
					$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$y' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
					$i=0;
			
					$topuser="<b>Top user</b><br/>";
			
				while($row1=mysql_fetch_array($date_user)){
				
						$topuser.= "<b><a  style=\"color:red\" href=\"../public/hashtag.php?hash=".urlencode($hash)."&user=".$row1['users']."\">".$row1['users']."</a>:</b> ".$row1['count']." tweets<br/>";
						$i++;
				}
				$data[$yearname]=$topuser;
				
					 
					
			}
		}
		var_dump($data);
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
								marginRight: 0,
								marginBottom: 40
							},
							title: {
								text: 'Tweet Count '+'<?php echo $index; ?>',
								x: -20 //center
							},
							subtitle: {
								text: '<?php echo $goto;?>',
								x: -20
							},
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
									verticalAlign: 'bottom',
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
			<div style="width:310px; height:200px;overflow:hidden">
			<div id="graph" style="margin-left:-30px">
			<div id="container" style="width: 335px; height:200px;"></div>
			</div>
			</div>
	</body>
</html>