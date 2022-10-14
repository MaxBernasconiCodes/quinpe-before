<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_consultatablabasica('iso_nc_tipo','ISO_OrigenNC','ISO_Tablas',intval($_POST['TxtId']));



?>



