<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_cambiotablabasica('alta','iso_nc_tipo2','ISO_TipoNC',$_POST['TxtNombre'],0);





?>



