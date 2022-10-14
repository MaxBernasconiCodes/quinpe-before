<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (empty($_SESSION['TxtFechaDCP'])){

	$fecha=date('Y-m-j');

	$desde = strtotime ( '-12 month' , strtotime ( $fecha ) ) ;$_SESSION['TxtFechaDCP']=date("d-m-Y", $desde );

	$hasta = strtotime ( '+6 month' , strtotime ( $fecha ) ) ;$_SESSION['TxtFechaHCP']=date("d-m-Y", $hasta );

}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zSeguimiento',0,0,0,0);

GLO_tituloypath(0,700,'../ISO_Planes.php','SEGUIMIENTO TAREAS','linksalir'); 

?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >

<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="70"></td><td width="110"></td><td width="70"></td><td width="110"></td><td width="30"></td></tr>

<tr> <td height="18"  align="right">Inicio Prog:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaDCP","../Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaHCP","../Codigo/","actual",1); ?></td><td align="right">Lugar:</td><td>&nbsp;<select name="CbYac"  tabindex="1" style="width:80px" class="campos" id="CbYac" ><option value=""></option> <? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?> </select></td><td align="right" >Estado:</td><td><select name="CbEstado"  tabindex="1" style="width:80px;" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("plan_e","CbEstado","Orden","","",$conn); ?> </select></td><td align="right" ><? GLO_Search('CmdBuscar',0);?></td></tr>

</table>



<? 

GLO_Hidden('TxtQISOPLAT',0);

GLO_mensajeerror();

PL_TablaSeguimiento($conn);

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>