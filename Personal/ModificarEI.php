<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT p.* From personal_expi p where p.Id<>0 and p.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaD']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaH']);
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['CbSector'] = $row['IdSector'];
		$_SESSION['TxtEval'] = $row['Puntos'];
	}mysql_free_result($rs);
}
?> 


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('TxtFechaA',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zModificarEI.php',0,0,0); ?>
<? GLO_tituloypath(0,600,'','EXPERIENCIA INTERNA','salir'); ?>


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="110"></td><td width="390"></td></tr>
<tr><td height="18"  align="right"  >Desde:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      > <?php  calendario("TxtFechaA","../Codigo/","nac"); ?> </td><td><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Hasta:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      > <?php  calendario("TxtFechaB","../Codigo/","nac"); ?></td></tr>
<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" colspan="2">&nbsp;<select name="CbSector"  tabindex="1" style="width:250px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Puntos:</td><td  valign="top" colspan="2">&nbsp;<input  name="TxtEval" type="text"  class="TextBox" style="width:60px;text-align:right" maxlength="6"  tabindex="1"   value="<? echo $_SESSION['TxtEval'];?>"  onchange="this.value=validarNumero(this.value);"></td></tr>
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