<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('','Programas/','APR','Modificar','Programa','BannerPopUp','FooterConUsuario','programas_adj',intval($_GET['Id']));


?>