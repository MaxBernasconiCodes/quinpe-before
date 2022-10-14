<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);



GLO_cambiotablabasica('modificar','programas_tipo','ISO_TipoPrograma',$_POST['TxtNombre'],intval($_POST['TxtNumero']));



?>

