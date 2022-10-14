<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;



//perfiles
GLO_PerfilAcceso(10);



GLO_cambiotablabasica('modificar','estudios','Estudios',$_POST['TxtNombre'],intval($_POST['TxtNumero']));





?>



