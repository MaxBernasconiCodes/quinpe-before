<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//por ahora hay una sola opcion
$_SESSION['OptTipo']="A";

function MostrarTabla(){
include("../Codigo/Config.php");
$query=$_SESSION['TxtConsultaCon'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(700,0,0,0);
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> N&uacute;mero</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> C&oacute;digo</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."230"." class="."TablaTituloDato"."> Nombre</td>"; 
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";
		$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."> Vs</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Creaci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Control</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Aprobaci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Expiraci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;          
		while($row=mysql_fetch_array($rs)){
			$nrodoc=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);	
			$vs=str_pad($row['Version'], 2, "0", STR_PAD_LEFT);	
			$estilo="";$colorest='';$link="";
			//fecha
			if($row['FechaCRE']!='0000-00-00'){$fecha1 =FormatoFecha($row['FechaCRE']);}else{$fecha1='';}
			if($row['FechaCON']!='0000-00-00'){$fecha2 =FormatoFecha($row['FechaCON']);}else{$fecha2='';}
			if($row['FechaAPR']!='0000-00-00'){$fecha3 =FormatoFecha($row['FechaAPR']);}else{$fecha3='';}
			if($row['FechaEXP']!='0000-00-00'){$fecha4 =FormatoFecha($row['FechaEXP']);}else{$fecha4='';}
			
			$tablaclientes .='<tr '.$estilo.'>';
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$nrodoc."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Codigo'],0,15)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Nombre'],0,45)."</td>";  			
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$vs."</td>";  			
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fecha1."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fecha2."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fecha3."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".$fecha4."</td>"; 
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	mysql_free_result($rs);mysql_close($conn);
	
}
}


GLOF_Init('','BannerConMenuHV','zControl',0,'MenuH',0,0,0); 
GLO_tituloypath(0,500,'../ISO_Doc.php','CONTROL DOCUMENTOS','linksalir'); 

?>



<table width="500" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="400"></td><td width="100"></td></tr>
<tr> <td height="18"  >&nbsp;<input name="OptTipo"  type="radio"  class="radiob"    value="A"<? if ($_SESSION['OptTipo'] =='A') echo 'checked'; ?> >Documentos obsoletos con copias sin retirar </td><td   align="right" ></td></tr>
<tr> <td height="18" > </td><td   align="right" ><input name="CmdBuscar"  type="submit" class="botonbuscar"  title="Buscar" value="" onClick="document.Formulario.target='_self'">&nbsp;</td></tr>
</table>


<table  width="500" border="0" cellspacing="0" cellpadding="0" >
<tr><td  height=3 width="400" ></td><td  height=3 width="50" ></td></tr>
<tr  valign="bottom"><td align="left" valign="bottom" ><input  name="TxtId"  type="hidden"  value="<? echo $_SESSION['TxtId']; ?>"><input  name="TxtConsultaCon"  type="hidden"   value="<? echo $_SESSION['TxtConsultaCon']; ?>"></td><td   align="right" ></td></tr>
</table>

<? 
GLO_mensajeerror();
MostrarTabla($conn);
?>

<? GLO_cierratablaform(); ?>

<? 
$_SESSION['TxtId']=""; 
$_SESSION['TxtConsultaCon']="";
$_SESSION['OptTipo']="";
?>
		



<? include ("../Codigo/FooterConUsuario.php");?>