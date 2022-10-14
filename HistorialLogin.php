<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";require_once('Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaH']=$hoy;
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQHLOG'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(700,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Legajo</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."260"." class="."TablaTituloDato"."> Apellido</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."260"." class="."TablaTituloDato"."> Nombre</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';  
		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> Fecha</td>"; 
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;  $estilo="";$link="";$clase="TablaDato";
		while($row=mysql_fetch_array($rs)){ 			
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Apellido'],0,30)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,30)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFechaHora($row['Fecha'])."</td>"; 
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


GLOF_Init('TxtBusqueda','BannerConMenuHV','Intranet/zHistorialLogin',0,'',0,0,0); 
GLO_tituloypath(0,630,'Inicio.php','HISTORIAL LOGIN','linksalir');
?>

<table width="630" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="100"></td><td width="130"></td><td width="100"></td><td width="200"></td><td width="30"></td></tr>
<tr><td  align="right" >Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","Codigo/","actual",1) ?></td>     <td>al&nbsp;<? GLO_calendario("TxtFechaH","Codigo/","actual",1) ?></td><td  align="right" >Personal:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:150px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQHLOG',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(700,0);
echo 'Muestra el <font class="comentario2">Personal</font> que ingreso a <font class="comentario3">Intranet</font>';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>