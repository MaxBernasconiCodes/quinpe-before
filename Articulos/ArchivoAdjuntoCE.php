<? include("../Codigo/Seguridad.php") ; include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";





//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['Id'],0,0);



GLO_adjuntararchivo('','Adjuntos/','INSTRVTOADJ','ModificarCE','Certificacion','BannerPopUp','FooterConUsuario','instrumentosprog_a',intval($_GET['Id']));





?> 













