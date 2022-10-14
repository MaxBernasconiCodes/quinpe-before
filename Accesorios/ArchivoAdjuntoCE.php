<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";


//perfiles
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['Id'],0,0);

GLO_adjuntararchivo('accesorios','Accesorios/','ACCVTOADJ','ModificarCE','Certificacion','BannerPopUp','FooterConUsuario','accesorios_prog_a',intval($_GET['Id']));


?> 






