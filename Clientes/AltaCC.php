<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['Id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

?> 





<? include ("../Codigo/HeadFull.php");?>

<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('TxtNombre',0,0); ?>

<? include ("../Codigo/BannerPopUp.php");?>

<? GLO_formform('Formulario','zAltaCC.php',1,0,0);?>



<? include ("Includes/zCamposCC.php");?>   





<? include ("../Codigo/FooterConUsuario.php");?>