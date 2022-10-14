<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

//Estados: 1.abierto/2.cumplido/3.cerrado/4.incumplido/5.reprogramado
//cumplido:FechaPlazo-FechaCumpl
//cerrado:FechaPrevista-FechaCierre
//fechacumpl=0  estado=1
//fechacumpl<>0  estado=2
//fechacierre<>0  estado=3
//fechacierre<>0 y nuevanc!=0 estado=4






function ComboISO_Nueva($conn){ 
$query="SELECT Id FROM iso_nc where Id<>0 order by Id";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbNuevaNC']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected";
   $combo .= "'>".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</option>\n";
 }else{  $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</option>\n";  }
}
echo $combo;mysql_free_result($rs); 
}

function NC_TablaArchivos($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT * From iso_nc_archivos where IdNC=$idpadre Order by Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .="<table width="."600"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."540"." class="."TablaTituloDato"."> Descripci&oacute;n</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."60"." class="."TablaTituloDatoR".">"; 
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
$tablaclientes .=GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn');}
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Descripcion'],0,70)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=' <input name="CmdVerFile" type="submit"  class="botonlupa"  value="" id="'.$row['Id'].'" onclick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_blank'".';">';  
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
		$tablaclientes .=' <input name="CmdBorrarFilaA" type="submit"  class="botonborrar"  value="" id="'.$row['Id'].'" onclick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_self'".';return confirm('."'Eliminar'".');">'; 
	} 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);

}



?>