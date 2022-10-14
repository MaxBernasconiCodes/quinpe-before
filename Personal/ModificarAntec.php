<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if ($_GET['Flag1']=="True"){
	$query="SELECT p.* From personal_antec p where p.Id<>0  and p.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaD']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaH']);
		$_SESSION['TxtOrg'] = $row['Org'];
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}
?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('TxtFechaA',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zModificarAntec.php',0,0,0); ?>
<? GLO_tituloypath(0,600,'','ANTECEDENTES LABORALES','salir'); ?>

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="110"></td><td width="390"></td></tr>
<tr><td height="18"  align="right"  >Desde:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      > <?php  calendario("TxtFechaA","../Codigo/","nac"); ?> </td><td><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Hasta:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      > <?php  calendario("TxtFechaB","../Codigo/","nac"); ?></td></tr>
<tr><td height="18"  align="right"  >Organizaci&oacute;n:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtOrg" type="text"  class="TextBox" style="width:450px" maxlength="50"  value="<? echo $_SESSION['TxtOrg']; ?>"><label class="MuestraError"> * </label></td></tr>
</table>

<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(600,100,'Observaciones','TxtObs',2,0);
GLO_botonesform("600",0,2);
GLO_mensajeerror();            
GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>