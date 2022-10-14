<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:RRHH2.php");
}

?>