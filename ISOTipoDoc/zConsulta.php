<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_consultatablabasica('iso_doc_tipo','ISO_TipoDoc','ISO_Tablas',intval($_POST['TxtId']));



?>



