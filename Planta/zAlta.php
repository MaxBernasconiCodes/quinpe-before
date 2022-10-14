<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	//verifica  req, y proveedor si es remito
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbDep']) or empty($_POST['CbTipo']) or empty($_POST['CbCliente']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro
		$fecha=FechaMySql($_POST['TxtFechaA']);
		$tipo=intval($_POST['CbTipo']);
		$dep=intval($_POST['CbDep']);
		$cli=intval($_POST['CbCliente']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		//inserto
		$nroId=GLO_generoID('stockmov',$conn);
		$query="INSERT INTO stockmov (Id,IdTipoMov,Fecha,IdProveedor,IdDeposito,Obs,Anulado,Tipo,Suc,Nro,IdUnidad,IdPersonal,NroOC,IdCAM,IdPedido,IdUser,IdCliente,IdOrigen,IdInstr,IdSectorM) VALUES ($nroId,$tipo,'$fecha',0,$dep,'$obs',0,'',0,0,0,0,0,0,0,$paudi,$cli,2,0,0)";$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:Alta.php");
		}			

	}		
	
}

elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../Stock.php");
}


else{ //Click en combos 
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
header("Location:Alta.php");
}



?>