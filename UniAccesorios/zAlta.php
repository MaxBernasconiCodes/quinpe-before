<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


GLO_cambiotablabasica('alta','accesorios_tipo','UniAccesorios',$_POST['TxtNombre'],0);





?>



