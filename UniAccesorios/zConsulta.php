<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


GLO_consultatablabasica('accesorios_tipo','UniAccesorios','Accesorios/Consulta',intval($_POST['TxtId']));



?>

