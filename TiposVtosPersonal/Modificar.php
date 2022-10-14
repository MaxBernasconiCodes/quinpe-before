<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;

//perfiles
GLO_PerfilAcceso(10);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('personalvtos_tipos',intval($_GET['id']));

GLOF_tablabasica(50,0,'../Personal/MenuH','TIPOS HABILITACIONES','BannerPopUp','FooterConUsuario','zModificar'); 





?>