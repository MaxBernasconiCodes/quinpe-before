<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);



if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbCliente']) and empty($_POST['CbUnidad']) and empty($_POST['CbPersonal']) and empty($_POST['CbServicio']) and empty($_POST['TxtNombre']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}
		GLO_feedback(3);header("Location:ModificarTarea.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatosTA.php");		
		//actualizo
		$query="UPDATE programas_t set Obs='$obs',Obs2='$obs2',Obs3='$obs3',IdCliente=$cli,IdUnidad=$uni,IdPersonal=$per,IdServicio=$serv,Otro='$nom' Where Id=".intval($_POST['TxtNumero']);
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


