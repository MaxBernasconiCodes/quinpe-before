<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('iso_nc_tipo',intval($_GET['id']));

GLO_tablabasica(100,0,'sgi','ORIGEN NO CONFORMIDAD','BannerConMenuHV','FooterConUsuario','zModificar'); 







?>