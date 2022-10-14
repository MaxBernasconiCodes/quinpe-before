<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$obs=mysql_real_escape_string($_POST['TxtObs']);
	$id=intval($_POST['TxtNumero']);
	//estado planta(esto es porque al escalar tuve que adaptar)
	if(intval($_POST['CbEstadoP']==0)){$estadop=1;}else{$estadop=3;}
	//observaciones
	$query="UPDATE despacho set Obs='$obs',IdEstadoP=$estadop Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtLocPage']=1;//planta
	header("Location:../Despacho/ModificarItem.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}


//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id pedido para volver
	$_SESSION['TxtOriOPESoli']=5;//id etapa para volver
	header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}


//alta rtos
elseif ( isset($_POST['CmdAltaRtoEC'])){
	//valido deposito y tipo
	if( empty($_POST['CbDep3']) or empty($_POST['CbPropietarioEC']) ){
		$_SESSION['GLO_msgE']='Por favor seleccione Deposito y Propietario';
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A3');
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//egreso x carga
		$tipo=4;$ori=4;
		$dep=intval($_POST['CbDep3']); 
		$cli=intval($_POST['CbPropietarioEC']);
		include("Includes/zInsertaMov.php"); 
		//volver
		mysql_close($conn); 
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A3');
	}
	
}

elseif ( isset($_POST['CmdAltaRtoEIF'])){
	//valido deposito y tipo
	if( empty($_POST['CbDep']) or empty($_POST['CbDep2']) or empty($_POST['CbPropietarioEF'])  or empty($_POST['CbPropietarioIF']) ){
		$_SESSION['GLO_msgE']='Por favor seleccione los Depositos y Propietario';
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A3');
	}else{	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//egreso x formulado
		$tipo=4;$ori=3;
		$dep=intval($_POST['CbDep']);
		$cli=intval($_POST['CbPropietarioEF']);
		include("Includes/zInsertaMov.php");
		//ingreso x formulado
		$tipo=3;$ori=3;
		$dep=intval($_POST['CbDep2']);
		$cli=intval($_POST['CbPropietarioIF']);
		include("Includes/zInsertaMov.php");
		//volver
		mysql_close($conn); 
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A3');
	}
}

elseif (isset($_POST['CmdBorrarFilaRto'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From stockmov Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 	
	header("Location:ModificarP.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}





?>


