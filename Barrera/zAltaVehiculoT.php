<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);


//alta terceros vehiculo
		
if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtHora']) or empty($_POST['TxtDoc']) or empty($_POST['CbTipo'])  or empty($_POST['CbTipo2']) or   empty($_POST['CbEtapa']) or (empty($_POST['CbProv']) and empty($_POST['CbCliente']))  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);
		if(empty($_POST['CbProv']) and empty($_POST['CbCliente'])){$_SESSION['GLO_msgE']="Por favor complete Cliente o Proveedor propietario del camion";}
		header("Location:AltaVehiculoT.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$tipocambio=1;//insert
		include ("Includes/zDatosVehiculo.php");
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarVehiculo.php?id=".$nroId."&Flag1=True");	
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaVehiculoT.php");
		}	
		
	}
}





?>