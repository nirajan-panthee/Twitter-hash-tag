<?php

		if(isset($_GET['hash'])){
		
				$hash=$_GET['hash'];
				$avaliableyear=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT(tweets) as tweetcount FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
				
				$i=0;
				
			while($row_avaliableyear=mysql_fetch_array($avaliableyear)){
					
					$xdata_bar[$i]=$row_avaliableyear['dates'];
					
					$data_bar[0]['data'][$i]=(int)$row_avaliableyear['tweetcount'];
					$i++;
			}
			
		}
?>


		<script type="text/javascript" src="jquery-latest.js"></script>
		
		<script type="text/javascript">
		var chart;
		var data_bar=<?php echo json_encode($data_bar); ?>;
		 var xdata_bar=<?php echo json_encode($xdata_bar); ?>;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Bar Graph'
		},
		subtitle: {
			text: 'Tweet count Vs Year'
		},
		xAxis: {
			categories:xdata_bar
				
			
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Tweet count'
			}
		},
		 legend: {
			layout: 'vertical',
			backgroundColor: '#FFFFFF',
			align: 'left',
			verticalAlign: 'bottom',
			x: 100,
			y: 70,
			floating: true,
			shadow: true
		}, 
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y +' tweets';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
			series: data_bar
			
		});
});
		</script>
		<script src="highcharts.js"></script>
		<script src="modules/exporting.js"></script>
		<script src="themes/grid.js"></script>
	
	<div style="width:305px; height:220px;overflow:hidden;margin-bottom:5px">
			<div id="graph_all" style="margin-left:-30px;margin-top:5px">
			<div id="container" style="width: 325px; height:200px;"></div>
			
			</div>
			</div>
	
	
	
