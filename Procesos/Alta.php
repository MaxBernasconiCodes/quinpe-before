<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAlta',0,'',0,0,0); 
GLO_tituloypath(0,700,'Procesos.php','PROCESO','linksalir');
?>

<table width="700" border="0"  cellspacing="0" class="TablaBuscar" >
<tr> <td width="100" height="5"  ></td> <td width="160"></td><td width="100"></td> <td width="340"></td></tr>
<tr> <td height="18"  align="right"  >Proceso:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td align="right"  >Cliente:</td><td>&nbsp;<select name="CbCliente"  tabindex="1"  class="campos" id="CbCliente"  tabindex="1" style="width:250px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION[TxtNumero])==0){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?></select><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right" valign="top" >Observaciones:</td><td  valign="top" colspan="3">&nbsp;<textarea name="TxtObs" style="width:580px" rows="5" tabindex="2" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea></td></tr>
</table> 

<?
GLO_Hidden('TxtId',0);
GLO_guardar(700,3,0);
GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>