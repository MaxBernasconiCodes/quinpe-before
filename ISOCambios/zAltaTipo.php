<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['CbTipo']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}	
		GLO_feedback(3);	
		header("Location:AltaTipo.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$tipo=intval($_POST['CbTipo']);
		//inserto
		$nroId=GLO_generoID("iso_cambios_t1",$conn);
		$query="INSERT INTO iso_cambios_t1 (Id,IdPadre,IdTipo) VALUES ($nroId,$ident,$tipo)";$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

