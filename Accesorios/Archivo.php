<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','Accesorios/','ACC','Modificar','Foto','BannerPopUp','FooterConUsuario','accesorios',intval($_GET['Id']));
?>