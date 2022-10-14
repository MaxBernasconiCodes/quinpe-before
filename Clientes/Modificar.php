<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");   $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT * From clientes where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre']=$row['Nombre'];
		$_SESSION['TxtApellido'] = $row['Apellido'];
		$_SESSION['TxtCUIT']= $row['Identificacion'];
		$_SESSION['CbLocalidad'] = $row['IdLocalidad'];
		$_SESSION['TxtDireccion']=  $row['Direccion'];
		$_SESSION['TxtProvincia']=  $row['Provincia'];
		$_SESSION['TxtCP']=  $row['CP'];
		$_SESSION['TxtEMail']= $row['Email']; 
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
		$_SESSION['CbActividad'] = $row['IdActividad'];
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['CbIva'] = $row['IdIva'];
		$_SESSION['CbCV'] = $row['IdCV'];
		$_SESSION['CbCC'] = $row['IdCta'];
		$_SESSION['CbLista'] = $row['IdLista'];
		$_SESSION['CbGrupo'] = $row['IdGrupo'];
		$_SESSION['TxtCodigo'] = $row['Cod'];
		$_SESSION['TxtObs2'] = $row['Vendedor'];
	}	mysql_free_result($rs);
} 

GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',1,'MenuH',0,0,0); 
include ("Includes/zCampos.php");
?>



<table width="770" border="0"  cellpadding="0" cellspacing="0">
<tr> <td height="3" ></td></tr>
<tr ><td height="18" ><i class="fa fa-phone iconsmallsp iconlgray"></i> <strong>Tel&eacute;fonos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_TablaTelefonos($_SESSION['TxtNumero'],$conn,'clitelefonos',770,0); ?>	</td></tr>
<tr> <td height="15"></td></tr>
<!--cc-->
<tr ><td height="18" ><i class="fa fa-building iconsmallsp iconlgray"></i> <strong>UTE:</strong></td></tr>
<tr> <td  align="center" ><?php CLI_MostrarTablaUTE($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15"></td></tr>
<!--cc-->
<tr ><td height="18" ><i class="fa fa-stamp iconsmallsp iconlgray"></i> <strong>Centros de Costo:</strong></td></tr>
<tr> <td  align="center" ><?php CLI_MostrarTablaCC($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
</table>
  

<? 
GLO_cierratablaform(); 
mysql_close($conn);
GLO_initcomment(770,0);
echo 'Para agregar <font class="comentario2">Localidad</font> o  <font class="comentario2">Actividad</font>, haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>