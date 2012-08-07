<html>
<head>
<script type="text/javascript" src="jquery-latest.js"></script>

<script language="javascript" type="text/javascript" src="jquery.flot.js"></script>
<script type="text/javascript">
$(function () {
    //var d1 = [];
    //for (var i = 0; i < 14; i += 0.5)
       // d1.push([i, Math.sin(i)]);

    var d2 = [["ewew", 3], ["wewe", 8], ["ewe", 5], ["wew", 13]];

    // a null signifies separate line segments
    //var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];
    
    $.plot($("#placeholder"), [ d2 ]);
});
</script>
</head>
<body>
<div id="placeholder" style="width:600px;height:300px;"></div>
</body>
</html>