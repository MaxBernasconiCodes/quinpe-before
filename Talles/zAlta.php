<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";


//perfiles
GLO_PerfilAcceso(10);



GLO_cambiotablabasica('alta','personaltalles_el','Talles',$_POST['TxtNombre'],0);





?>