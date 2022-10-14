<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtNombre']) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaPendiente.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}
		$ident=intval($_POST['TxtNroEntidad']);
		$obs=mysql_real_escape_string($_POST['TxtNombre']);
		$pers=intval($_POST['CbPersonal']);
		$est=intval($_POST['OptE']);
		//inserto		
		$nroId=GLO_generoID("iso_cambios_plan",$conn);
		$query="INSERT INTO iso_cambios_plan (Id,IdPadre,Obs,IdPersonal,Estado,Fecha) VALUES ($nroId,$ident,'$obs',$pers,$est,'$fecha')";
		$rs=mysql_query($query,$conn);
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

