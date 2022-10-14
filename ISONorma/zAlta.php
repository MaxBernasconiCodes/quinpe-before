<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
		//inserto
		$nroId=GLO_generoID('iso_nc_norma',$conn);
		$query="INSERT INTO iso_nc_norma (Id,Nombre,FechaBaja) VALUES ($nroId,'$nombre','$fechab')";$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);} 
		mysql_close($conn); 
		//volver
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:../ISO_Norma.php");
	}		
}



?>