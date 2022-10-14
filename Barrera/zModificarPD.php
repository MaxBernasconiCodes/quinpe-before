<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(13);




if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$obs=mysql_real_escape_string($_POST['TxtObs']);
	$id=intval($_POST['TxtNumero']);
	//observaciones
	$query="UPDATE despacho set Obs='$obs' Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarPD.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id pedido para volver
	$_SESSION['TxtOriOPESoli']=3;//id etapa para volver
	header("Location:../Procesos/ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}




elseif ( isset($_POST['CmdAltaEgreso'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//init
	$grabook=0; $validaok=1;
	$id=intval($_POST['TxtNumero']);//id pedido
	$tipo=intval($_POST['CbTipo2']);//1:propio,2:terceros
	//unidad seleccionada
	$unip=intval($_POST['OptUniP']);
	$unit=intval($_POST['OptUniT']);

	//valido tipo(1:propio,2:terceros)
	if( empty($_POST['CbTipo2']) ){
		$validaok=0;$_SESSION['GLO_msgE']='Por favor seleccione propietario de la Unidad';
	}
	
	if($validaok==1){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//valido si tiene vehiculos
		if( ($tipo==1 and $unip==0) or ($tipo==2 and $unit==0) ) {
			if($tipo==1){$tabla="despacho_p";$tipounidad='PROPIA';}else{$tabla="despacho_t";$tipounidad='DE TERCEROS';}
			$query="SELECT Id FROM $tabla Where IdPadre=$id LIMIT 1";$rs=mysql_query($query,$conn);	$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)!=0){$validaok=0;}mysql_free_result($rs);
			//si no selecciono y tiene regresa
			if($validaok==0){
				mysql_close($conn); 
				$_SESSION['GLO_msgE']='Por favor seleccione una unidad '.$tipounidad;
			}
		}
		//
		if($validaok==1){
			$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
			$hora=date("H:i");
			$proc=intval($_POST['TxtNroEntidad']);//id proceso
			$ped=intval($_POST['TxtNumero']);//id pedido
			$rto=mysql_real_escape_string($_POST['TxtRto']);
			$fv="0000-00-00";
			$idchofer=0;$iduni=0;$idsemi=0;
			$chofer='';$dni='';$domi='';$domi2='';
			//
			$tipo2=2;//1:persona,2:vehiculo
			$etapa=1;//0:ingreso,1:salida
			//obtengo unidad propia
			if($tipo==1 and $unip!=0){
				$query="SELECT * FROM despacho_p Where Id=$unip";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
				if(mysql_num_rows($rs)!=0){
					$idchofer=$row['IdChofer'];$iduni=$row['IdUnidad'];$idsemi=$row['IdSemi'];
				}mysql_free_result($rs);
			}
			//obtengo unidad terceros
			if($tipo==2 and $unit!=0){
				$query="SELECT * FROM despacho_t Where Id=$unit";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
				if(mysql_num_rows($rs)!=0){
					$chofer=$row['Chofer'];$dni=$row['DNI'];$domi=$row['Dominio'];$domi2=$row['Dominio2'];
				}mysql_free_result($rs);
			}
			//inserto
			$nroId=GLO_generoID('procesosop_e1',$conn);
			$query="INSERT INTO procesosop_e1(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,IdUnidad,IdSemi,Km,Chofer,DNI,IdMarca,IdCateg,Modelo,Dominio,IdMarca2,IdCateg2,Modelo2,Dominio2,IdProv,IdCli,Rto,Mot,Chk1,Chk2,ChkU1,ChkU2,ChkU3,ChkS1,ChkS2,ChkS3,ChkC1,ChkC2,FU1,FU2,FU3,FS1,FS2,FS3,FC1,FC2,Sedro,Obs,Temp,Olf,IdPedido,Etapa,Retorno) VALUES ($nroId,$proc,$tipo,'$fecha','$hora',$idchofer,$iduni,$idsemi,0,'$chofer','$dni',0,0,'','$domi',0,0,'','$domi2',0,0,'$rto','',0,0,0,0,0,0,0,0,0,0,'$fv','$fv','$fv','$fv','$fv','$fv','$fv','$fv','','',0,0,$ped,$etapa,0)";$rs=mysql_query($query,$conn);
			if ($rs){
				$grabook=1;
				//obtengo productos y los grabo
				$query="SELECT * FROM despacho_it Where IdPadre=$id";$rs=mysql_query($query,$conn);  
				while($row=mysql_fetch_array($rs)){
					$item=$row['IdIC'];
					$uni=$row['IdU'];//uni med
					$res=$row['Cant'];//cant
					$val=$row['Lote'];//lote
					$env=$row['IdEnv'];//envase
					$bul=$row['Bultos'];//bultos
					$obs=$row['Destino'];//destino
					$nroId2=GLO_generoID("procesosop_e1_it",$conn);
					$query="INSERT INTO procesosop_e1_it (Id,IdPadre,IdIC,IdU,Cant,Lote,IdEnv,CantI,Bultos,Destino) VALUES ($nroId2,$nroId,$item,$uni,$res,'$val',$env,0,$bul,'$obs')";$rs10=mysql_query($query,$conn);			
				}mysql_free_result($rs);
			
			
			
			}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 
		}
		
	}

	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarVehiculo.php?id=".$nroId."&Flag1=True");
	}else{
		header("Location:ModificarPD.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}	
	
	
}





?>


