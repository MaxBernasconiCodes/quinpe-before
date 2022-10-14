<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);




if (isset($_POST['CmdAceptar'])){ 
	if (intval($_POST['CbReq'])==0){ 
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}				
	    GLO_feedback(3);header("Location:AltaReq.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$req=intval($_POST['CbReq']);
		$tipo=intval($_POST['OptTipo']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$nc=intval($_POST['CbNC']);
		//inserto 
		$nroId=GLO_generoID("iso_audi_progreq",$conn);
		$query="INSERT INTO iso_audi_progreq (Id,IdAudiP,IdReq,Tipo,Obs,IdNC) VALUES ($nroId,$ident,$req,$tipo,'$obs',$nc)";
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


if (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}

?>