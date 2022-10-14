<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtFecha1']=date("d-m-Y");
$_SESSION['CbSoli'] = str_pad(intval($_GET['id']), 6, "0", STR_PAD_LEFT);
$query="SELECT r.IdUnidad,u.Dominio,r.IdOrden From pedidosrep r,unidades u where r.Id<>0 and r.IdUnidad=u.Id and r.Id=".intval($_GET['id']); 
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['CbUnidad'] = $row['Dominio'];
	$_SESSION['TxtIdUnidad'] = str_pad($row['IdUnidad'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtIdOrden'] = $row['IdOrden'];
}mysql_free_result($rs);


GLOF_Init('CbUnidad','BannerPopUp','zAltaOrdenDSoli',1,'',0,0,0);
GLO_tituloypath(0,700,'','ORDENES MANTENIMIENTO','salir');
?> 


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="80" height="3"  ></td> <td width="250"></td><td width="100" height="3"  ></td> <td width="250"></td> </tr>
<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top">&nbsp;<input  name="CbUnidad" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['CbUnidad'];?>" style="width:100px"></td><td align="right"  >Fecha Orden:</td><td  valign="top" >&nbsp;<input name="TxtFecha1" id="TxtFecha1"  tabindex="2"  type="text" readonly="true"  class="TextBoxRO"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha1']; ?>"   > </td></tr>
</table>



<?
GLO_Hidden('CbSoli',0);
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdOrden',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtIdUnidad',0);
GLO_botonesform(700,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>