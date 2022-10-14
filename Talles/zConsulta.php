<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);





GLO_consultatablabasica('personaltalles_el','Talles','Personal/Tablas',intval($_POST['TxtId']));



?>