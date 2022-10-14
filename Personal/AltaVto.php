<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('CbTipo',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zAltaVto.php',1,0,0); ?>

<? include ("Includes/zCamposVtos.php");?>

<? GLO_cierratablaform(); ?>
<? mysql_close($conn);?>			

<? include ("../Codigo/FooterConUsuario.php");?>