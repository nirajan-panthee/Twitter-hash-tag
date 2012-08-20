<?php
	require 'connection.php';
	
	

	if(isset($_GET['hash'])){
			$hash=mysql_real_escape_string($_GET['hash']);
	
			// output headers so that the file is downloaded rather than displayed
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename='.$hash.'.csv');

			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			// output the column headings
			fputcsv($output, array('ID', 'HashTag','TweetID', 'UserID_No','UserID','UserName','Tweets','DateTime','image'));

			// fetch the data

			$rows = mysql_query("SELECT * FROM infotweets WHERE HashTag='$hash'");

			// loop over the rows, outputting them
		while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
	}
	mysql_close($con);
?>