<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_consultatablabasica('iso_procesos','ISO_Procesos','ISO_Tablas',intval($_POST['TxtId']));



?>



