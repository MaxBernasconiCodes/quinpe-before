<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	$vbuscar=intval($_POST['CbProducto']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdProducto=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	//validaciones inbox planta
	$wbuscar=$wbuscar.PLA_whereinbox();
	//
	$_SESSION['TxtQPLAIB']="Select a.*,cli.Nombre as Cliente,p.Nombre as Producto,a2.Cant,a2.CantI,u.Abr as Uni,e.Nombre as Env,u2.Abr as Abr2,a2.IdU as UniBar,p.IdUnidad as UniProd From cam a,clientes cli,items p,procesosop_e1_it a2,unidadesmedida u,envases e,unidadesmedida u2 Where a.Id<>0 and  a.IdCliente=cli.Id and a.IdProducto=p.Id and a2.Id=a.IdPE1IT and a2.IdU=u.Id and a2.IdEnv=e.Id and p.IdUnidad=u2.Id $wbuscar Order by a.Fecha,cli.Nombre,p.Nombre";
	header("Location:Inbox.php");
}




elseif (isset($_POST['CmdAddFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$idcam=intval($_POST['TxtId']);
	$aListanrodep=$_POST['CbDeposito'];$iddep=intval($aListanrodep[$idcam]);//array valor deposito
	$aListafactor=$_POST['TxtFactor'];$factor=floatval($aListafactor[$idcam]);//array valor factor	
	PLA_puedeingresarcam($idcam,$iditem,$iditem2,$cant,$existerto,$idcliprop,$llevafactor,$conn);//valido si puede grabar
	//valido si requiere factor
	if($llevafactor==1 and $factor==0){$factorok=0;}else{$factorok=1;}
	//valido si selecciono deposito, que traiga cantidad y no se ingreso
	if($iddep!=0 and $cant!=0 and $existerto==0 and $factorok==1){
		include("Includes/zInsertaRI.php") ;
	}else{
		$grabook=0;
		if($factorok==0){$_SESSION['GLO_msgE']='Por favor seleccione el factor de conversion';}
		if($iddep==0){$_SESSION['GLO_msgE']='Por favor seleccione el deposito';}
		if($cant==0){$_SESSION['GLO_msgE']='Falta completar la cantidad del producto en Barrera';}
		if($existerto!=0){$_SESSION['GLO_msgE']='Ya existe un remito de ingreso incompleto asociado nro '.$existerto;}
	}
	mysql_close($conn); 			
	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		$_SESSION['TxtQPLAIB']=$_POST['TxtQPLAIB'];
		header("Location:Modificar.php?id=".$ident."&Flag1=True");	//rto ingreso
	}else{
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:Inbox.php");
	}	
}


elseif (isset($_POST['CmdSplitFila'])){
	header("Location:InboxD.php?id=".intval($_POST['TxtId']));//pasa idcam
}



?>