<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

GLO_datostablabasica('puntospedido',intval($_GET['id']));
GLO_tablabasica(30,0,'compras','PUNTOS DE PEDIDO','BannerConMenuHV','FooterConUsuario','zModificar'); 


?>
