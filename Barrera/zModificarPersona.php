<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);


//modificar persona propios y terceros 

if (isset($_POST['CmdAceptar'])){
	$requeridos=0;
	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtHora'])){$requeridos=1;}
	if ( $_POST['CbTipo']==1 and (empty($_POST['CbPersonal'])) ){$requeridos=2;}
	if ( $_POST['CbTipo']==2 and empty($_POST['CbProv']) and empty($_POST['CbCliente'])){$requeridos=3;	}
	//
	if ( $requeridos!=0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);
		if ( $requeridos==3){$_SESSION['GLO_msgE']="Por favor complete Cliente o Proveedor";}
		header("Location:ModificarPersona.php?id=".intval($_POST['TxtNumero']));
	}else{//terceros
		if ( $_POST['CbTipo']==2 and intval($_POST['CbProv'])!=0 and intval($_POST['CbCliente'])!=0 ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
			$_SESSION['GLO_msgE']='Transportista puede ser Proveedor o Cliente, por favor seleccione uno solo';
			header("Location:ModificarPersona.php?id=".intval($_POST['TxtNumero']));
		}else{	
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$tipocambio=2;//update
			include ("Includes/zDatosPersona.php");
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:ModificarPersona.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
		}
	}
}

elseif (isset($_POST['CmdBuscarCH'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	//buscar datos dni persona
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$_SESSION['TxtChofer']=BAR_datos_persona($_POST['TxtDoc'],$_POST['TxtNumero'],$conn);
	if($_SESSION['TxtChofer']==''){GLO_feedback(27);}
	mysql_close($conn); 
	header("Location:ModificarPersona.php?id=".intval($_POST['TxtNumero']));
}



elseif ( isset($_POST['CmdAltaEgreso'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$tipo=intval($_POST['CbTipo']);//1:propio, 2:terceros
	//paso session
	$_SESSION['CbTipo']=$_POST['CbTipo'];
	$_SESSION['CbEtapa']=2;//0:ingreso,1:salida (combo muestra+1)
	$_SESSION['CbTipo2']=1;//1:persona,2:vehiculo
	//propio
	if($tipo==1){
		$_SESSION['CbPersonal']=$_POST['CbPersonal'];
		header("Location:AltaPersonaP.php");//propios 
	}else{//terceros
		$_SESSION['CbCliente']=$_POST['CbCliente'];
		$_SESSION['CbProv']=$_POST['CbProv'];
		$_SESSION['TxtDoc']=$_POST['TxtDoc'];
		header("Location:AltaPersonaT.php");
	}
}

	
	






?>