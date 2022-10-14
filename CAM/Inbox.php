<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php") ;include("../Procesos/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQCAMIB'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(990,1,0,0);
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Cliente</td>";  
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Producto</td>"; 		
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Lote</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>"; 
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Solicitud</td>';
		$tablaclientes .='<td width="90" class="TableShowT"> Etapa</td>';
		$tablaclientes .='<td width="50" class="TableShowT"> </td>';
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$clase="TableShowD";$estilo='';$link='';
		while($row=mysql_fetch_array($rs)){ 
			if($row['Etapa']=='INGRESO'){$colore=' TBlue';}else{$colore=' TGreen';}	
			if($row['Retorno']==0){$ret='';}else{$ret='Retorno';}
			//		
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Cliente'],0,30)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Item'],0,30)."</td>";			
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Lote'],0,15)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Rto'],0,15)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.$row['IdProc']."</td>"; 
			$tablaclientes .='<td  class="TableShowD'.$colore.'"'.$link.'>'.substr($row['Etapa'],0,10)."</td>"; 
			$tablaclientes .='<td  class="TableShowD TRed"'.$link.'>'.$ret."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR" >'.GLO_rowbutton("CmdAddFila",$row['Id'].'|'.$row['IdEtapa'],"Alta Certificado",'self','certif','iconlgray','Alta Certificado',1,0,0)."</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}

function CAM_CbTipoEtapa($campo){
	$combo='';
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."INGRESO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."INGRESO"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."FORMULADO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."FORMULADO"."</option>\n";}
	if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."CARGA PROPIO"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."CARGA PROPIO"."</option>\n";}
	echo $combo;
}


//html
GLOF_Init('','BannerConMenuHV','zInbox',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'../Inicio.php','ANALISIS PENDIENTES','linksalir');
?>


<table width="700" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="170"></td><td width="70"></td><td width="170"></td><td width="70"></td><td width="100"></td><td width="50"></td></tr>
<tr> <td height="18" align="right">Cliente:</td><td >&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td height="18" align="right">Producto:</td><td>&nbsp;<select name="CbProducto" class="campos" id="CbProducto"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("items","CbProducto","Nombre","","and Tipo=0",$conn); ?></select></td><td height="18" align="right">Etapa:</td><td>&nbsp;<select name="CbTipoC" class="campos" id="CbTipoC"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><option value=""></option><? echo CAM_CbTipoEtapa('CbTipoC');?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCAMIB',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo '<font class="comentario2">Ingresos</font> de <font class="comentario3">Barrera</font> por Ingreso o Retorno<br>';
echo '<font class="comentario2">Formulados</font> generados en <font class="comentario3">Planta</font> <br>';
echo '<font class="comentario2">Egresos</font> por Carga de productos propios generados en <font class="comentario3">Planta</font> ';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>