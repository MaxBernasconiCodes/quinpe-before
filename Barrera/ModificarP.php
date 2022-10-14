<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php") ;include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

//modificar propios y terceros persona

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a1.* From procesosop_e2 a1 where a1.Id<>0 and a1.Id=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		include ("Includes/zMostrarP.php");
	}mysql_free_result($rs);	
}

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}


//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zModificarP',1,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA PERSONA '.$nometapa,'linksalir');
?>


<table width="760" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="200"></td><td width="110"></td> <td width="140"></td><td width="100"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="1" value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);">&nbsp;<select name="CbEtapa" class="campos TBold <? if(intval($_SESSION['CbEtapa'])==1){echo 'TBlue';}else{echo 'TGreen';} ?>" id="CbEtapa"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',1);?></select></td><td align="right"  >Tipo Persona:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoUnidad('CbTipo');?></select></td><td> 
<? 
//si es ingreso
if( intval($_SESSION['CbEtapa'])==1){echo GLO_FAButton('CmdAltaEgreso','submit','80','self','Alta Egreso','','boton03');}
?></td></tr>
</table>

<? 
//campos tercero/propio persona
if( intval($_SESSION['CbTipo'])==1){include ("Includes/zCamposPP.php");}//1 propio
if( intval($_SESSION['CbTipo'])==2){include ("Includes/zCamposTP.php");}//2 terceros

GLO_obsform(760,110,'Observaciones','TxtObs',3,0);

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);GLO_Hidden('TxtDocCong',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar(760,4,0);
GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");
?>