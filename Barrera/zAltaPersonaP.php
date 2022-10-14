<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(13);


//alta  persona propios
	
if (isset($_POST['CmdAceptar'])){
	//unidad no es requerido porque registran a los que vienen en bici/caminando
	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtHora']) or empty($_POST['CbTipo']) or empty($_POST['CbTipo2']) or empty($_POST['CbPersonal']) or empty($_POST['CbEtapa'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:AltaPersonaP.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$tipocambio=1;//insert
		include ("Includes/zDatosPersona.php");
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarPersona.php?id=".$nroId."&Flag1=True");//persona
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaPersonaP.php");
		}	
		
	}
}





?>