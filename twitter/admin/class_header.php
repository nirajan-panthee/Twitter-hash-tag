<?php
	class header {
	
		public function error($print) {
				header("HTTP/1.1 400 Bad Request");	
				die($print);
				exit;
		}
	
	
	}
?>