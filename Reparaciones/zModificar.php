<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFecha1']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fecha1=GLO_FechaMySql($_POST['TxtFecha1']);	
		$fecha2=GLO_FechaMySql($_POST['TxtFecha2']);
		$fecha3=GLO_FechaMySql($_POST['TxtFecha3']);
		$fecha4=GLO_FechaMySql($_POST['TxtFecha4']);
		$uni=intval($_POST['CbUnidad']); 
		$tipo=intval($_POST['CbTipo']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$pers=intval($_POST['CbPersonal']);
		$id=intval($_POST['TxtNumero']);
		//update
		$query="UPDATE pedidosrep set Fecha='$fecha1',FechaSI='$fecha2',IdTipo=$tipo,IdPersonal=$pers Where Id=$id";	
		$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
		mysql_close($conn);
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&ori=".intval($_POST['TxtOriPage'])."&Flag1=True");
	}
}

elseif (isset($_POST['CmdRechazar'])){
	header("Location:AltaOrdenDSoliR.php?id=".intval($_POST['TxtNumero']));//pasa el nro de solicitud
}


elseif (isset($_POST['CmdAltaOrden'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$fecha1=date("Y-m-d");	
	$uni=intval($_POST['CbUnidad']); 
	$sec=intval($_POST['CbSector']);
	$ins=intval($_POST['CbInstrumento']);
	$soli=intval($_POST['TxtNumero']);
	$wq1='';$wq2='';
	for ($i=1; $i < 19; $i= $i +1) {$wq1=$wq1.",I".$i;}
	for ($i=1; $i < 19; $i= $i +1) {$wq2=$wq2.",0";}
	//insert
	$nroId=GLO_generoID('pedidosrepord',$conn);
	$query="INSERT INTO pedidosrepord (Id,IdUnidad,IdSector,IdInstr,Fecha,FechaI,FechaE,FechaIT,IdEstado,Km,Hs,Obs,IdSoli,IdPersonalPL,FechaPL,ObsPL,ListoPL".$wq1.") VALUES ($nroId,$uni,$sec,$ins,'$fecha1','0000-00-00','0000-00-00','0000-00-00',1,0,0,'',$soli,0,'0000-00-00','',0".$wq2.")"; 
	$rs=mysql_query($query,$conn); 
	if ($rs){
		$grabook=1;REP_updateestadoorden($conn,$nroId,1);
		//asigo orden a la solicitud
		if ($soli!=0){
			$query="UPDATE pedidosrep set IdOrden=$nroId,IdEstado=3 Where IdOrden=0 and Id=$soli";$rs=mysql_query($query,$conn);
		}			
	}else{GLO_feedback(2);$grabook=0; } //error al grabar
	mysql_close($conn); 			
	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarOrden.php?id=".$nroId."&Flag1=True");
	}else{
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&ori=".intval($_POST['TxtOriPage'])."&Flag1=True");
	}			
}


elseif (isset($_POST['CmdAddReqSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaReqSoli.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdBorrarFilaReqSoli'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From pedidosrepreqsoli Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn);
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (  isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	if(intval($_POST['TxtOriPage'])==2){header("Location:../Unidades/Modificar.php?id=".intval($_POST['CbUnidad'])."&Flag1=True");}
	else{header("Location:Solicitudes.php");}
}


?>


