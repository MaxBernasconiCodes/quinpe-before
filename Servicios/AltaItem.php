<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad']=str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);//id servicio

//busco nombre
$query="SELECT IdCliente From servicios where Id<>0 and Id=".intval($_GET['Id']); $rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtIdCliente']=  $row['IdCliente'];}
mysql_free_result($rs);


GLOF_Init('','BannerPopUp','zAltaItem',0,'',0,0,0); 
GLO_tituloypath(0,500,'','ITEM','salir'); 
?> 



<table width="500" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr> <td height="18"  align="right"  >Item:</td><td  valign="top" >&nbsp;<select name="CbItem" style="width:350px" class="campos" id="CbItem"  tabindex="1"><option value=""></option><? ComboTablaRFX("items","CbItem","Nombre","","and Inactivo=0",$conn); ?></select></td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtIdCliente',0);
GLO_guardar("500",2,0);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>