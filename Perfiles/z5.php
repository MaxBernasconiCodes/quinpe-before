<? include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";

//SGI Externo

?>





<table width="480" border="0"  cellpadding="0" cellspacing="0"  >

<tr > <td valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="SGI"></td><td valign="bottom"  width="160"></td><td height="20"  valign="bottom"  width="160"></td> </tr>

<tr> 














<td  class="textomanual" valign="top"><div id="menuv" > <ul id="listaUls2" >

<?  

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;AUDITORIAS </li>';

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;CAMBIOS </li>';

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;DOCUMENTOS </li>';	

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;EXTERNOS </li>';

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;NO CONFORM</li>';

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;MATRIZ LEGAL </li>';

//	

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;MINUTAS </li>';	

//

echo '<li onclick="ocultaItems(2)" id="items">&nbsp;&nbsp;TABLAS </li>';

?>

</ul><script type="text/javascript">ocultaItems(2)</script></div>

</td>





<td  class="textomanual" valign="top"></td>

<td  class="textomanual" valign="top"></td>





</tr></table>