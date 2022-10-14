<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From iso_nc_norma Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Norma.php"); 	
}

if (isset($_POST['CmdAgregar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Alta.php");
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../ISO_Tablas.php");
}

?>

