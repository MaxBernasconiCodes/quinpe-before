<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php"); $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);


GLO_adjuntararchivo('','Adjuntos/','INCIDENTE','Modificar','Incidente','BannerPopUp','FooterConUsuario','incidentesarchivos',intval($_GET['Id']));


?>