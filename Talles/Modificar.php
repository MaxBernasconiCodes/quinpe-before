<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;

//perfiles
GLO_PerfilAcceso(10);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('personaltalles_el',intval($_GET['id']));

GLOF_tablabasica(30,0,'../Personal/MenuH','TALLES','BannerPopUp','FooterConUsuario','zModificar'); 





?>