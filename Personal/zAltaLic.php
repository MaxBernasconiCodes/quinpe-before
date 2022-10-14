<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbTipo']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:AltaLic.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);		
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$tipo=intval($_POST['CbTipo']);
		//inserto
		$nroId=GLO_generoID('personal_lic',$conn);
		$query="INSERT INTO personal_lic (Id,IdEntidad,FechaD,FechaH,Obs,IdTipo) VALUES ($nroId,$ident,'$fechaa','$fechab','$obs',$tipo)";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarLic.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaLic.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}



elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A4');
}



?>

