<?php 


	require 'connection.php';
	set_time_limit(0);
	$i=48519;
	
	$max=mysql_fetch_array(mysql_query("SELECT MAX(ID) FROM infotweets"));
	//echo $max['0'];
	while($i<=$max['0']){
		
		$date=mysql_fetch_array(mysql_query("SELECT DateTime FROM infotweets WHERE ID='$i'"));
		echo $i."</br>";
		echo $date['DateTime']."</br>";
		$timestamp=strtotime($date['DateTime']);
		echo $timestamp."</br></br>";
		mysql_query("UPDATE infotweets SET DateTime ='$timestamp' WHERE id='$i'");
	$i++;
	
	}
	mysql_close($con);
?>	