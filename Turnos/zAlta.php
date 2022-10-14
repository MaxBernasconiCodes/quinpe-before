<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$hs=floatval($_POST['TxtHs']);
		//inserto
		$nroId=GLO_generoID("turnos",$conn);
		$query="INSERT INTO turnos (Id,Nombre,Horas) VALUES ($nroId,'$nombre',$hs)";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		header("Location:../Turnos.php");
	}		
}





?>