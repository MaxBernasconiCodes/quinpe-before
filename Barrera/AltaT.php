<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);
 
//alta terceros

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['TxtHora'])){ $_SESSION['TxtHora']=date("H:i");}


//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaT',0,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA','linksalir');
?>
<table width="760" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="200"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="1" value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);">&nbsp;<select name="CbEtapa" class="campos" id="CbEtapa"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',0);?></select><label class="MuestraError"> * </label></td><td align="right"  >Camion/Persona:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:100px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoUnidadT('CbTipo');?></select><label class="MuestraError"> * </label></td></tr>
</table>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Cliente:</td><td >&nbsp;<select name="CbCliente"  tabindex="3" style="width:250px" class="campos" id="CbCliente" ><option value="">Seleccione Cliente</option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"  >Tipo:</td><td>&nbsp;<select name="CbTipo2" style="width:100px" class="campos" tabindex="4" id="CbTipo2" ><option value=""></option><? echo PROC_CbTipoBarrera("CbTipo2");?></select><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td >&nbsp;<select name="CbProv"  tabindex="3" style="width:250px" class="campos" id="CbProv" ><option value="">Seleccione Proveedor</option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select></td><td align="right"  >Dni Persona/Conductor:</td><td>&nbsp;<input name="TxtDoc" type="text"  tabindex="4" class="TextBox"  maxlength="13"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" /><label class="MuestraError"> * </label></td></tr>
</table>


<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_guardar(760,4,0);
GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>