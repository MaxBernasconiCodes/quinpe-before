<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT c.* From proveedores_act c  where c.Id<>0 and c.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdPadre'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbActividad'] = $row['IdActividad'];
	}mysql_free_result($rs);
}

GLOF_Init('TxtNombre','BannerPopUp','zModificarOACT',0,'',0,0,0); 
GLO_tituloypath(0,600,'','OTRAS ACTIVIDADES','salir');
?>

<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right">Actividad:</td><td>&nbsp;<select name="CbActividad" style="width:400px" class="campos"   id="CbActividad" ><option value=""></option> <? ComboTablaRFX("actividades","CbActividad","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
</table>

<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("600",0,2);
GLO_mensajeerror();
GLO_cierratablaform(); 
mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");
?>

