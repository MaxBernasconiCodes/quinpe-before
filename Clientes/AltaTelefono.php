<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





GLO_adjuntartelefono('clientes','alta','Modificar','Cliente','BannerPopUp','FooterConUsuario','clitelefonos',intval($_GET['id']),intval($_GET['identidad']));







?>