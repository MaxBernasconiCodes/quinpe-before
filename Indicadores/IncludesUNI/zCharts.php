<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=9){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart1);
//google.charts.setOnLoadCallback(drawChart2);
google.charts.setOnLoadCallback(drawChart3);
google.charts.setOnLoadCallback(drawChart4);

function drawChart1() {
  var dataphp =  <? echo '[';$i=0;foreach ( $array1 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Unidades por Sector', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 9}}};
  var chart = new google.visualization.PieChart(document.getElementById('chart1'));
  chart.draw(data, options);
}

/*
function drawChart2() {
  var dataphp =  <? echo '[';$i=0;foreach ( $array2 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Unidades por Servicio', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 9}}};
  var chart = new google.visualization.PieChart(document.getElementById('chart2'));
  chart.draw(data, options);
}
*/

function drawChart3() {
  var dataphp =  <? echo '[';$i=0;foreach ( $array3 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Unidades por Categoria', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 9}}};
  var chart = new google.visualization.PieChart(document.getElementById('chart3'));
  chart.draw(data, options);
}


function drawChart4() {
  var dataphp =  <? echo '[';$i=0;foreach ( $array4 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Unidades por estado', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 9}}};
  var chart = new google.visualization.PieChart(document.getElementById('chart4'));
  chart.draw(data, options);
}

</script>


<table class="columns">
  <tr>
    <td><? if(!(is_null($array1[1][0]))){echo '<div id="chart1" style="border: 1px solid #ccc"></div>';}?></td>
    <td><? //if(!(is_null($array2[1][0]))){echo '<div id="chart2" style="border: 1px solid #ccc"></div>';}?></td>
  </tr>
  <tr>
    <td><? if(!(is_null($array3[1][0]))){echo '<div id="chart3" style="border: 1px solid #ccc"></div>';} ?></td>
    <td><? if(!(is_null($array4[1][0]))){echo '<div id="chart4" style="border: 1px solid #ccc"></div>';}  ?></td>
  </tr>
  <tr>
    <td><? ?></td>
    <td><? ?></td>
  </tr>
</table>


<?
//limpio arrays
unset($array1);
//unset($array2);
unset($array3);unset($array4);
?>