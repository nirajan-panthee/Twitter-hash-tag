<?php
	require 'connection.php';
	require 'class_tweet.php';
	require 'class_header.php';
	
	if(isset($_GET['hash'])){
	
			
			$tweet=new Tweet;
	
			$hash= $tweet->getHash($_GET['hash']);
			$check =$tweet->countHash_tweet($hash);
	
	
		if($check>0){
	
			if(isset($_GET['num'])){
		
				if($_GET['num']>0){
			
					
					$num=mysql_real_escape_string(intval($_GET['num']));
				
					header("HTTP/1.1 200 Ok");
					echo $tweet->get_output($hash,$num);
			
				}
				else {
					
					$error=new Header;
					$error->error("<h2>HTTP 400 Bad Request</h2><hr/><h5><i>no of tweet asked is invalid</i></h5> ");
			
				}
		
			}
			else {
		
				
				$num=10;
			
				header("HTTP/1.1 200 Ok");
				echo $tweet->get_output($hash,$num);
		
			}
	
		}
		else {
			$error=new Header;
			$error->error("<h2>HTTP 400 Bad Request</h2><hr/><h5><i>hashtag asked is invalid</i></h5> ");
		}
		mysql_close($con);
		unset($tweet);
		unset($error);
	}
	else {
	$error=new Header;
	$error->error("<h2>HTTP 400 Bad Request</h2><hr/><h5><i>hashtag is not given</i></h5> ");
	unset ($error);
	}
	
	
	
	
?>