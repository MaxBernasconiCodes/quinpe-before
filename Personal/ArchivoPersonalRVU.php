<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);//file
GLO_ValidaGET($_GET['IdP'],0,0);//padre


GLO_filesu('Adjuntos/','APRV','RankingVial','BannerPopUp','FooterConUsuario','personalarchivosrv',intval($_GET['Id']),intval($_GET['IdP']));
?> 

