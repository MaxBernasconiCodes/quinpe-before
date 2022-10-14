<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['Id'],0,0);





GLO_adjuntararchivo('sgi','Adjuntos/','AISOMIN','Modificar','Minuta','BannerPopUp','FooterConUsuario','iso_minutasarchivos',intval($_GET['Id']));





?>