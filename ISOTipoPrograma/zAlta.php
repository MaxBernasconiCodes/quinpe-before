<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);


GLO_cambiotablabasica('alta','programas_tipo','ISO_TipoPrograma',$_POST['TxtNombre'],0);


?>

