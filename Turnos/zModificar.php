<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$hs=floatval($_POST['TxtHs']);
		$query="UPDATE turnos set Nombre='$nombre',Horas=$hs  Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); //cierro la conexion con la db
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = "";	}
		header("Location:../Turnos.php");
	}		
}






?>