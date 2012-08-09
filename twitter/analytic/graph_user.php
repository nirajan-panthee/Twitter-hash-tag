<?php
//SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='#ajax' AND FROM_UNIXTIME(DATETIME,'%Y')='2012' GROUP BY users ORDER BY count DESC LIMIT 1,3 

	include 'connection.php';
	$hash='#ajax';
	$date_day=mysql_query("SELECT DISTINCT (FROM_UNIXTIME(DATETIME,'%Y')) AS dates FROM infotweets WHERE HashTag='$hash' GROUP BY dates");
	while($row=mysql_fetch_array($date_day)){
	
		$year[]=$row['dates'];
	
	}
	foreach($year as $y){
		 $date_day=mysql_query("SELECT DISTINCT(UserID) as users,COUNT(Tweets) as count FROM `infotweets` WHERE HashTag='$hash' AND FROM_UNIXTIME(DATETIME,'%Y')='$y' GROUP BY users ORDER BY count DESC LIMIT 1,3 ");
			//$data[]=$y;
		while($row=mysql_fetch_array($date_day)){
			
			$data[$y]=$row;
		
		}
	}
	var_dump($data);






?>