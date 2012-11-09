<?php	
	
	class Tweet {
		function get_output($hash,$num){
			
				$result=mysql_query("SELECT * FROM infotweets WHERE HashTag='$hash' ORDER BY TweetID DESC LIMIT 0,$num");
			
			while($row = mysql_fetch_array($result)){
				
					$tweet[]=array("HashTag"=>$row['HashTag'],"TweetID"=>$row['TweetID'],"UserID_NO"=>$row['UserID_No'],"UserID"=>$row['UserID'],"UserName"=>$row['UserName'],"Tweets"=>$row['Tweets'],"DateTime"=>$row['DateTime'],"image"=>$row['image']);
										
			}
			if(isset($tweet)){
			$hash=urlencode($hash);
			$output['data'] = $tweet;
			}
			$output['url'] = "hashtag.php?hash=$hash";
		
			return json_encode($output);
			
			mysql_close($con);
		}
		
		public function getHash($ihash) {
				$hash=mysql_real_escape_string(strtolower($ihash));
				return $hash;
		}
		
		
		public function countHash_tweet($hash){
			$result = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM infomax WHERE HashTag='$hash'"));
			$check=intval($result[0]);
			return $check;
		}
		
		public function get_json($search,$maxid) {
				$url = "http://search.twitter.com/search.json?q=" . urlencode ( $search ) . "&rpp=100&include_entities=true&since_id=$maxid";
				$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, $url );
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
				$result = curl_exec( $curl );
				curl_close( $curl);
				return $result;
		
		}
		
				public function insert($tweet,$hash) {
				$sql=array();
			foreach($tweet as $p) {
	

			$sql[]='("'.mysql_real_escape_string($hash).'","'.mysql_real_escape_string($p["id_str"]).'","'.mysql_real_escape_string($p["from_user_id"]).'","'.mysql_real_escape_string($p["from_user"]).'","'.mysql_real_escape_string($p["from_user_name"]).'","'.mysql_real_escape_string($p["text"]).'","'.mysql_real_escape_string($p["created_at"]).'","'.mysql_real_escape_string($p["profile_image_url"]).'")';
			
			}
			mysql_query('INSERT INTO infotweets (HashTag,TweetID,UserID_No,UserID,UserName,Tweets,DateTime,image) VALUES' .implode(',',$sql));
	
		}

	
	}

	
?>