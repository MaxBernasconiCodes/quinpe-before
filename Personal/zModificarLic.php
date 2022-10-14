<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbTipo']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarLic.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);		
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$tipo=intval($_POST['CbTipo']);
		//actualizo
		$query="UPDATE personal_lic set FechaD='$fechaa',FechaH='$fechab',Obs='$obs',IdTipo=$tipo Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarLic.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}






elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A4');
}


?>


