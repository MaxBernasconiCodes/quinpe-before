<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFecha1'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		GLO_feedback(3);header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&ori=".intval($_POST['TxtOriPage'])."&Flag1=True");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//valido disponibilidad solicitud por simultaneidad
		if(intval($_POST['CbSoli'])!=0){
			$solidisponible=0;$id=intval($_POST['TxtNumero']);$soli=intval($_POST['CbSoli']);
			$query="SELECT r.* From pedidosrep r where ((r.IdOrden=0 and r.IdEstado=1) or r.IdOrden=$id) and r.Id=$soli";
			$rs=mysql_query($query,$conn);while($row=mysql_fetch_array($rs)){$solidisponible=1;}mysql_free_result($rs);
		}else{$solidisponible=1;}
		//si esta disponible grabo
		if($solidisponible==0){
			$_SESSION['GLO_msgE']="La Solicitud no esta disponible"; 
		}else{
			if (empty($_POST['TxtFecha1'])){$fecha1=date("Y-m-d");}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}	
			if (empty($_POST['TxtFecha3'])){$fecha3="0000-00-00";}else{$fecha3=FechaMySql($_POST['TxtFecha3']);}
			if (empty($_POST['TxtFecha4'])){$fecha4="0000-00-00";}else{$fecha4=FechaMySql($_POST['TxtFecha4']);}
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$uni=intval($_POST['CbUnidad']); 
			$soli=intval($_POST['CbSoli']);
			$soli1=intval($_POST['CbSoli1']);//inicial, para ver si se cambia
			$estord=intval($_POST['TxtIdEstadoO']);
			$id=intval($_POST['TxtNumero']);
			//update
			$query="UPDATE pedidosrepord set Fecha='$fecha1',IdSoli=$soli,FechaI='$fecha3',FechaE='$fecha4',Obs='$obs' Where Id=$id";		
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);
				//marco solicitud
				if($soli!=$soli1){//cambi&oacute;?						
					if ($soli!=0){//asigo orden a la solicitud
						$query="UPDATE pedidosrep set IdEstado=3,IdOrden=$id Where IdOrden=0 and Id=$soli";
						$rs=mysql_query($query,$conn);
					}						
					if ($soli1!=0){//desasigno orden a la solicitud anterior y la pongo en solicitado
						$query="UPDATE pedidosrep set IdEstado=1,IdOrden=0 Where IdOrden=$id and Id=$soli1";
						$rs=mysql_query($query,$conn);
					}
					REP_updateestadoorden($conn,intval($_POST['TxtNumero']),0);//emitida a emitida, o rechazada a emitida
				}
			}else{GLO_feedback(2); } 
		}
		
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&ori=".intval($_POST['TxtOriPage'])."&Flag1=True");
	}
}

elseif (isset($_POST['CmdControl'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarControl.php?Flag1=True&id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdVerEq'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Articulos/Ver.php?id=".intval($_POST['CbInstrumento']));
}

elseif (isset($_POST['CmdEntregar'])){
	if(intval($_POST['TxtIdEstadoO'])==5 or intval($_POST['TxtIdEstadoO']==6)){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$orden=intval($_POST['TxtNumero']);
		//marco solicitud retirada(5)
		$query="Update pedidosrep set IdEstado=5 Where IdOrden=$orden";$rs=mysql_query($query,$conn);
		//marco orden cerrada(8) o entregada c/pdtes(9)
		if(intval($_POST['TxtIdEstadoO']==5)){REP_estadoorden($conn,8,$orden);}
		if(intval($_POST['TxtIdEstadoO']==6)){REP_estadoorden($conn,9,$orden);}
		mysql_close($conn); 
	}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdBEntregar'])){
	if(intval($_POST['TxtIdEstadoO'])==8 or intval($_POST['TxtIdEstadoO']==9)){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$orden=intval($_POST['TxtNumero']);$idsoli=intval($_POST['CbSoli']);
		if(intval($_POST['TxtIdEstadoO'])==8){REP_estadoorden($conn,5,$orden);}
		if(intval($_POST['TxtIdEstadoO'])==9){REP_estadoorden($conn,6,$orden);}
		REP_estadosolicitud($conn,4,$idsoli);
		mysql_close($conn); 
	}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdAddReq'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaReq.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdBorrarFilaReq'])){
	$query="Delete From pedidosrepreq Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);REP_updateestadoorden($conn,intval($_POST['TxtNumero']),0);}
	else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdFilaVisto'])){
	$query="Update pedidosrepreqsoli set Estado=1 Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdFilaPdte'])){
	$query="Update pedidosrepreqsoli set Estado=0 Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdAltaSoli'])){//Altas solicitud desde el taller
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	//datos
	if (empty($_POST['TxtFecha1'])){$fecha1=date("Y-m-d");}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}	
	$uni=intval($_POST['CbUnidad']); 
	$sec=intval($_POST['CbSector']);
	$ins=intval($_POST['CbInstrumento']);
	$id=intval($_POST['TxtNumero']);
	//inserto solicitud
	$nroId=GLO_generoID('pedidosrep',$conn);
	$query="INSERT INTO pedidosrep (Id,IdUnidad,IdSector,IdInstr,Fecha,FechaSI,IdEstado,IdTipo,IdPersonal,IdOrden) VALUES ($nroId,$uni,$sec,$ins,'$fecha1','$fecha1',3,0,0,$id)";$rs=mysql_query($query,$conn);  //estado aceptado	
	if ($rs){
		//update orden
		$query="UPDATE pedidosrepord set IdSoli=$nroId Where Id=$id";$rs=mysql_query($query,$conn);
		if ($rs){
			//inserto requerimiento en solicitud
			$nroId2=GLO_generoID('pedidosrepreqsoli',$conn);
			$query="INSERT INTO pedidosrepreqsoli(Id,IdPR,Fecha,Urg,Obs,Estado) VALUES ($nroId2,$nroId,'$fecha1',1,'Solicitud de Taller',0)";
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		}
	}
	mysql_close($conn); 
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdImprimir'])){
	include("../FPDF/fpdf.php");
	include ("Includes/zPDFOT.php");
}





?>


