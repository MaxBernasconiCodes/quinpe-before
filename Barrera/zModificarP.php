<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("../FPDF/fpdf.php");
//perfiles
GLO_PerfilAcceso(13);


//modificar propios y terceros persona

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
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero']));
	}else{//terceros
		if ( $_POST['CbTipo']==2 and intval($_POST['CbProv'])!=0 and intval($_POST['CbCliente'])!=0 ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
			$_SESSION['GLO_msgE']='Transportista puede ser Proveedor o Cliente, por favor seleccione uno solo';
			header("Location:ModificarP.php?id=".intval($_POST['TxtNumero']));
		}else{	
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include ("Includes/zDatosP.php");
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
		}
	}
}

elseif (isset($_POST['CmdBuscarCH'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$id=intval($_POST['TxtNumero']);//id	
	$doc=trim($_POST['TxtDoc']);
	if($doc!=''){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//traigo el ultimo registro de ese dni
		$query="SELECT * FROM procesosop_e2 Where DNI='$doc' and DNI<>'' and Id<>$id Order by Id desc LIMIT 1";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
			$_SESSION['TxtChofer'] = $row['Chofer'];
		}else{GLO_feedback(27);}mysql_free_result($rs);
		mysql_close($conn); 
	}else{$_SESSION['GLO_msgE']='Ingrese un DNI a buscar';}
	header("Location:ModificarP.php?id=".intval($_POST['TxtNumero']));
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
		header("Location:AltaP.php");
	}else{//terceros
		$_SESSION['CbCliente']=$_POST['CbCliente'];
		$_SESSION['CbProv']=$_POST['CbProv'];
		$_SESSION['TxtDoc']=$_POST['TxtDoc'];
		header("Location:AltaT.php");
	}
}

	
/*
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);//id
	$etapa=1;//0:ingreso,1:salida
	//insert
	$nroId=GLO_generoID('procesosop_e2',$conn);
	$query="INSERT INTO procesosop_e2 (Id,IdPadre,Tipo,Fecha,Hora,IdChofer,Chofer,DNI,IdProv,IdCli,Obs,Temp,Olf,Etapa) Select $nroId as Id,IdPadre,Tipo,Fecha,Hora,IdChofer,Chofer,DNI,IdProv,IdCli,Obs,Temp,Olf, $etapa as Etapa From procesosop_e2 Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0;} 
	mysql_close($conn); 
	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarP.php?id=".$nroId."&Flag1=True");
	}else{
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
	*/	
	






?>