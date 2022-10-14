<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");   $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar datos
if ($_GET['Flag1']=="True"){
	$query="SELECT r.*,p.Nombre,p.Apellido From iso_doc_resp r,personal p where p.Id=r.IdPersonal and r.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbAccion'] =$row['IdAccion'];
		$_SESSION['CbPersonal'] =$row['Apellido'].' '.$row['Nombre'];
		$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaA']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaB']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
	}
	mysql_free_result($rs);
}


GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'../ISODoc/MenuH',0,0,0); 
GLO_tituloypath(0,500,'../ISO_Resp.php','RESPONSABLE','linksalir');

?>



<table width="500" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Acci&oacute;n:</td><td  valign="top" > &nbsp; <select name="CbAccion" style="width:300px" class="campos"><option value=""></option><? ComboTablaRFX("iso_doc_acciones","CbAccion","Id","","",$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top" > &nbsp; <input name="CbPersonal" type="text"  class="TextBoxRO" style="width:300px" readonly="true" value="<? echo $_SESSION['CbPersonal']; ?>"></td></tr>
<tr><td height="18"  align="right">&nbsp;Alta:</td><td  valign="top"> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   >
<? calendario("TxtFechaA","../Codigo/","actual") ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">&nbsp;Baja:</td><td  valign="top"> &nbsp; <input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   >
<? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform("500",0,2);
GLO_mensajeerror();
mysql_close($conn);
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>