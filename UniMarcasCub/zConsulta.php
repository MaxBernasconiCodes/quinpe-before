<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

GLO_consultatablabasica('unidades_marcascub','UniMarcasCub','Unidades/Tablas',intval($_POST['TxtId']));



?>

