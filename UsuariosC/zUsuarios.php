<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ; include("../Codigo/Funciones.php") ;  $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".$_POST['TxtId']."&Flag1=True");
}


if (isset($_POST['CmdAgregar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Alta.php");
}


if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../Usuarios.php");
}

?>

