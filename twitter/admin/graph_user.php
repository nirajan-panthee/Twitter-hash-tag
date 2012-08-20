<?php
		include 'connection.php';
	if(isset($_GET['hash'])){
		
		$hash=$_GET['hash'];
		if(isset($_GET['year'])&&!isset($_GET['month'])){
				$index_user="<a href=\"".$_SERVER['PHP_SELF']."?hash=".urlencode($hash)."\">GO BACK</a>";
				
				$year=$_GET['year'];
				$head="Tweet Count of ".$year;
				$alltimeuser=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");	
				$i=0;
			while($row_alltimeuser=mysql_fetch_array($alltimeuser)){
					$user=$row_alltimeuser['users'];
					$data1[$i]['name']="<a href=\"".$_SERVER['PHP_SELF']."?hash=".urlencode($hash)."&user=".$row_alltimeuser['users']."\">".$row_alltimeuser['users']."</a>";
					
					$usr_count=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%c')) AS dates,COUNT(Tweets) as count FROM infotweets WHERE HashTag='$hash' AND (UserID='$user' AND FROM_UNIXTIME(DATETIME,'%Y')='$year') GROUP BY dates");
				while($row_usr_count=mysql_fetch_array($usr_count)){
					
					$data1[$i]['data'][(int)$row_usr_count['dates']]=(int)$row_usr_count['count'];
				}
				$i++;
			}
			$curyear=(int)Date('Y',time());
			$curmonth= (int)Date('m',time());
			if($year==$curyear ){
				$noOfMonth=$curmonth;
			}
			else{
				$noOfMonth=12;
			}
			if(!isset($data1)) {
				die;
			}
			foreach($data1 as $key=>$value){
					$i=1;
				while($i<=$noOfMonth){
					if(!array_key_exists($i,$value['data'])){
						$data1[$key]['data'][$i]=0;
					}
					
					$i++;
				}
				ksort($data1[$key]['data']);
				$data1[$key]['data']=array_values($data1[$key]['data']);
			}	
			$xdata=array('<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jan&year='.$year.'">Jan</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Feb&year='.$year.'">Feb</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Mar&year='.$year.'">Mar</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Apr&year='.$year.'">Apr</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=May&year='.$year.'">May</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jun&year='.$year.'">Jun</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Jul&year='.$year.'">Jul</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Aug&year='.$year.'">Aug</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Sep&year='.$year.'">Sep</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Oct&year='.$year.'">Oct</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Nov&year='.$year.'">Nov</a>','<a href="'.$_SERVER['PHP_SELF'].'?hash='.urlencode($hash).'&month=Dec&year='.$year.'">Dec</a>');
		}
		else if(isset($_GET['year'])&&isset($_GET['month'])){
			
				$year=$_GET['year'];
				$month=$_GET['month'];
				$head="Tweet Count of ".$month." ".$year;
				$year_month=$year.",".$month;
				$index_user="<a href=\"".$_SERVER['PHP_SELF']."?year=".$year."&hash=".urlencode($hash)."\">GO BACK</a>";
				
				$alltimeuser=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");	
				$i=0;
			while($row_alltimeuser=mysql_fetch_array($alltimeuser)){
					$user=$row_alltimeuser['users'];
					$data1[$i]['name']="<a href=\"".$_SERVER['PHP_SELF']."?hash=".urlencode($hash)."&user=".$row_alltimeuser['users']."\">".$row_alltimeuser['users']."</a>";
					$usr_count=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%d')) AS dates,COUNT(Tweets) as count FROM infotweets WHERE HashTag='$hash' AND (UserID='$user' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month') GROUP BY dates");
				while($row_usr_count=mysql_fetch_array($usr_count)){
					
					$data1[$i]['data'][(int)$row_usr_count['dates']]=(int)$row_usr_count['count'];
				}

				$i++;
			}
			$curyear=(int)Date('Y',time());
			$curyearmonth=Date('M',time());
			$curday= (int)Date('d',time());
			$yearmonth= explode(",",Date('m,Y',strtotime($year_month)));
			$no_of_days=cal_days_in_month(CAL_GREGORIAN,$yearmonth[0],$yearmonth[1]);
			
			if($year==$curyear && $month==$curyearmonth){
				$totaldays=$curday;
			}
			else
			{
				$totaldays=$no_of_days;
			}
			$xdata=array();
			if(!isset($data1)) {
				die;
			}
			foreach($data1 as $key=>$value){
					$i=1;
				while($i<=$totaldays){
					if(!array_key_exists($i,$value['data'])){
						$data1[$key]['data'][$i]=0;
					}
					$xdata[]=$i;
					
					$i++;
				}
				ksort($data1[$key]['data']);
				$data1[$key]['data']=array_values($data1[$key]['data']);
				
			}
			
		}
		else{

				$index_user="All Time";
				$head="All Time";
				
				$ava_yr=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
			while($row_ava_yr=mysql_fetch_array($ava_yr)){
				$xdata[]="<a href=\"".$_SERVER['PHP_SELF']."?hash=".urlencode($hash)."&year=".$row_ava_yr['dates']." \">".$row_ava_yr['dates']."</a>";
				$allyr[]=$row_ava_yr['dates'];
			
			}
			$alltimeuser=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' GROUP BY users ORDER BY count DESC LIMIT 0,3 ");			
			
			
			
			$i=0;
			
			while($row_alltimeuser=mysql_fetch_array($alltimeuser)){
					
					$user=$row_alltimeuser['users'];
					$data1[$i]['name']="<a href=\"".$_SERVER['PHP_SELF']."?hash=".urlencode($hash)."&user=".$row_alltimeuser['users']."\">".$row_alltimeuser['users']."</a>";
					
					$usr_count=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates,COUNT(Tweets) as count FROM infotweets WHERE HashTag='$hash' AND UserID='$user' GROUP BY dates");
				
				while($row_usr_count=mysql_fetch_array($usr_count)){
					
							
							$data1[$i]['data'][$row_usr_count['dates']]=$row_usr_count['count'];
							
					
				}
				if(!isset($data1)) {
				die;
				}
				foreach($allyr as $y){
					if(!array_key_exists($y,$data1[$i]['data']))
					{
						$data1[$i]['data'][$y]=0;
					}
				}
				$newkey=0;
				foreach($data1[$i]['data'] as $key=>$value)
				{
					unset($data1[$i]['data'][$key]);
					$data1[$i]['data'][$newkey]=(int)$value;
					$newkey++;
				}
				
			$i++;
			}
			
		}
	}	
		
		





