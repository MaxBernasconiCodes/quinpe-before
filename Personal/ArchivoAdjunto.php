<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('personal','Adjuntos/','PERHABADJ','ModificarVto','Vencimiento','BannerPopUp','FooterConUsuario','personalvtos_a',intval($_GET['Id']));


?> 






