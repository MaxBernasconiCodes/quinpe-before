<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('iso_procesos',intval($_GET['id']));

GLO_tablabasica(50,0,'sgc','PROCESOS','BannerConMenuHV','FooterConUsuario','zModificar'); 







?>