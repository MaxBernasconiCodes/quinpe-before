<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['id'],0,0);

GLO_datostablabasica('accesorios_tipo',intval($_GET['id']));
GLOF_tablabasica(40,0,'../Accesorios/MenuH','ELEMENTOS','BannerConMenuHV','FooterConUsuario','zModificar'); 


?>

