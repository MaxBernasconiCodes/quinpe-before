<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//tipo programa
$query="SELECT m.IdTipoE From programas m where m.Id=".intval($_GET['Id']);$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$_SESSION['CbTipoE'] = $row['IdTipoE'];}mysql_free_result($rs);

GLO_InitHTML($_SESSION["NivelArbol"],'TxtObs2','BannerPopUp','zAltaTarea',0,0,0,0);

include("Includes/zCamposTA.php");

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>