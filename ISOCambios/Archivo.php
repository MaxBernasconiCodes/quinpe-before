<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('','SGI/','AISOCBIO','Modificar','','BannerPopUpMH','FooterConUsuario','iso_cambios_adj',intval($_GET['Id']));


?>