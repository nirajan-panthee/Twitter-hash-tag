<?php
include 'connection.php';
$date=Date("D, d M Y", time());
//echo $date;

$hash=mysql_query("SELECT HashTag FROM infomax");
$yest  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$yesterday=Date("D, d M Y",$yest);

?>
<html>
<body>
<div>
Tweet count
<table border='1'>
<tr>
	<th>HashTag</th>
	<th>Today</th>
	<th>Yesterday</th>
	<tr/><?php
while($tag=mysql_fetch_array($hash)){

	$hashtag=$tag['HashTag'];
	$resource=mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hashtag' AND DateTime Like '$date%'");
	$resource_yest=mysql_query("SELECT COUNT(*) FROM infotweets WHERE HashTag='$hashtag' AND DateTime Like '$yesterday%'");
	
	$row=mysql_fetch_array($resource);
	$row_yest=mysql_fetch_array($resource_yest)
	?>
	
	<tr>

	<td><?php echo str_replace("#","",$tag['HashTag']); ?></td>
	<td><?php echo $row['0']; ?> </td>
	<td><?php echo $row_yest['0']; ?> </td>
	</tr><?php
}
mysql_close($con); 

?>
</table></div></body></html>