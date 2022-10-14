<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;

//perfiles
GLO_PerfilAcceso(10);





GLO_datostablabasica('categorias',intval($_GET['id']));

GLOF_tablabasica(50,0,'../Personal/MenuH','CATEGORIAS','BannerPopUp','FooterConUsuario','zModificar'); 





?>