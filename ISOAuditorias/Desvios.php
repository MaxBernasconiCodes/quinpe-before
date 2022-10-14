<? include("../Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQISOAUD3'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(950,0,0,0); 
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."180"." class="."TablaTituloDato".">Tipo</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."250"." class="."TablaTituloDato"."> Observaci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha Prog.</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha Real</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Tipo</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Sector</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Lugar </td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato".">Estado </td>";  
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato".">Detalle </td>";   
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0; $estilo="";$link="";         
		while($row=mysql_fetch_array($rs)){
			$colorestado='';$estado='';$colordetalle='';
			if ($row['IdEstado']==1) {$colorestado=' style="font-weight:bold;color:#00bcd4"';$estado='PROG';}// AZUL
			if ($row['IdEstado']==2) {$colorestado=' style="font-weight:bold;color:#4CAF50"';$estado='CUMPL';}// VERDE 	
			if ($row['Anulado']==1) {$colorestado=' style="font-weight:bold;color:#f44336"';$estado='ANULADA';}//ROJO
			//fecha
			if($row['FechaProg']!='0000-00-00'){$fechap =FormatoFecha($row['FechaProg']);}else{$fechap='';}
			if($row['FechaReal']!='0000-00-00'){$fechar =FormatoFecha( $row['FechaReal']);}else{$fechar='';}
			//detalle
			$detalle='';
			if (($row['IdEstado']==1 or $row['IdEstado']==2 ) and ($row['Anulado']==0)) {
				if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']!='0000-00-00')){//cumplido
					if (CompararFechas(FormatoFecha($row['FechaReal']),FormatoFecha($row['FechaProg']))==1){$detalle='CUMPL.NO PUNTUAL';}
					else{$detalle='CUMPL.PUNTUAL';}				
				}	
				if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']=='0000-00-00')){//programado
					$hoy=date("d-m-Y"); 
					if (CompararFechas(FormatoFecha($row['FechaProg']),$hoy)==2){$detalle='PROG.VENCIDO';$colordetalle=' style="font-weight:bold;color:#f44336"';}
					else{$detalle='PROG.VIGENTE';}				
				}	
			}		
			
			$id=$row['Id'];
			$tablaclientes .='<tr '.$estilo.'>'; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$row['NroT'].'  '.substr($row['NombreT'],0,25)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$row['Nro'].'  '.substr($row['Desvio'],0,30)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fechap."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fechar."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Tipo'],0,6)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Sector'],0,10)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Yac'],0,10)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link.$colorestado."> ".$estado."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link.$colordetalle."> ".$detalle."</td>"; 
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	mysql_free_result($rs);
	
}
}



GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaD','BannerConMenuHV','zDesvios',0,0,0,0);
GLO_tituloypath(950,700,'../ISO_Auditorias.php','OBSERVACIONES','linksalir'); 
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="90"></td><td width="100"></td><td width="130"></td><td width="100"></td><td width="180"></td><td width="100"></td></tr>
<tr> 
<td height="18"  align="right">&nbsp;Fecha Prog:</td><td  >&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td><td  > al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td height="18" align="right">Observaci&oacute;n:</td><td   colspan="2">&nbsp;<select name="CbDesvioT" style="width:100px" class="campos" id="CbDesvioT" ><option value=""></option><? ISOAUDI_CbDesvios("CbDesvioT","iso_audi_desviost",$conn); ?></select> <select name="CbDesvio" style="width:100px" class="campos" id="CbDesvio" ><option value=""></option><? ISOAUDI_CbDesvios("CbDesvio","iso_audi_desvios",$conn); ?></select></td></tr>
<tr> <td height="18"  align="right">Sector:</td><td  colspan="2">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td>
<td  align="right">Auditoria:</td><td >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("iso_audi_tipo","CbTipo","Nombre","","",$conn); ?></select></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQISOAUD3',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
?>

<? include ("../Codigo/FooterConUsuario.php");?>