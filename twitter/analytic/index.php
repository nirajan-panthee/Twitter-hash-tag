<?php 
include 'connection.php';
$hash="#ajax";
if(isset($_GET['year']))
{
	$year=$_GET['year'];
	$month=$_GET['month'];
}
else
{
	$year="all";
	$month="all";
}
$year_month=$year.",".$month;
?>
<html>
	<head>
	 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	 <script type="text/javascript" src="jquery-latest.js"></script>
	
	</head>
	<body style="background-color:#42A7C9">
	<div style="float:right;border-radius:5px;height:25px;background-color:#FFFFFF">
		<form action="index.php" method="GET">
		<select id="year" style="border:none;float:left;margin-right:10px;background-color:#F2F2F2" name="year">
			<option value="all">All years</option>
			<option disabled>--------</option>
			
			<?php
					
					
					$date_year=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates ASC");
				while($row=mysql_fetch_array($date_year)){ ?>
					
					<option value="<?php echo $row['dates']; ?>" <?php if($year==$row['dates']) {echo "selected";}?>> <?php echo $row['dates']; ?></option><?php
			
				}?>
			</select>
			<select id="month" style="border:none;float:left;background-color:#F2F2F2" name="month">
					<option value="all">All months</option>
			<option disabled>--------</option>
					<?php
					
					$date_month=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%b')) AS dates FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates ASC");
		
				while($row=mysql_fetch_array($date_month)){ ?>
	
					<option value="<?php echo $row['dates']; ?>"<?php if($month==$row['dates']) {echo "selected";}?>><?php echo $row['dates']; ?></option><?php
			
				}
				
				?>
			</select>
			<input type="submit" value="SELECT">
			</form>
	</div>
	<div id="chart_div" style="width: 500px; height: 300px;"></div>
	</body>
</html>

<?php

			if($year=="all"&&$month=="all"){
					$data['0']=array("YEAR","TWEET COUNT");
					
						$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
					
				
				} elseif($year!="all"&&$month=="all"){
						$data['0']=array("MONTH OF ".$year,"TWEET COUNT");
						
						$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%b')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$year' GROUP BY dates");
					
				} elseif($year!="all"&&$month!="all"){
					$data['0']=array("DAY OF ".$month." ".$year,"TWEET COUNT");
					
						$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%d')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y,%b')='$year_month' GROUP BY dates");
					
				
				}
				if(isset($date_day)){
					while($row=mysql_fetch_array($date_day)){
							
							
							$data[]=array($row['0'],(int)$row['1']);
					}
					if(isset($data['1'])){
					 ?>
					 
					 
					 <script type="text/javascript">
						
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart);
					function drawChart() {
					
						var data= <?php  echo json_encode($data); ?>
						
						var data = google.visualization.arrayToDataTable(data);
						
						var options = {
						title: 'Tweets Graph'
						};

						var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
						chart.draw(data, options);
					}
				</script>
	
	<?php
					}
				}
					//echo "</table>";
				
				
				
				mysql_close($con); ?>