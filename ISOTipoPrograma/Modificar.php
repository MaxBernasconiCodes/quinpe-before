<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['id'],0,0);


GLO_datostablabasica('programas_tipo',intval($_GET['id']));
GLO_tablabasica(40,0,'','TIPO DE PROGRAMAS','BannerPopUp','FooterConUsuario','zModificar'); 



?>