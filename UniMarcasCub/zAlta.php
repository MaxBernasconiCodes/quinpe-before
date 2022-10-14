<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

GLO_cambiotablabasica('alta','unidades_marcascub','UniMarcasCub',$_POST['TxtNombre'],0);


?>

