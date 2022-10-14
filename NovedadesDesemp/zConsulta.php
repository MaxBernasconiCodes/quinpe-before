<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);



GLO_consultatablabasica('personal_destipo','NovedadesDesemp','Personal/Tablas',intval($_POST['TxtId']));



?>



