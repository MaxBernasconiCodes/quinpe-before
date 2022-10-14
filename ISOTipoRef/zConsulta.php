<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(16);


if (isset($_POST['CmdBorrarFila'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From iso_tiporef Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Consulta.php"); 	
}

if (isset($_POST['CmdAgregar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Alta.php");
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../ISOProgramas/Consulta.php");
}

?>

