<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";


//perfiles
GLO_PerfilAcceso(10);



GLO_cambiotablabasica('alta','personal_lictipo','TipoLicencia',$_POST['TxtNombre'],0);





?>



