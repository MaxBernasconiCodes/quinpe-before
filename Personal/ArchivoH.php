<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_fileupdate('','Adjuntos/','PERHAB','ModificarVto','Certif','BannerPopUp','FooterConUsuario','personalvtos',intval($_GET['Id']));
?>
