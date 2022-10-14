<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//for(var i = 0; i < dataphp.length; i++){     document.write(dataphp[i]); } //test
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart1);//cant estado
google.charts.setOnLoadCallback(drawChart2);//cant sector
google.charts.setOnLoadCallback(drawChart3);//cant categ
google.charts.setOnLoadCallback(drawChart4);//importes categ


function drawChart1() {//cant estado
  var dataphp =  <? echo '[';$i=0;foreach ( $array1 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Pedidos del Mes por Estado', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 10}}};
  var chart = new google.visualization.PieChart(document.getElementById('pie_cantest'));
  chart.draw(data, options);
}
function drawChart2() {//cant sector
  var dataphp =  <? echo '[';$i=0;foreach ( $array2 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Pedidos del Mes por Sector', 'width':500, 'height':400,'legend':{textStyle:{fontSize : 10}}};
  var chart = new google.visualization.PieChart(document.getElementById('pie_cantsec'));
  chart.draw(data, options);
}
function drawChart3() {//cant x art
  var dataphp =  <? echo '[';$i=0;foreach ( $array3 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Pedidos del Mes por Articulo (Top 6)', 'width':500, 'height':400,'legend': 'none','vAxis':{textStyle:{					fontSize : 9}}};
  var chart = new google.visualization.BarChart(document.getElementById('bar_cantart'));
  chart.draw(data, options);
}
function drawChart4() {//cant x prov
  var dataphp =  <? echo '[';$i=0;foreach ( $array4 as $ElemArray ){ if($i>0){echo ',';} if($i==0){echo "['".$ElemArray[0]."','".$ElemArray[1]."']";$i++;}else{echo "['".$ElemArray[0]."',".$ElemArray[1]."]";$i++;}}echo ']'; ?>;
  var data = google.visualization.arrayToDataTable(dataphp);
  var options = {'title':'Pedidos del Mes por Proveedor (Prov. O.Compra)', 'width':500, 'height':400,'legend': 'none','vAxis':{textStyle:{fontSize : 9}}};
  var chart = new google.visualization.BarChart(document.getElementById('bar_cantprov'));
  chart.draw(data, options);
}



</script>


<table class="columns">
  <tr>
    <td><? if(!(is_null($array1[1][0]))){echo '<div id="pie_cantest" style="border: 1px solid #ccc"></div>';echo '&nbsp;Estado de los Pedidos registrados<BR><BR><BR>';}?></td>
    <td><? if(!(is_null($array2[1][0]))){echo '<div id="pie_cantsec" style="border: 1px solid #ccc"></div>';echo '&nbsp;Sector de los Pedidos registrados<BR><BR><BR>';}?></td>
  </tr>
  <tr>
    <td><? if(!(is_null($array3[1][0]))){echo '<div id="bar_cantart" style="border: 1px solid #ccc"></div>';echo '&nbsp;Art&iacute;culos mas solicitados en los Pedidos registrados';}?></td>
    <td><? if(!(is_null($array4[1][0]))){echo '<div id="bar_cantprov" style="border: 1px solid #ccc"></div>';echo '&nbsp;Proveedores de las Ordenes de Compra generadas';}?></td>
  </tr>
</table>


<?
//limpio arrays
unset($array1);unset($array2);unset($array3);unset($array4);
?>