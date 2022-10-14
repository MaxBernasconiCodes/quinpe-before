<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(10);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('funcion',intval($_GET['id']));

GLOF_tablabasica(50,0,'../Personal/MenuH','FUNCION','BannerPopUp','FooterConUsuario','zModificar'); 





?>