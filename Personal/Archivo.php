<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','Fotos/','P','Modificar','Foto','BannerPopUp','FooterConUsuario','personal',intval($_GET['Id']));
?>