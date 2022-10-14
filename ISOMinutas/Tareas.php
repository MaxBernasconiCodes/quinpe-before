<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


//completa fecha por defecto
if (empty($_SESSION['TxtFechaDCP'])){
	$fecha=date('Y-m-j');$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
	$_SESSION['TxtFechaDCP']=date("d-m-Y", $nuevafecha );
	$_SESSION['TxtFechaHCP']=date("d-m-Y");//hoy
}




function MostrarTabla($conn){
$query=$_SESSION['TxtQISOMINAP'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Marco de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(840,0,0,0);
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Minuta</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Hora</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato".">Actividad</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato".">Responsable</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Estado</td>";   
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;$estilo="";$link="";       
		while($row=mysql_fetch_array($rs)){
			if($row['Fecha']!='0000-00-00'){$fecha =FormatoFecha($row['Fecha']);}else{$fecha='';}	
			$hora1=date("H:i",strtotime($row['Hora'])); if ($hora1=='00:00'){$hora1="";}
			//estado
			if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
			if($row['Estado']==1){$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
			if($row['Estado']==2){$estado='Cancelada';$colorestado=' style="color:#cc0099;vertical-align:top"';}
			//
			$tablaclientes .='<tr '.$estilo.'>';
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link." style='text-align:right;'> ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fecha."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$hora1."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Obs'],0,60)."</td>";  			
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Ap'].' '.$row['Nom'],0,15)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link.$colorestado."> ".$estado."</td>"; 
			$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);		
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	
}
}



function ComboEstadoTarea(){
$combo="";
if( "1" == $_SESSION['CbEstado']) { $combo .= " <option value="."'1'"." selected='selected'>"."PENDIENTES"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PENDIENTES"."</option>\n";}
if( "2" == $_SESSION['CbEstado']) { $combo .= " <option value="."'2'"." selected='selected'>"."REALIZADAS"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."REALIZADAS"."</option>\n";}
if( "3" == $_SESSION['CbEstado']) { $combo .= " <option value="."'3'"." selected='selected'>"."CANCELADAS"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."CANCELADAS"."</option>\n";}
echo $combo;
}



GLOF_Init('','BannerConMenuHV','zTareas',0,'',0,0,0); 
GLO_tituloypath(0,600,'../ISO_Minutas.php','ACTIVIDADES ASIGNADAS','linksalir');
?>


<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="140"></td><td width="70"></td><td width="150"></td><td width="70"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<input name="TxtFechaDCP"  id="TxtFechaDCP" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaDCP']; ?>"   >
<?php  calendario("TxtFechaDCP","../Codigo/","actual"); ?>
</td><td  > al&nbsp;<input name="TxtFechaHCP"  id="TxtFechaHCP" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaHCP']; ?>"   >
<?php  calendario("TxtFechaHCP","../Codigo/","actual"); ?></td><td height="18" align="right">Estado:</td><td   colspan="1">&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboEstadoTarea(); ?></select></td><td   align="right" ><input name="CmdBuscar"  type="submit" class="botonbuscar"  title="Buscar" value="" onClick="document.Formulario.target='_self'">&nbsp;</td></tr>
</table>


<table  width="600" border="0" cellspacing="0" cellpadding="0" >
<tr><td  height=3 width="710" ></td></tr>
<tr  valign="bottom"><td align="left" valign="bottom" ><input  name="TxtQISOMINAP"  type="hidden"   value="<? echo $_SESSION['TxtQISOMINAP']; ?>"></td>	</tr>
</table>

<? 
GLO_mensajeerror();
MostrarTabla($conn);
?>

<? GLO_cierratablaform(); ?>

<? mysql_close($conn);
$_SESSION['TxtQISOMINAP']=""; 
?>
		



<? include ("../Codigo/FooterConUsuario.php");?>