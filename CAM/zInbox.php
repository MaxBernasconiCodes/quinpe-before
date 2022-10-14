<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';$wbuscar2='';$wbuscar3='';
	//Barrera: ingresos(o retornos) 
	$vbuscar=intval($_POST['CbProducto']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.IdIC=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	//formulados/egresos propios carga
	$vbuscar=intval($_POST['CbProducto']);if($vbuscar!=0){$wbuscar2=$wbuscar2." and a2.IdItem=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar2=$wbuscar2." and a1.IdCliente=$vbuscar";}
	//union
	$vbuscar=intval($_POST['CbTipoC']);if($vbuscar!=0){$wbuscar3=$wbuscar3." and x.IdEtapa=$vbuscar";}
	//ingresos barrera(etapa 0)
	$query1="Select a2.Id,a2.Lote,a1.Rto,a1.Retorno,a.Fecha,a.Id as IdProc,cli.Nombre as Cliente,i.Nombre as Item, 'INGRESO' as Etapa, '1' as IdEtapa From procesosop a,clientes cli,procesosop_e1 a1,procesosop_e1_it a2,items i Where a.Id<>0 and a.IdCliente=cli.Id and a1.IdPadre=a.Id and a2.IdPadre=a1.Id and a2.IdIC=i.Id and a1.Etapa=0 and a2.Id NOT IN(select IdPE1IT from cam where IdPE1IT<>0) $wbuscar ";
	//formulados planta(remitos ingreso(3) formulado(3))
	$query2="Select a2.Id,a2.LoteIT as Lote,a1.Nro as Rto,'' as Retorno,a1.Fecha,d.IdPadre as IdProc,cli.Nombre as Cliente,i.Nombre as Item, 'FORMULADO' as Etapa, '2' as IdEtapa From clientes cli,stockmov a1,stockmov_items a2,items i,despacho d Where a1.Id<>0 and a1.IdCliente=cli.Id and a2.IdMov=a1.Id and a2.IdItem=i.Id and a2.IdPedido=d.Id and a1.IdOrigen=3 and a1.IdTipoMov=3 and a2.IdCAM=0 $wbuscar2 ";
	//egresos planta x carga de productos propios(remitos egreso(4) carga(4))
	$query3="Select a2.Id,a2.LoteIT as Lote,a1.Nro as Rto,'' as Retorno,a1.Fecha,d.IdPadre as IdProc,cli.Nombre as Cliente,i.Nombre as Item, 'CARGA PROPIO' as Etapa, '3' as IdEtapa From clientes cli,stockmov a1,stockmov_items a2,items i,despacho d Where a1.Id<>0 and a1.IdCliente=cli.Id and a2.IdMov=a1.Id and a2.IdItem=i.Id and a2.IdPedido=d.Id and a1.IdOrigen=4 and a1.IdTipoMov=4 and a2.IdCAM=0 and cli.Interno=1 $wbuscar2 ";
	//ingreso+formulado
	$_SESSION['TxtQCAMIB']="select x.* from ($query1 UNION ALL $query2 UNION ALL $query3) x where x.Id<>0 $wbuscar3 Order by x.Fecha,x.Cliente,x.Item";
	header("Location:Inbox.php");
}





if (isset($_POST['CmdAddFila'])){
	list($iditemproc,$idetapa)=explode("|",$_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	if($idetapa==1){//ingresos barrera
		$query="Select a.Fecha,a.IdCliente,a2.IdIC,a2.Lote,a1.Rto From procesosop a,procesosop_e1 a1,procesosop_e1_it a2 Where a.Id<>0 and a1.IdPadre=a.Id and a2.IdPadre=a1.Id and a2.Id=$iditemproc";$rs=mysql_query($query,$conn);
		$iditrto=0;
	}else{//rtos ingreso formulados/carga propios
		$query="Select a1.Fecha,a1.IdCliente,a2.IdItem as IdIC,a2.LoteIT as Lote,a1.Nro as Rto From stockmov a1,stockmov_items a2 Where a1.Id<>0 and a2.IdMov=a1.Id and a2.Id=$iditemproc";$rs=mysql_query($query,$conn);
		$iditrto=$iditemproc;$iditemproc=0;
	}
	while($row=mysql_fetch_array($rs)){
		$fa=$row['Fecha'];$cli=$row['IdCliente'];$prod=$row['IdIC'];$lote=$row['Lote'];$rto=$row['Rto'];
	}mysql_free_result($rs);
	//personal registro
	$paudi=intval($_SESSION["GLO_IdPersLog"]);	
	//inserto 
	$nroId=GLO_generoID('cam',$conn);
	$query="INSERT INTO cam(Id,Fecha,FechaV,IdProducto,IdCliente,Lote,Rto,OC,Obs1,Obs2,IdPE1IT,IdPE2IT,IdE,IdPer,IdUser,LoteVto) VALUES ($nroId,'$fa','0000-00-00',$prod,$cli,'$lote','$rto','','','',$iditemproc,$iditrto,1,$paudi,$paudi,'0000-00-00')"; 	
	$rs=mysql_query($query,$conn);
	if($rs){
		//graba cam en rto
		if($idetapa==2 or $idetapa==3){$query="UPDATE stockmov_items set IdCAM=$nroId Where Id=$iditrto";$rs=mysql_query($query,$conn);}
		$grabook=1;
	}else{GLO_feedback(2);$grabook=0;} 
	mysql_close($conn); 			
	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		$_SESSION['TxtQCAMIB']=$_POST['TxtQCAMIB'];
		header("Location:Modificar.php?id=".$nroId."&Flag1=True");	
	}else{
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:Inbox.php");
	}	
}





?>