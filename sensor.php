<?php
$servername = "192.168.0.16";
$username = "";
$password = "f103";
$dbname = "school";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
};

$dateTime = array();
$currentTemp = array();
$currentHumid = array();
//ctrl+f and replace PLACEHOLDER_Humidity,PLACEHOLDER_tempValue and PLACEHOLDER_timestamp with corresponding database collum names
// group by PLACEHOLDER_tempValue
$sql1 = 'SELECT PLACEHOLDER_tempValue from students ORDER BY  PLACEHOLDER_timestamp DESC';
//grab values from database, then sort by oldest
$result = "mysqli_query($conn, $sql1)";

while($row2 = mysql_fetch_array($result)) {
   echo $row1['fieldname'];
   $currentTemp = $row1;
   //debugging bullshit
};
$sql2 = 'SELECT * PLACEHOLDER_timestamp from students ORDER BY  PLACEHOLDER_timestamp DESC';
$result2 = "mysqli_query($conn, $sql2)";

while($row2 = mysql_fetch_array($result2)) {
   echo $row2['fieldname'];
    $dateTime = $row2;
    //debugging bullshit
};
$sql3 = 'SELECT * PLACEHOLDER_Humidity from students ORDER BY  PLACEHOLDER_timestamp DESC';
$result3 = "mysqli_query($conn, $sql3)";

while($row4 = mysql_fetch_array($result4)) {
   echo $row4['fieldname'];
}

//debugging bullshit
//COUNT THE NUMBER OF rows
$sql4 = 'SELECT COUNT(PLACEHOLDER_tempValue) from students';
$countTemps = "mysqli_query($conn, $sql4)";

$sql5 = 'SELECT COUNT(PLACEHOLDER_timestamp) from students';
$countDate = "mysqli_query($conn, $sql5)";

$sql6 = 'SELECT COUNT(PLACEHOLDER_Humidity) from students';
$countHumids = "mysqli_query($conn, $sql6)";

mysqli_close($conn);
?>
<html>
<head>
  <style>
 #300 {
   background-color:blue;
 }
 #400 {
   background-color:red;
 }
 #300:onclick {
   background-color:black;
   border-radius: 2px;
   #400{
     border-radius: 0px;
     background-color:red;
   }
 }
 #400:onclick {
   background-color:black;
   border-radius: 2px;
   #300{
     border-radius: 0px;
     background-color:blue;
   }
 }
 #300:onhover{
   background-color:green;
 }
 #400:onhover {
   background-color:green;
 }
 /* css */
  </style>
  <script>
  window.onload = function () {

  var dataPoints1 = [];
  var dataPoints2 = [];

  var chart = new CanvasJS.Chart("chartContainer", {
  	zoomEnabled: true,
  	title: {
  		text: "Temperature & Humidity"
  	},
  	axisX: {
  		title: "Timestamp"
  	},
  	axisY:{
  		postfix: "",
  		includeZero: false
  	},
  	toolTip: {
  		shared: true
  	},
  	legend: {
  		cursor:"pointer",
  		verticalAlign: "top",
  		fontSize: 22,
  		fontColor: "dimGrey",
  		itemclick : toggleDataSeries
  	},
  	data: [{
  		type: "line",
  		xValueType: "dateTime",
  		yValueFormatString: "#### C",
  		xValueFormatString: "hh:mm:ss TT",
  		showInLegend: true,
  		name: "Temperature",
  		dataPoints: dataPoints1
  		},
  		{
  			type: "line",
  			xValueType: "dateTime",
  			yValueFormatString: "#### %",
  			showInLegend: true,
  			name: "Humidity" ,
  			dataPoints: dataPoints2
  	}]
  });

  function toggleDataSeries(e) {
  	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
  		e.dataSeries.visible = false;
  	}
  	else {
  		e.dataSeries.visible = true;
  	}
  	chart.render();
  }

  var updateInterval = 3000;
  // initial value
  var yValue1 = 0;
  var yValue2 = 0;

  var time = [];
  time.push(<?php echo json_encode($dateTime, JSON_NUMERIC_CHECK); ?>);

  function updateChart(count) {
    //UPDATE CHART
  	count = count || 1;
  	var deltaY1, deltaY2;
/*  	for (var i = 0; i < count; i++) {
  		time.setTime(time.getTime()+ updateInterval);
  		deltaY1 = .5 + Math.random() *(-.5-.5);
  		deltaY2 = .5 + Math.random() *(-.5-.5);
*/
//PULL FROM PHP WHICH PULLS FROM SQL
// hopefully it is sorted by oldest
  	// adding random value and rounding it to two digits.
  	yValue1 = <?php echo json_encode($Temp, JSON_NUMERIC_CHECK); ?>;
  	yValue2 = <?php echo json_encode($Humid, JSON_NUMERIC_CHECK); ?>;
    //PULL FROM PHP WHICH PULLS FROM SQL
    // hopefully it is sorted by oldest
  	// pushing the new values
  	dataPoints1.push({
  		x: time.getTime(),
  		y: yValue1
  	});
  	dataPoints2.push({
  		x: time.getTime(),
  		y: yValue2
  	});
  	}
  var dateCount = <?php echo json_encode($countDate, JSON_NUMERIC_CHECK); ?>
  var tempCount = <?php echo json_encode($countTemps, JSON_NUMERIC_CHECK); ?>
  var humidCount = <?php echo json_encode($countHumids, JSON_NUMERIC_CHECK); ?>
  //add datapoint in orfer
    while ( i < dateCount){
      dataPoints1.push({
        x: time.getTime(),
        y: yValue1
      });
      i++
      //
    }
  	// updating legend text with  updated with y Value
  	chart.options.data[0].legendText = " Latest Temperature  $" + yValue1;
  	chart.options.data[1].legendText = " Latest Humidity  $" + yValue2;
  	chart.render();
  }
  // generates first set of dataPoints
  updateChart(100);
  setInterval(function(){updateChart()}, updateInterval);

  }
</script>
</head>
<body>
  <div id="chartContainer" style="height: 370px; width:100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<h1> Current humidity and temp </h1>
<div class="temps">
</div>
</form>
</body>
</html>
