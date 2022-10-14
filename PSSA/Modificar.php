<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php"); 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
$query="SELECT p.* From pssa p  where p.Id<>0 and p.Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtAnio'] = $row['Year'];
	$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaA']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}

}mysql_free_result($rs);
} 


GLOF_Init('TxtAnio','BannerConMenuHV','zModificar',0,'',0,0,0);
GLO_tituloypath(0,700,'../PSSA.php','PSSA','linksalir');

?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80" height="3"  ></td> <td width="130"></td><td width="70" height="3"  ></td><td width="130"></td><td width="100"></td> <td width="190"></td></tr>
<tr> <td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top">&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:60px"></td><td align="right"  >A&ntilde;o:</td><td  valign="top">&nbsp;<input name="TxtAnio" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="4"  value="<? echo $_SESSION['TxtAnio']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Actualizado:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?> </td></tr>
</table>

	                    


<? 
GLO_Hidden('TxtId',0);
PSSA_TablaItems($_SESSION['TxtNumero'],$conn);
GLO_botonesform("1160",0,2); 
GLO_mensajeerror();
GLO_exportarform(1160,1,0,0,0,0);
?>
     
     
<!--adjuntos-->
<table width="800" border="0"  cellpadding="0" cellspacing="0" class="TMT" >
<tr ><td><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"><?php PSSA_VerTablaArchivos($_SESSION['TxtNumero'],$conn,"pssa_archivos",800,"Adjuntos/",'1'); ?>	</td></tr>
</table>
     

<? 
mysql_close($conn); 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php")
?>