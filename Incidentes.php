<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("Incidentes/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}

//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaD','BannerConMenuHV','Incidentes/zConsulta',0,0,0,0);
GLO_tituloypath(0,700,'Inicio.php','INCIDENTES/ACCIDENTES','linksalir');
?>

<table width="700" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="90"></td><td width="100"></td><td width="140"></td><td width="80"></td><td width="110"></td><td width="80"></td><td width="100"></td></tr>
<tr> <td height="18" align="right">&nbsp;Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFechaH","Codigo/","actual",2); ?></td><td height="18" align="right">Sector:</td><td>&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td height="18" align="right">Estado:</td><td>&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? INC_cbestado("CbEstado"); ?></select></td><td></td></tr>

<tr><td height="18" align="right">Personal:</td><td  colspan="2">&nbsp;<select name="CbPersonal" style="width:180px" class="campos"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn);  ?></select></td><td height="18" align="right">Lugar:</td><td>&nbsp;<select name="CbYac" class="campos" id="CbYac"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?></select></td><td height="18" align="right"></td><td align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQINCID',0);
GLO_linkbutton(700,'Agregar','Incidentes/Alta.php','','','','');
GLO_mensajeerror();
INCID_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>