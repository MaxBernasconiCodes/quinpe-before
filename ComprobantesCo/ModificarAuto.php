<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");   $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar datos
if ($_GET['Flag1']=="True"){
	$query="SELECT r.*,p.Nombre,p.Apellido From co_autorizantes r,personal p where p.Id=r.IdPersonal and r.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbSector'] =$row['IdSector'];
		$_SESSION['CbPersonal'] =$row['Apellido'].' '.$row['Nombre'];
		$_SESSION['OptTipo'] =$row['Tipo'];
		$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaA']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaB']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
		$_SESSION['TxtArchivo'] =$row['Ruta'];
	}
	mysql_free_result($rs);
}


GLOF_Init('CbSector','BannerConMenuHV','zModificarAuto',0,'',0,0,0);
GLO_tituloypath(0,600,'Autorizantes.php','AUTORIZANTE','linksalir');
?>

<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" >&nbsp;<select name="CbSector" style="width:350px" class="campos"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="CbPersonal" type="text"  class="TextBoxRO" style="width:350px" readonly="true" value="<? echo $_SESSION['CbPersonal']; ?>"></td></tr>
<tr><td height="18"  align="right">Alta:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">Baja:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",1) ?></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<input name="OptTipo"  type="radio"  class="radiob"    value="1"<? if ($_SESSION['OptTipo'] =='1') echo 'checked'; ?> >PreAutorizante   &nbsp;&nbsp;&nbsp;<input name="OptTipo"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipo'] =='2') echo 'checked'; ?> >Autorizante &nbsp;&nbsp;<label class="MuestraError"> * </label></td></tr>


<table width="600" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right">Firma Digital:</td><td  valign="top">&nbsp;<? echo GLO_FAButton('CmdArchivoH','submit','90','self','Agregar','folder','boton02').'&nbsp;&nbsp;'; if (!(empty($_SESSION['TxtArchivo']))){echo GLO_FAButton('CmdVerArchivoH','submit','90','blank','Ver','lupa','boton02').'&nbsp;&nbsp;'.GLO_FAButton('CmdBorrarArchivoH','submit','90','self','Borrar','del','boton02');}
?></td></tr>

</table>

<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtArchivo',0);
GLO_botonesform("600",0,2);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>