<?php 
include '../connection.php';
$hash='#ajax';
$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
while($row=mysql_fetch_array($date_day)){
				
				
				$y=$row['dates'];
				$yearname="<a href=\"graph.php?hash=".urlencode($hash)."&year=".$y."\">".$y."</a>";
				$data['year'][]=$yearname;
				//echo $data['year'][0];
				//$data['year'][]="<b>".$y."</b>";
				$data['tweets'][]=(int)$row['tweetcount'];
				
				 
			
			
			$date_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count ,Image FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$y' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
			$i=0;
			$topuser="<b>Top user</b><br/>";
			
			while($row1=mysql_fetch_array($date_user)){
					//$topuser.="<img  src=\"http://a0.twimg.com/profile_images/1407053584/AndreaUtente11_normal.jpg\" style=\"width=30px;height=30px;float:left;clear:left;margin-right:3px\"><div style=\"height:40px;float:left;font-size:13px\"><b style=\"color:blue\">Topuser1</b><br/> 23 tweets</br></div>";
					$topuser.= "<b style=\"color:red\">".$row1['users'].":</b> ".$row1['count']." tweets<br/>";
					//$data[$y]['topuser'][$i]['username']=$row1['users'];
					//$data[$y]['topuser'][$i]['tweets']=$row1['count'];
					//$data[$y]['topuser'][$i]['image']=$row1['Image'];
					
					
					$i++;
					}
			$data[$yearname]=$topuser;
					 
					
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
								text: 'Time line Graph OF <?php echo $hash; ?>',
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