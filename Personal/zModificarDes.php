<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbTipo'])) or (empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarDes.php?id=".intval($_POST['TxtNumero']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		$per=intval($_POST['CbPersonal']);	
		$tipo=intval($_POST['CbTipo']);	
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		//actualizo
		$query="UPDATE personal_des set Fecha='$fechaa',IdTipo=$tipo,IdPersonal=$per,Obs='$obs' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A6');
	}
}





elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A6');
}



?>


