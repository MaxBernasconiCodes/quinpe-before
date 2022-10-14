<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_cambiotablabasica('alta','iso_procesos','ISO_Procesos',$_POST['TxtNombre'],0);





?>



