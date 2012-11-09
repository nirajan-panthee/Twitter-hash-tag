<html>
	<head>
		<script type="text/javascript" src="jquery-latest.js"></script>
		<script src="highcharts.js"></script>
		<script src="modules/exporting.js"></script>
		<script src="themes/grid.js"></script>
		<script type="text/javascript">
		$(function(){
		$('#click').click(function() {
			$('#content').animate({
				//opacity: 0.25,
				//left: '+=50',
				//height: '410px'
				//if(css.marginTop=='0'){
					marginTop:'-220px'
				//}
				//else{
				//	marginTop:'0px'
				//}
			}, 500);
		});
		$('#click_user').click(function() {
			$('#content').animate({
				//opacity: 0.25,
				//left: '+=50',
				//height: '410px'
				//if(css.marginTop=='0'){
					marginTop:'0px'
				//}
				//else{
				//	marginTop:'0px'
				//}
			}, 500);
		});
		});
		</script>
	</head>
	<body>
		
		<div id="content_graph" style="width:615px;height:219px;overflow:hidden;">
			<div id="content" style="margin-top:0px">
			<?php

				//include 'connection.php';
				include 'graph_all.php';
				include 'graph_user.php';
			?>
			</div>
		</div>
	</body>
</html>