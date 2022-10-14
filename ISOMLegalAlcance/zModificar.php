<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);





GLO_cambiotablabasica('modificar','iso_matriz_a','ISO_MLegalAlcance',$_POST['TxtNombre'],intval($_POST['TxtNumero']));







?>



