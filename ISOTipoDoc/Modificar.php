<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);





GLO_datostablabasica('iso_doc_tipo',intval($_GET['id']));

GLO_tablabasica(30,0,'sgi','TIPO DE DOCUMENTOS','BannerConMenuHV','FooterConUsuario','zModificar'); 







?>