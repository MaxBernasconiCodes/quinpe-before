<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_principaltablabasica('compras','PUNTOS DE PEDIDO','PuntosPedido','BannerConMenuHV','FooterConUsuario','puntospedido',0); 

?>