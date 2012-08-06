<?php
include 'connection.php';
	$test='0';
	$date=mysql_query("SELECT DISTINCT(DateTime) FROM infotweets WHERE HashTag='#ajax' GROUP BY DateTime");
	?> AJAX<table border="1">
	<tr><td>Date</td><td>count</td></tr><?php
	
while($row=mysql_fetch_array($date)){
	$timestamp=strtotime($row['DateTime']);
	$date_day[]=Date("d M Y",$timestamp);
	
	
}
	foreach($date_day as $p){
		//var_dump($p);
		if($test!=$p){
			$test=$p;
		$resource=mysql_query("SELECT COUNT(HashTag) FROM infotweets WHERE HashTag='#ajax' AND DateTime LIKE '%$p%'");
		$count=mysql_fetch_array($resource);?><tr><td><?php echo $p;?></td><td><?php echo $count['0'];?></td><tr/> <?php
	}
	}
	mysql_close($con);

?>
</table>