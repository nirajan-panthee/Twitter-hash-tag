<?php

	require 'connection.php';
			
		
		if(isset($_GET['active'])){	
			$resource=mysql_query("SELECT HashTag FROM infomax WHERE Active=1");
		
		}
		else{
		
			$resource=mysql_query("SELECT HashTag FROM infomax WHERE Active=0");
		}
		while($row=mysql_fetch_array($resource)){
			
			$auto=str_replace('#',"",$row['HashTag']);
			$data[]=$auto;
		
		}
		echo json_encode($data);
		
	mysql_close($con);	
?>
