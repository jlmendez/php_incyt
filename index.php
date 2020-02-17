<?php
//index.php
//$connect = mysqli_connect("localhost", "root", "", "testing");
$array = array();
// PHP Data Objects(PDO) Sample Code:
try {
    $connect = new PDO("sqlsrv:server = tcp:iotserviciogis.database.windows.net,1433; Database = iotgis", "incyt", '1358$oxalacetato');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "incyt", "pwd" => '1358$oxalacetato', "Database" => "iotgis", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:iotserviciogis.database.windows.net,1433";
$connect = sqlsrv_connect($serverName, $connectionInfo);

$sql = 'select * from v_ise2_infr_Zdat';
$result = query(query)<<_query($connect, $query);
$rows = array();
$table = array();



/*$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'infrasonido_1', 
  'type' => 'number'
 )
);

<<<<<<< HEAD

foreach($connect->query($sql) as $row )
||||||| merged common ancestors
while($row = sqlsrv_fetch_array($result))
=======
foreach($connect->query($sql) as $row )
>>>>>>> 8332d70b2ce2b12aa6fb59d15359112124e5a60b
{
 $sub_array = array();
 $datetime = explode(".", $row["fecha_recepcion"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["infrasonido_1"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);
*/
while( $row = sqlsrv_fetch_array( $sql))    
{  
    $array[] = array($row[1],$row[2]);
}
$addrows = json_encode($array);

?>

<script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'fecha_recepcion');
    data.addColumn('string', 'infrasonido_1');
    data.addColumn('string', 'ToolTip');

    data.addRows(<?php echo $addrows; ?>);
?>


<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
    /*---------------------------------------------*/
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'fecha_recepcion');
    data.addColumn('string', 'infrasonido_1');
    data.addColumn('string', 'ToolTip');

    data.addRows(<?php echo $addrows; ?>);
    /*---------------------------------------------*/

    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Display Google Line Chart with JSON PHP & Mysql</h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>