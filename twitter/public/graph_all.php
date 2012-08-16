<?php
include 'connection.php';
	if(isset($_GET['hash'])){
		
		$hash=$_GET['hash'];
		
		if(isset($_GET['month'])){
				$month=$_GET['month'];
				$index="<a href=\"".$_SERVER['PHP_SELF']."?&hash=".urlencode($hash)."\">GO BACK</a>";
				
				$date_year=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%b')='$month' GROUP BY dates");
				$i=0;
			
			while($row_year=mysql_fetch_array($date_year)){
					$year=$row_year['dates'];
					$year_month=$year.",".$month;
					$monthyear=$month.",".$year;
					$data[$i]['name']=$monthyear;
					
					$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%d')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY dates ORDER BY dates ASC");
				
				while($row_day=mysql_fetch_array($date_day)){
						$thisday=$row_day['dates'];
						$data[$i]['data'][(int)$thisday]=(int)$row_day['tweetcount'];
						$daymonthyear=$year_month.",".$thisday;
						$day_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b,%d')='$daymonthyear' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
						$topuser="<b>Top user</b><br/>";
					while($row_day_user=mysql_fetch_array($day_user)){
						$topuser.= "<b style=\"color:red\">".$row_day_user['users']."</b> : ".$row_day_user['count']." tweets<br/>";	
					
					}
					$user[$monthyear][(int)$thisday]=$topuser;
					
				
				}
				$i++;
			}
			if(!isset($data)) {
				die;
			}
			
				$monthnames=array();
				$i=1;
			while($i<=31){
					$monthnames[]=$i;
					$i++;
			}
			
			$curyearmonth=Date('M,Y',time());
			$curday= (int)Date('d',time());
			
			foreach($data as $key=>$value){
					$i=1;
					$yearmonth= explode(",",Date('m,Y',strtotime($value['name'])));
					$no_of_days=cal_days_in_month(CAL_GREGORIAN,$yearmonth[0],$yearmonth[1]);
				while($i<=31){
					if(!array_key_exists($i,$value['data'])){
						$data[$key]['data'][$i]=0;
					}
					if($value['name']==$curyearmonth && $i==$curday){
						break;
					}
					if($no_of_days==$i){
						break;
					}
					$i++;
				}
				ksort($data[$key]['data']);
				$data[$key]['data']=array_values($data[$key]['data']);
				
			}
			
		}
		
		else{
				$date_year=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
				$i=0;
				$index="All Time";
			while($row=mysql_fetch_array($date_year)){
					$year=$row['dates'];
					$data[$i]['name']=$year;
					$date_month=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%c')) AS dates, COUNT( Tweets ) AS tweetcount FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY dates ORDER BY dates DESC");
			
				while($row_month=mysql_fetch_array($date_month)){
				
						$thismonth=(int)$row_month['dates'];
						$year_month=$year.",".$row_month['dates'];
						$data[$i]['data'][$thismonth]=(int)$row_month['tweetcount'];
						$month_user=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%c')='$year_month' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");
						$topuser="<b>Top user</b><br/>";
					while($row_user=mysql_fetch_array($month_user)){
							$topuser.= "<b><a  style=\"color:red\" href=\"../public/hashtag.php?hash=".urlencode($hash)."&user=".$row_user['users']."\">".$row_user['users']."</a>:</b> ".$row_user['count']." tweets<br/>";	
				
					}
					$time = mktime(0, 0, 0, $thismonth);
					$name = '<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month='.strftime("%b", $time).'">'.strftime("%b", $time).'</a>';
					$user[$year][$name]=$topuser;
				}
				$i++;
			}
				$monthnames=array('<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jan">Jan</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Feb">Feb</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Mar">Mar</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Apr">Apr</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=May">May</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jun">Jun</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jul">Jul</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Aug">Aug</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Sep">Sep</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Oct">Oct</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Nov">Nov</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Dec">Dec</a>');
				$curyear=(int)Date('Y',time());
				$curmonth= (int)Date('m',time());
			foreach($data as $key=>$value){
					$i=1;
				while($i<=12){
					if(!array_key_exists($i,$value['data'])){
						$data[$key]['data'][$i]=0;
					}
					if($value['name']==$curyear && $i==$curmonth){
						break;
					}
					$i++;
				}
				ksort($data[$key]['data']);
				$data[$key]['data']=array_values($data[$key]['data']);
			}
		}
		//$t= strtotime("18 Aug 2011 +0000");
		//echo $t;
		//echo $user['2012']['Aug'];
	}
	//include 'user.php';
		
		
		
?>
<div style="width:615px; height:220px;overflow:hidden;margin-bottom:5px">
			<div id="graph_all" style="margin-left:-30px">
			<div id="alltime" style="width: 645px; height:200px;"></div>
			<div id="click" style="text-align:center;cursor:pointer;color:#3CF"><b>Switch to top user</b></div>
			</div>
			</div>
<!--html>
	<head>
		<script type="text/javascript" src="jquery-latest.js"></script-->
		<script type="text/javascript">
				
				var data=<?php echo json_encode($data);?>;
				var months=<?php echo json_encode($monthnames);?>;
				var user=<?php echo json_encode($user);?>;
				
				$(function () {
						var chart;
					$(document).ready(function() {
						chart = new Highcharts.Chart({
							chart: {
								renderTo: 'alltime',
								type: 'line',
								marginRight: 95,
								marginBottom: 40
							},
							title: {
								text: 'Tweet Count ',
								x: -20 //center
							},
							subtitle: {
								text: '<?php echo $index;?>',
								x: -20
							},
							xAxis: {
								categories: months
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
										var topuser;
										var format='<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'tweets<br/>';
										 if(topuser=user[this.series.name][this.x])
										{
											return format+topuser;
										}
										else 
										{
										return format;
										}
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
							series: data
						});
					});
    
				});
		</script>
		<!--script src="highcharts.js"></script>
		<script src="modules/exporting.js"></script>
		<script src="themes/grid.js"></script>
	</head>
	
	
	<body>
			<!--div style="width:615px; height:200px;overflow:hidden;margin-bottom:5px">
			<div id="graph" style="margin-left:-30px">
			<div id="alltime" style="width: 645px; height:200px;"></div>
			</div>
			</div>
	</body>
</html-->