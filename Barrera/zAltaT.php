<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(13);


//alta terceros
		
if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtHora']) or empty($_POST['TxtDoc']) or empty($_POST['CbTipo'])  or empty($_POST['CbTipo2']) or   empty($_POST['CbEtapa']) or (empty($_POST['CbProv']) and empty($_POST['CbCliente']))  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);
		if(empty($_POST['CbProv']) and empty($_POST['CbCliente'])){$_SESSION['GLO_msgE']="Por favor complete Cliente o Proveedor propietario del camion";}
		header("Location:AltaT.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
		$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
		$tipo=intval($_POST['CbTipo']);
		$tipo2=intval($_POST['CbTipo2']);//1:persona,2:vehiculo
		$prov=intval($_POST['CbProv']); 
		$cli=intval($_POST['CbCliente']);
		$doc=mysql_real_escape_string($_POST['TxtDoc']);
		$fv="0000-00-00";
		if(intval($_POST['CbEtapa'])==1){$etapa=0;}else{$etapa=1;}//0:ingreso,1:salida
		//veo si es persona/camion
		if($tipo2==1){//persona
			$nroId=GLO_generoID('procesosop_e2',$conn);
			$query="INSERT INTO procesosop_e2(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,Chofer,DNI,IdProv,IdCli,Obs,Temp,Olf,Etapa) VALUES ($nroId,0,$tipo,'$fecha','$hora',0,'','$doc',$prov,$cli,'',0,0,$etapa)";
		}else{			
			$nroId=GLO_generoID('procesosop_e1',$conn);
			$query="INSERT INTO procesosop_e1(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,IdUnidad,IdSemi,Km,Chofer,DNI,IdMarca,IdCateg,Modelo,Dominio,IdMarca2,IdCateg2,Modelo2,Dominio2,IdProv,IdCli,Rto,Mot,Chk1,Chk2,ChkU1,ChkU2,ChkU3,ChkS1,ChkS2,ChkS3,ChkC1,ChkC2,FU1,FU2,FU3,FS1,FS2,FS3,FC1,FC2,Sedro,Obs,Temp,Olf,IdPedido,Etapa,Retorno) VALUES ($nroId,0,$tipo,'$fecha','$hora',0,0,0,0,'','$doc',0,0,'','',0,0,'','',$prov,$cli,'','',0,0,0,0,0,0,0,0,0,0,'$fv','$fv','$fv','$fv','$fv','$fv','$fv','$fv','','',0,0,0,$etapa,0)";
		}
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0;} 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			if($tipo2==1){header("Location:ModificarP.php?id=".$nroId."&Flag1=True");}//persona
			else{header("Location:Modificar.php?id=".$nroId."&Flag1=True");}	
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaT.php");
		}	
		
	}
}





?>