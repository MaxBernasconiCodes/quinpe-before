<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and  $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','Articulos/Fotos/','FART','Modificar','Foto','BannerPopUp','FooterConUsuario','epparticulos',intval($_GET['Id']));
?>