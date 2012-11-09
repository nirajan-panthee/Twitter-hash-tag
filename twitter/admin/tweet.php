<?php

	require 'connection.php';
	require 'class_tweet.php';
	
	set_time_limit(0);
	
	$tweet=new Tweet;
				
			$infomax=mysql_query("SELECT HashTag,MaxID FROM infomax WHERE Active='1'");
		
		while($info=mysql_fetch_array($infomax)) {
			
				$result_json=$tweet->get_json($info['HashTag'],$info['MaxID']);
			
				$obj=json_decode($result_json,TRUE);
				$maxid=mysql_real_escape_string($obj["max_id_str"]);
				$hash=mysql_real_escape_string($info['HashTag']);
			
				mysql_query("UPDATE infomax SET MaxID = $maxid WHERE HashTag='$hash'");
			
			if(isset($obj["results"])) {
			
					$tweet->insert($obj["results"],$hash);
			}
			else {
			
					header("HTTP/1.1 503 Service Unavailable");
			
			}
			
	
		}
		
	
	mysql_close($con);
	unset($tweet);

?>