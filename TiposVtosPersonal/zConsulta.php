<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);





GLO_consultatablabasica('personalvtos_tipos','TiposVtosPersonal','Personal/Tablas',intval($_POST['TxtId']));



?>