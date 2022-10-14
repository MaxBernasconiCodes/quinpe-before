<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


GLO_adjuntarcomentario('personal','alta','Modificar','Personal','BannerPopUp','FooterConUsuario','personalcomentarios',intval($_GET['id']),intval($_GET['identidad']));



?>