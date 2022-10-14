<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(16);



if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}	
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$obs=mysql_real_escape_string(ltrim($_POST['TxtObs']));
		//update
		$query="UPDATE iso_tiporef set Nombre='$nombre',Obs='$obs' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);} 
		mysql_close($conn); 
		//volver
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Consulta.php");
	}		
}

?>