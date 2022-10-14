<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;



//perfiles
GLO_PerfilAcceso(10);



GLO_consultatablabasica('estudios','Estudios','Personal/Tablas',intval($_POST['TxtId']));





?>



