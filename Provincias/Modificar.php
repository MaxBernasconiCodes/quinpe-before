<? include("../Codigo/Seguridad.php") ;  $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9  and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



GLO_datostablabasica('provincias',intval($_GET['id']));

GLO_tablabasica(30,0,'tablas','PROVINCIAS','BannerConMenuHV','FooterConUsuario','zModificar'); 



?>



