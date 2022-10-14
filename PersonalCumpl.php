<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(10);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtConsulta'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(800,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Apellido</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Nombre</td>";  
		$tablaclientes .='<td class="TablaTituloLeft"></td>';   
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Cumplea&ntilde;os</td>";
		$tablaclientes .='<td class="TablaTituloLeft"></td>';   
		$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."> Edad</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';   
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Sector</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';   
		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> Funcion</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';   
		$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Localidad</td>"; 
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;          
		//Datos
		while($row=mysql_fetch_array($rs)){
			if ($row['IdLocalidad']==0){$loc="";}else{$loc=substr($row['NombreLocalidad'],0,9).' - '.substr($row['Provincia'],0,9);}
			list($a,$m,$d)=explode("-",$row['FechaNacimiento']);$cumple=intval($d)." de ".G_NombreMes($m);
			//rojo mes actual
			$hoy=date("d-m-Y"); list($dhoy,$mhoy,$ahoy)=explode("-",$hoy);
			if(intval($mhoy)==intval($m)){$estilocumple=' style="color: #f44336;font-weight:bold;"';}else{$estilocumple='';}
			//
			$tablaclientes .=" <tr> ";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .='<td class="TablaDato">'.substr($row['Apellido'],0,18)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .='<td class="TablaDato">'.substr($row['Nombre'],0,18)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .='<td class="TablaDato"'.$estilocumple.'>'.$cumple."</td>";
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .='<td class="TablaDatoR">'.edad($row['FechaNacimiento'])."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .='<td class="TablaDato">'.substr($row['Sector'],0,12)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .='<td class="TablaDato">'.substr($row['Funcion'],0,14)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .='<td class="TablaDato">'.$loc."</td>";
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);	
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

function ComboMes(){
$combo="";
if( "1" == $_SESSION['CbMes']) { $combo .= " <option value="."'1'"." selected='selected'>"."Enero"."</option>\n";}
else{$combo .= " <option value="."'1'"." >"."Enero"."</option>\n";}
if( "2" == $_SESSION['CbMes']) { $combo .= " <option value="."'2'"." selected='selected'>"."Febrero"."</option>\n";}
else{$combo .= " <option value="."'2'"." >"."Febrero"."</option>\n";}
if( "3" == $_SESSION['CbMes']) { $combo .= " <option value="."'3'"." selected='selected'>"."Marzo"."</option>\n";}
else{$combo .= " <option value="."'3'"." >"."Marzo"."</option>\n";}
if( "4" == $_SESSION['CbMes']) { $combo .= " <option value="."'4'"." selected='selected'>"."Abril"."</option>\n";}
else{$combo .= " <option value="."'4'"." >"."Abril"."</option>\n";}
if( "5" == $_SESSION['CbMes']) { $combo .= " <option value="."'5'"." selected='selected'>"."Mayo"."</option>\n";}
else{$combo .= " <option value="."'5'"." >"."Mayo"."</option>\n";}
if( "6" == $_SESSION['CbMes']) { $combo .= " <option value="."'6'"." selected='selected'>"."Junio"."</option>\n";}
else{$combo .= " <option value="."'6'"." >"."Junio"."</option>\n";}
if( "7" == $_SESSION['CbMes']) { $combo .= " <option value="."'7'"." selected='selected'>"."Julio"."</option>\n";}
else{$combo .= " <option value="."'7'"." >"."Julio"."</option>\n";}
if( "8" == $_SESSION['CbMes']) { $combo .= " <option value="."'8'"." selected='selected'>"."Agosto"."</option>\n";}
else{$combo .= " <option value="."'8'"." >"."Agosto"."</option>\n";}
if( "9" == $_SESSION['CbMes']) { $combo .= " <option value="."'9'"." selected='selected'>"."Septiembre"."</option>\n";}
else{$combo .= " <option value="."'9'"." >"."Septiembre"."</option>\n";}
if( "10" == $_SESSION['CbMes']) { $combo .= " <option value="."'10'"." selected='selected'>"."Octubre"."</option>\n";}
else{$combo .= " <option value="."'10'"." >"."Octubre"."</option>\n";}
if( "11" == $_SESSION['CbMes']) { $combo .= " <option value="."'11'"." selected='selected'>"."Noviembre"."</option>\n";}
else{$combo .= " <option value="."'11'"." >"."Noviembre"."</option>\n";}
if( "12" == $_SESSION['CbMes']) { $combo .= " <option value="."'12'"." selected='selected'>"."Diciembre"."</option>\n";}
else{$combo .= " <option value="."'12'"." >"."Diciembre"."</option>\n";}
echo $combo;
}


GLOF_Init('TxtBusqueda','BannerConMenuHV','Personal/zPersonalCumpl',0,'Personal/MenuH',0,0,0); 
GLO_tituloypath(0,400,'Personal.php','CUMPLEA&Ntilde;OS','linksalir'); 
?>



<table width="400" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="50" height="5"></td><td width="300" ></td><td width="50" ></td></tr>
<tr><td></td> <td  align="center" >Mes:&nbsp;<select name="CbMes"  class="campos" id="CbMes"  style="width:100px" ><option value=""></option><? ComboMes(); ?></select> </td><td align="right"><? GLO_Search('CmdBuscar',0); ?> &nbsp;</td></tr>
</table>

<? 
GLO_Hidden('TxtConsulta',0);
MostrarTabla($conn); 
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>