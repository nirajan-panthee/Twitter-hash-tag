<html>
	<head>

			<meta charset='utf-8' />
			<link rel="stylesheet" href="css/custom_hash.css">
			<!--<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">-->
			<!--link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css"-->
			<!--<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">-->
			
			<script type="text/javascript" src="js/jquery-latest.js"></script>
			 
    <script type="text/javascript">
    function poprows()
    {
        var newRow = $('#resultsTable tr:last').remove(); // Remove last row
        $('td div',newRow).hide();                        // Hide inner row divs
        $('#resultsTable tr:first').before(newRow);		// Add row as first
        
		$('td div',newRow).toggle(function(){$('td div').slideDown().fadeIn()});  		// Show inner row divs slowly
		
   }
 
    $(document).ready(function()
    {
        var poprowstimer = setInterval('poprows()', 4000);
    });
    </script>
    
	
	</head>
	<body>
	


	
		<?php  
			if(isset($_GET['hash'])){
					$hash=$_GET['hash']; 
				if(isset($_GET['num'])){
					$num=$_GET['num'];
				}
				else{
					$num=5;
				}
		?>

	
	
		<div style="background-color:#FFFFFF;border-radius:10px;padding:5px">
			<?php
					$dhash=strtolower(urlencode($hash));
					$url = "http://localhost/collection/Twitter-hash-tag/twitter/public/tweetapi.php?hash=$dhash&num=$num";
					$curl = curl_init();
					curl_setopt( $curl, CURLOPT_URL, $url );
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
					$result = curl_exec( $curl );
					curl_close( $curl);
			
					$json=json_decode($result,true);
			
				if(isset($json['data'])){ 
			?>
			<table cellspacing="0" class="table-striped" id="resultsTable">
			
				<?php
					foreach($json['data'] as $p) {
						$time=(int)$p['DateTime']+20700;
				?>

						<tr align="left"style="font-size:10px;" >
							<td>
								<div style="display:inline;float:left;margin:5px;">
									<img src="<?php echo $p['image'] ?>" style="width:30px;height:30px"/>
								</div>
								<div style="padding:5px">
									<b><?php echo "@".$p['UserID'];?></b>
							
								</div>
							</td>
			
							<td>
								<div>
									<p style="float:left"><b><?php echo $p['UserName']; ?></b></p>
									<p style="float:right"><?php echo Date('H:m:s D,d M Y',$time); ?></p>
									<p style="float:left"><?php echo get_link($p['Tweets']); ?></p>
								</div>
							</td>
		
						</tr>
	
	


		
			
				<?php	
					} 
				?>
				
			</table>
					
					<p style="float:right"><a href="<?php echo $json['url']; ?>" target="_blank">more</a></p>
		</div>	
		<?php
			
				} 
				
			}
	
			function get_link($string){

					$str = preg_split('/ /', $string, -1, PREG_SPLIT_OFFSET_CAPTURE);

				foreach($str as $cha){

						$hash=str_split($cha['0']);

						$len=count($hash);
					if($len>=4){
				
							$http=$hash['0'].$hash['1'].$hash['2'].$hash['3'];
			
						if($http=='http'){
							$hp[]=$cha['0'];

						}
					}

					if ($hash['0']=='#'){
						$hash_tag[]=$cha['0'];
					}

					if($hash['0']=='@'){
						$user[]=$cha['0'];
		
					}

				}

				if(isset($hash_tag)){
					foreach($hash_tag as $lk){
						$link= "<a target='_blank' href=hashtag.php?hash=".urlencode($lk).">".$lk."</a>";
						$string=str_replace($lk,$link,$string);
					}
				}
				if(isset($hp)){
					foreach($hp as $lk2){
						$link2= "<a target='_blank' href=".$lk2. " >".$lk2."</a>"; 
						$string=str_replace($lk2,$link2,$string); 
					}
				}
				if(isset($user)){
					foreach($user as $lk3){
						$link3="<a target='_blank' href=https://twitter.com/search/".urlencode($lk3).">".$lk3 ."</a>"; 
						$string=str_replace($lk3,$link3,$string);
		
					}
	
	
				}
	
				return $string;
			}
			
		?>
	
	
	
	</body>
</html>