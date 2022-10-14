<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad']=str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);//id itemscliente_serv


GLOF_Init('','BannerPopUp','zAltaLB',0,'',0,0,0); 
GLO_tituloypath(0,500,'','LINEA B','salir'); 
?> 



<table width="500" border="0"   cellspacing="0" class="tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr> <td height="18"  align="right"  >Linea B:</td><td  valign="top" >&nbsp;<select name="CbItem" style="width:350px" tabindex="1" class="campos" id="CbItem" ><option value=""></option><? ComboTablaRFX("serviciostipo","CbItem","Nombre","","",$conn); ?></select></td></tr>
<tr> <td height="18"  align="right"  >Codigo:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  tabindex="1" class="TextBox" style="width:40px" maxlength="2"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_guardar("500",2,0);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>