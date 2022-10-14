<? include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";

//admin sr

?>







<table width="800" border="0"  cellpadding="0" cellspacing="0"  >

<tr > <td height="20"  valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="COMPRAS"></td><td height="20"  valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="MANTENIMIENTO"></td><td valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="OPERACIONES"></td><td valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="RRHH"></td><td valign="bottom"  width="160"><input type="button" class="botoniniciomenu"  style="width:140px;" value="SGI"></td>  </tr>

<tr> 





<td  class="textomanual" valign="top"><div id="menuv" ><ul id="listaUls3" >

<?

echo '<li onclick="ocultaItems(3);" id="items">&nbsp;&nbsp;COMPROBANTES </li>'; 

echo '<li onclick="ocultaItems(3);" id="items">&nbsp;&nbsp;ARTICULOS </li>'; 

echo '<li onclick="ocultaItems(3);" id="items">&nbsp;&nbsp;PROVEEDORES </li>'; 

echo '<li onclick="ocultaItems(3);" id="items">&nbsp;&nbsp;STOCK </li>'; 
echo '<li onclick="ocultaItems(3)" id="items">&nbsp;&nbsp;TABLAS </li>';

?>

</ul><script type="text/javascript">ocultaItems(3)</script></div></td>







<td  class="textomanual" valign="top"><div id="menuv" ><ul id="listaUls4" >

<?

echo '<li onclick="ocultaItems(4)" id="items">&nbsp;&nbsp;UNIDADES </li>';	
echo '<li onclick="ocultaItems(4)" id="items">&nbsp;&nbsp;SECTORES </li>';	
echo '<li onclick="ocultaItems(4)" id="items">&nbsp;&nbsp;REPARACIONES </li>';	

?>

</ul><script type="text/javascript">ocultaItems(4)</script></div></td>





<td  class="textomanual" valign="top"><div id="menuv" ><ul id="listaUls7" >

<?

echo '<li onclick="ocultaItems(7)" id="items">&nbsp;&nbsp;CLIENTES </li>';

?>

</ul><script type="text/javascript">ocultaItems(7)</script></div></td>







<td  class="textomanual" valign="top"><div id="menuv" ><ul id="listaUls1" >

<?  


//

echo '<li onclick="ocultaItems(1)" id="items">&nbsp;&nbsp;PERSONAL </li>'; 

echo '<li onclick="ocultaItems(1)" id="items">&nbsp;&nbsp;TABLAS</li>';

?>

</ul><script type="text/javascript">ocultaItems(1)</script></div></td>





<td  class="textomanual" valign="top"><div id="menuv" ><ul id="listaUls2" >

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

</ul><script type="text/javascript">ocultaItems(1)</script></div></td>














</tr>

</table>