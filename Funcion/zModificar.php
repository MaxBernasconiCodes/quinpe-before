<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);





GLO_cambiotablabasica('modificar','funcion','Funcion',$_POST['TxtNombre'],intval($_POST['TxtNumero']));







?>



