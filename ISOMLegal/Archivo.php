<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(15);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','SGIDoc/Anexos/','MLEGAL','Modificar','Ruta','BannerPopUp','FooterConUsuario','iso_matriz',intval($_GET['Id']));
?>