<? include("../Codigo/Seguridad.php") ;  $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(10);

//get

GLO_ValidaGET($_GET['id'],0,0);



GLO_datostablabasica('art',intval($_GET['id']));

GLOF_tablabasica(30,0,'../Personal/MenuH','ART','BannerPopUp','FooterConUsuario','zModificar'); 





?>



