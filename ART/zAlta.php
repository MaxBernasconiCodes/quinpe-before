<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(10);



GLO_cambiotablabasica('alta','art','ART',$_POST['TxtNombre'],0);





?>



