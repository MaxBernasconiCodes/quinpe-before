<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php"); $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['Id'],0,0);





GLO_adjuntararchivo('','NC/','AUDI','ModificarGES','Auditoria','BannerPopUp','FooterConUsuario','iso_audi_archivos',intval($_GET['Id']));





?>