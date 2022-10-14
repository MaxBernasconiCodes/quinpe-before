<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbCliente']) or empty($_POST['TxtUsuario']) or empty($_POST['TxtNombre']) or empty($_POST['TxtApellido']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$usuario=mysql_real_escape_string(ltrim($_POST['TxtUsuario'])); 
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$ap=mysql_real_escape_string(ltrim($_POST['TxtApellido']));	
		//update		
		$query="UPDATE clientes_usr set Usuario='$usuario',FechaBaja='$fechab',Nombre='$nom',Apellido='$ap' Where Id='".intval($_POST['TxtNumero'])."'";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:../UsuariosC.php");
	}
}


if (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../UsuariosC.php");
}




?>

