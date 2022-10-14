<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);



if (isset($_POST['CmdAceptar'])){
	//valida que seleccione alguno, pero solo uno
	$error=ASIG_validarquien(intval($_POST['CbInstrumento']),intval($_POST['CbUnidad']));
	if ( $error==1 ){
		$error=$_SESSION['GLO_msgE'];
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		$_SESSION['GLO_msgE']=$error;	
		header("Location:AltaAsignacion.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosA.php"); 
		ASIG_validarfecha(0,$idinstr,$fechasok,$fechaa,$fechae,$fechab,$conn);
		//verifico si grabo
		if($fechasok==1){	
			//inserto 
			$nroId=GLO_generoID('accesorios_asig',$conn);
			$query="INSERT INTO accesorios_asig (Id,IdInstrumento,FechaD,FechaH,IdUnidad,Obs,IdPersonal,TIndef,FechaE) VALUES ($nroId,$idinstr,'$fechaa','0000-00-00',$uni,'$obs',$pers,$ti,'$fechae')";$rs=mysql_query($query,$conn);	
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 	
			//desconecto
			mysql_close($conn); 	
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			//vuelvo
			if(intval($_SESSION['TxtOriACCAsig'])==0){header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}else{header("Location:Asignaciones.php");}
		}else{
			//vuelvo
			mysql_close($conn); 
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaAsignacion.php?Id=".intval($_POST['TxtNroEntidad']));
		}
	}
}



elseif ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	//vuelvo
	if(intval($_SESSION['TxtOriACCAsig'])==0){header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}
	else{header("Location:Asignaciones.php");}
}

?>


