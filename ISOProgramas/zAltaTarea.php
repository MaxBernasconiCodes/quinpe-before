<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);



if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['CbCliente']) and empty($_POST['CbUnidad']) and empty($_POST['CbPersonal']) and empty($_POST['CbServicio']) and empty($_POST['TxtNombre']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}	
		GLO_feedback(3);header("Location:AltaTarea.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatosTA.php");	
		//inserto
		$nroId=GLO_generoID("programas_t",$conn);
		$query="INSERT INTO programas_t (Id,IdP,Obs,Obs2,Obs3,IdCliente,IdUnidad,IdPersonal,IdServicio,Otro".$wqi1.") VALUES ($nroId,$ident,'$obs','$obs2','$obs3',$cli,$uni,$per,$serv,'$nom'".$wqi2.")";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);}
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

