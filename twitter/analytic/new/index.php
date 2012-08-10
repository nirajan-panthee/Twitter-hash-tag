<html>
	<head>
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="jqplot.dateAxisRenderer.min.js"></script>
		<script type="text/javascript" src="jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="jqplot.cursor.min.js"></script>
		<script type="text/javascript" src="jqplot.highlighter.min.js"></script>
		<!--script type="text/javascript" src="jqplot.dragable.min.js"></script-->
		<!--script type="text/javascript" src="jqplot.trendline.min.js"></script-->
		<link rel="stylesheet" type="text/css" hrf="jquery.jqplot.min.css" />
	
		<script type="text/javascript">
		
			$(document).ready(function () {
 
					$.jqplot.config.enablePlugins = true;
 
					s1 = [['2011',1],['2012',4],['2014',2],['2015', 6]];
 
					plot1 = $.jqplot('chart1',[s1],{
							title: 'Highlighting, Dragging, Cursor and Trend Line',
						axes: {
							xaxis: {
										renderer: $.jqplot.DateAxisRenderer,
								tickOptions: {
									formatString: '%#m/%#d/%y'
								},
								numberTicks: 4
							},
							yaxis: {
								tickOptions: {
									formatString: '$%.2f'
								}
							}
						},
						highlighter: {
							sizeAdjust: 10,
							tooltipLocation: 'n',
							tooltipAxes: 'y',
							tooltipFormatString: '<b><i><span style="color:red;">H:100</br>S:90</br>T:80</br></span></i></b> %.2f',
							useAxesFormatters: false
						},
						cursor: {
							show: true
						}
					});
			});
		
		</script>
	</head>

	<body>
	
		<div id="chart1" style="position:relative"></div>
	
	
	
	
	
	</body>
</html>
