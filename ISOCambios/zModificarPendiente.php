<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarPendiente.php?id=".intval($_POST['TxtNumero']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}
		$ident=intval($_POST['TxtNroEntidad']);
		$obs=mysql_real_escape_string($_POST['TxtNombre']);
		$pers=intval($_POST['CbPersonal']);
		$est=intval($_POST['OptE']);
		//actualizo
		$query="UPDATE iso_cambios_plan set Obs='$obs',IdPersonal=$pers,Estado=$est,Fecha='$fecha' Where Id=".intval($_POST['TxtNumero']);
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

