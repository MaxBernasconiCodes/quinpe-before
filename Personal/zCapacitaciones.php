<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);



if (isset($_POST['CmdBuscar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
header("Location:Capacitaciones.php?Id=".intval($_POST['TxtNroEntidad']));
}


?>

