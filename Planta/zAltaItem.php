<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	//debe tener articulo, producto u observaciones
	if ( ( intval($_POST['CbItem'])==0 and intval($_POST['CbItem2'])==0 and empty($_POST['TxtObs'])) or (floatval($_POST['TxtCantidad'])==0) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}
		$_SESSION['GLO_msgE']='Complete Cantidad e Item a solicitar';
		header("Location:AltaItem.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		if(intval($_POST['CbItem'])!=0 and intval($_POST['CbItem2'])!=0){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}
			$_SESSION['GLO_msgE']='Seleccione Art&iacute;culo o Producto, no ambos';
			header("Location:AltaItem.php?Id=".intval($_POST['TxtNroEntidad']));
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro
			$ident=intval($_POST['TxtNroEntidad']);//idcomprobante
			$iditem=intval($_POST['CbItem']);
			$iditem2=intval($_POST['CbItem2']);
			$iddep=intval($_POST['TxtDep']);
			$idtipo=intval($_POST['TxtTipo']);
			$cant=floatval($_POST['TxtCantidad']);	
			$idpedido=intval($_POST['TxtNroPedido']);//item pedido
			$idcam=0;$etapaproc=0;//es un ajuste
			//cantidad con signo para conciliar (suma(1AI,3RI) o resta(2AE,4RE) )
			if($idtipo==1 or $idtipo==3){$cantcs=$cant;}else{$cantcs=-$cant;}	
			//datos remito
			$query="SELECT IdCliente From stockmov where Id=$ident";$rs=mysql_query($query,$conn);
			while($row=mysql_fetch_array($rs)){$idcliprop=$row['IdCliente'];}mysql_free_result($rs);				
			//inserto 
			$nroId=GLO_generoID("stockmov_items",$conn);
			$query="INSERT INTO stockmov_items (Id,IdMov,IdArticulo,Cantidad,CantidadCS,IdNP,IdItemNP,IdUser,IdItem,IdCAM,IdPedido,IdUniIT,IdEnvIT,LoteIT,Etapa,CantSinFactor) VALUES ($nroId,$ident,$iditem,$cant,$cantcs,0,0,$paudi,$iditem2,$idcam,$idpedido,0,0,'',0,0)";
			$rs=mysql_query($query,$conn);
			if($rs){include("../Stock/Includes/zAltaMovStock.php");}		
			mysql_close($conn); 
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}
	}
}






elseif (isset($_POST['CmdExBuscar']) or isset($_POST['CmdExBuscar2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNroEntidad']));
}




elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>