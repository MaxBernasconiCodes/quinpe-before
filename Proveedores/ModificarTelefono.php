<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_adjuntartelefono('proveedores','modificar','Modificar','Proveedores','BannerConMenuHV','FooterConUsuario','provtelefonos',intval($_GET['id']),intval($_GET['identidad']));





?>