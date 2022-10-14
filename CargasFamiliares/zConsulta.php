<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";


//perfiles
GLO_PerfilAcceso(10);



GLO_consultatablabasica('personal_cargastipo','CargasFamiliares','Personal/Tablas',intval($_POST['TxtId']));



?>