?>
<div style="width:615px; height:220px;overflow:hidden;margin-bottom:5px">
				<div id="graph_user" style="margin-left:-30px;text-align:center">
				<!--div id="click_user" style="text-align:center;cursor:pointer">Switch to Tweet Count</div-->
					<div id="user" style="width: 645px; height:200px;"></div>
					<div id="click_user" style="text-align:center;cursor:pointer;color:#33CCFF"><b>Switch to Tweet Count</b></div>
				</div>
			</div>
<!--html>
	<head>
		<script type="text/javascript" src="jquery-latest.js"></script-->
		<script type="text/javascript">
				
				var data1=<?php echo json_encode($data1);?>;
				var xlabel=<?php echo json_encode($xdata);?>;
				
				
				$(function () {
						var chart;
					$(document).ready(function() {
						chart = new Highcharts.Chart({
							chart: {
								renderTo: 'user',
								type: 'line',
								marginRight: 130,
								marginBottom: 40
							},
							title: {
								text: 'User Trend of '+ '<?php echo $head; ?>',
								x: -20 //center
							},
							subtitle: {
								text: '<?php echo $index_user;?>',
								x: -20
							},
							xAxis: {
								categories: xlabel
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
										
										var format='<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'tweets<br/>';
										 
										
										return format;
										
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
							series: data1
						});
					});
    
				});
		</script>
		<!--script src="highcharts.js"></script>
		<script src="modules/exporting.js"></script>
		<script src="themes/grid.js"></script>
	</head>
	
	
	<body>
			<div style="width:615px; height:200px;overflow:hidden;margin-bottom:5px">
				<div id="graph" style="margin-left:-30px;text-align:center">
					<div id="user" style="width: 645px; height:200px;"></div>
				</div>
			</div>
	</body>
</html-->