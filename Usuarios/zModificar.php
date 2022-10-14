<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbPerfil']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtUsuario']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$perf=intval($_POST['CbPerfil']); 
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		//update		
		$query="UPDATE usuarios set IdPerfil=$perf,FechaBaja='$fechab' Where Usuario='".mysql_real_escape_string($_POST['TxtUsuario'])."'";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:../Usuarios.php");
	}
}




?>

