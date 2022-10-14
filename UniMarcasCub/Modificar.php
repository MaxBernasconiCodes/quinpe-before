<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);
//get
GLO_ValidaGET($_GET['id'],0,0);

GLO_datostablabasica('unidades_marcascub',intval($_GET['id']));
GLO_tablabasica(40,0,'unidades','MARCAS CUBIERTAS','BannerConMenuHV','FooterConUsuario','zModificar'); 


?>

