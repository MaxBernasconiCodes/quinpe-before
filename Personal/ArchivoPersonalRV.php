<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('','Adjuntos/','APRV','RankingVial','','BannerPopUpMH','FooterConUsuario','personalarchivosrv',intval($_GET['Id']));
?>