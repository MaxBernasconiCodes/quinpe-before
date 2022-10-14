<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);



GLO_consultatablabasica('art','ART','Personal/Tablas',intval($_POST['TxtId']));



?>



