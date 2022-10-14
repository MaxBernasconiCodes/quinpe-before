<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

GLO_cambiotablabasica('modificar','unidades_marcascub','UniMarcasCub',$_POST['TxtNombre'],intval($_POST['TxtNumero']));



?>

