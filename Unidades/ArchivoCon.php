<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";


//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('unidades','Adjuntos/','UNICON','ModificarCon','Registro','BannerPopUp','FooterConUsuario','unidades_cona',intval($_GET['Id']));


?> 






