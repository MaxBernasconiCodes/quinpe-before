<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQuery74'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,0,0,0);
		$tablaclientes .="<table width="."900"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Area</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Equipo</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."420"." class="."TablaTituloDato"."> Detalle</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Estado</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Cumpl.</td>";   
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;  $estilo="";$clase="TablaDato";$link="";
		while($row=mysql_fetch_array($rs)){ 
			$fechai = FormatoFecha($row['FechaI']);if ($fechai=='00-00-0000'){$fechai="";}
			$fecha = FormatoFecha($row['Fecha']);if ($fecha=='00-00-0000'){$fecha="";}
			$fecha2 = FormatoFecha($row['Fecha2']);if ($fecha2=='00-00-0000'){$fecha2="";}
			//muestro
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link." > ".$fechai."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Yac'],0,12)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Centro'],0,12)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato".$link."> ".$fecha."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Obs'],0,50)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Estado'],0,12)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class="."TablaDato".$link."> ".$fecha2."</td>"; 
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	
}
}


GLOF_Init('','BannerConMenuHV','zDetalle',0,'',0,0,0); 
GLO_tituloypath(0,700,'../InspeccionesSMA.php','DETALLE INSPECCIONES','linksalir');
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="100" ></td><td width="100"></td><td width="140"></td><td  width="90"></td><td width="170"></td><td  height=3 width="100"></td></tr>
<tr><td  align="right" >Fecha Insp.:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td><td  > al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td  align="right" >Equipo:</td><td>&nbsp;<select name="CbCentro" class="campos" id="CbCentro"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboEquipos("CbCentro","epparticulos",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery74',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>