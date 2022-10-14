<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


GLO_cambiotablabasica('modificar','accesorios_tipo','UniAccesorios',$_POST['TxtNombre'],intval($_POST['TxtNumero']));



?>

