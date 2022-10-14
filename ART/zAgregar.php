<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);





GLO_cambiotablabasica('agregar','art','ART',$_POST['TxtNombre'],0);



?>



