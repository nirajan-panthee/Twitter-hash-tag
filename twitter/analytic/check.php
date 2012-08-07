<?php
include 'connection.php';
	$hash="#ajax";
	$date_month=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y,%m')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates DESC");
	?> AJAX(BY Month)<table border="1">
	<tr><td>Date</td><td>count</td></tr><?php
	
while($row=mysql_fetch_array($date_month)){
	
	echo "<tr><td>".$row['dates']."</td>";
	echo "<td>".$row['COUNT( Tweets )']."</td></tr>";
	}
	 

?>
</table>
BY DAY<table border="1">
	<tr><td>Date</td><td>count</td></tr><?php
	$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y,%m,%d')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates DESC");
	while($row=mysql_fetch_array($date_day)){
	
		echo "<tr><td>".$row['dates']."</td>";
		echo "<td>".$row['COUNT( Tweets )']."</td></tr>";
	
	}
	?></table>
	BY YEAR<table border="1">
	<tr><td>Date</td><td>count</td></tr><?php
	$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates DESC");
	while($row=mysql_fetch_array($date_day)){
		//var_dump($row);
		echo "<tr><td>".$row['dates']."</td>";
		echo "<td>".$row['COUNT( Tweets )']."</td></tr>";
	
	}
	//mysql_close($con);
	?></table>BY WEEK<table border="1">
	<tr><td>Date</td><td>count</td></tr><?php
	$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y,%m,%U')) AS dates, COUNT( Tweets ) FROM infotweets WHERE HashTag='$hash' GROUP BY dates ORDER BY dates DESC");
	while($row=mysql_fetch_array($date_day)){
		//var_dump($row);
		echo "<tr><td>".$row['dates']."</td>";
		echo "<td>".$row['COUNT( Tweets )']."</td></tr>";
	
	}
	mysql_close($con);
	?></table>