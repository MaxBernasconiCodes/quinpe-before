<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);


GLO_consultatablabasica('programas_tipo','ISO_TipoPrograma','ISOProgramas/Consulta',intval($_POST['TxtId']));

?>

