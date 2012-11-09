<?php

	$con = mysql_connect("localhost","root","nirajan123");
		
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("twitter",$con) or die('could not select database');
				
?>				