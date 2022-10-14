<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','SGIDoc/Anexos/','ANX','Modificar','Ruta','BannerPopUp','FooterConUsuario','iso_anexos',intval($_GET['Id']));
?>