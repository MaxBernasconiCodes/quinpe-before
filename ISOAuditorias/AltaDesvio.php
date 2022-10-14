<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad']=$_GET['Id'];
?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zAltaDesvio.php',0,0,0); ?>

<? include ("Includes/zCamposD.php");?>

<? include ("../Codigo/FooterConUsuario.php");?>