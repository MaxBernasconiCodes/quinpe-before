<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(11);

GLO_adjuntartelefono('personal','modificar','Modificar','Personal','BannerPopUp','FooterConUsuario','personaltelefonos',intval($_GET['id']),intval($_GET['identidad']));

?>