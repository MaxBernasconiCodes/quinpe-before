<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['Id'],0,0);


GLO_adjuntararchivo('','Prov/','PROV','Modificar','Registro','BannerPopUp','FooterConUsuario','proveedores_adj',intval($_GET['Id']));


?>