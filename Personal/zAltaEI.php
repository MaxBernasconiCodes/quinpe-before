<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){ 
	if ((empty($_POST['TxtFechaA'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:AltaEI.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}			
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$sec=intval($_POST['CbSector']);
		$punt=floatval($_POST['TxtEval']);
		//inserto
		$nroId=GLO_generoID('personal_expi',$conn);
		$query="INSERT INTO personal_expi (Id,IdEntidad,FechaD,FechaH,Obs,IdSector,Puntos) VALUES ($nroId,$ident,'$fechaa','$fechab','$obs',$sec,$punt)"; $rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:AltaEI.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaEI.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A7');
}



?>

