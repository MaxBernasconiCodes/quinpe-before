<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivoupdate('accesorios','Accesorios/','ACCVTO','ModificarCE','Programacion','BannerPopUp','FooterConUsuario','accesorios_prog',intval($_GET['Id']));

?>