<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=13 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From localidades where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['TxtCP'] = $row['CP'];
	$_SESSION['CbPcia'] = $row['IdPcia'];}
mysql_free_result($rs);


GLOF_Init('TxtNombre','BannerPopUp','zModificar',0,'',0,0,0); 
GLO_tituloypath(0,600,'../Localidades.php','LOCALIDADES','linksalir');

include("zCampos.php");

GLOF_botonesform(600,0,0,2,0);
GLO_mensajeerror();
mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(600,0);
echo 'Para agregar <font class="comentario2">Provincia</font> haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>