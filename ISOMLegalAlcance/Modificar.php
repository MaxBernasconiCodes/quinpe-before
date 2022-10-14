<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);



GLO_datostablabasica('iso_matriz_a',intval($_GET['id']));

GLO_tablabasica(50,0,'sgi','ALCANCE MATRIZ LEGAL','BannerConMenuHV','FooterConUsuario','zModificar'); 





?>