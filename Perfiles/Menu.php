<?php  include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";  ?>

<script language="javascript">
function items(id){
	var obj = document.getElementById('ul' + id)
	if(obj.style.display == 'block') obj.style.display = 'none'
	else obj.style.display = 'block'  
}
function ocultaItems(id){
	listado = document.getElementById('listaUls'+ id)
	contenedores = listado.getElementsByTagName('ul')
	numContenedores = contenedores.length
	for(m=0; m < numContenedores; m++){
	if(contenedores[m].id.indexOf('ul') == 0)
	contenedores[m].style.display = 'none'     }  
}  
</script>


<td valign="top" > 
<table  border="0" cellspacing="0" cellpadding="0"   >
<tr><td valign="top">	
<?
$estiloboton=' type="submit" class="botontransparente" onClick="document.Formulario.target='."'_self'".'" ';
$seleccionado=' style="font-weight:bold;text-transform: uppercase;color: #4CAF50;" ';

echo '<div id="menumanual"><ul>
<li><input name="Cmd0" value="Administracion" '.$estiloboton; if($_SESSION['TxtIdManual']==0){echo $seleccionado;} echo '></li>
<li><input name="Cmd8" value="Barrera" '.$estiloboton; if($_SESSION['TxtIdManual']==8){echo $seleccionado;} echo '></li>
<li><input name="Cmd1" value="Coordinador" '.$estiloboton; if($_SESSION['TxtIdManual']==1){echo $seleccionado;} echo '></li>
<li><input name="Cmd2" value="General" '.$estiloboton; if($_SESSION['TxtIdManual']==2){echo $seleccionado;} echo '></li>
<li><input name="Cmd6" value="HSE" '.$estiloboton; if($_SESSION['TxtIdManual']==6){echo $seleccionado;} echo '></li>
<li><input name="Cmd3" value="Mantenimiento" '.$estiloboton; if($_SESSION['TxtIdManual']==3){echo $seleccionado;} echo '></li>
<li><input name="Cmd4" value="RRHH " '.$estiloboton; if($_SESSION['TxtIdManual']==4){echo $seleccionado;} echo '></li>
<li><input name="Cmd5" value="SGI Externo" '.$estiloboton; if($_SESSION['TxtIdManual']==5){echo $seleccionado;} echo '></li>
<li><input name="Cmd7" value="SGI Externo Limitado" '.$estiloboton; if($_SESSION['TxtIdManual']==7){echo $seleccionado;} echo '></li>
</ul></div>';
?>    
</td></tr>
</table>
</td>
