<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);





GLO_cambiotablabasica('modificar','iso_nc_tipo2','ISO_TipoNC',$_POST['TxtNombre'],intval($_POST['TxtNumero']));







?>



