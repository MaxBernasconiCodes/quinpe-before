<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



GLO_datostablabasica('serviciostipo1',intval($_GET['id']));

GLOF_tablabasica(30,0,'../Servicios/MenuH','LINEA A','BannerConMenuHV','FooterConUsuario','zModificar'); 





?>