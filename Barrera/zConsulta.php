<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("../Procesos/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';$wbuscar2='';$wbuscar3='';
	//todos
	if (!(empty($_POST['TxtFDBAR']))){$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".FechaMySql($_POST['TxtFDBAR'])."')>=0";}
	if (!(empty($_POST['TxtFHBAR']))){$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".FechaMySql($_POST['TxtFHBAR'])."')<=0";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.IdCli=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.Tipo=$vbuscar";}	
	$vbuscar=intval($_POST['TxtDoc']);if($vbuscar!=0){$wbuscar=$wbuscar." and (a2.DNI='$vbuscar' or p.Documento='$vbuscar') ";}$vbuscar=intval($_POST['CbPersonal']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.IdChofer=$vbuscar";}	
	

	$vbuscar=intval($_POST['CbEtapa']);
	if($vbuscar==1){$wbuscar=$wbuscar." and a2.Etapa=0";}//ingreso
	if($vbuscar==2){$wbuscar=$wbuscar." and a2.Etapa=1";}//egreso
	//solo camiones
	$vbuscar=intval($_POST['TxtNro']);if($vbuscar!=0){$wbuscar2=$wbuscar2." and a2.Rto Like '%".$vbuscar."%'";}
	$vbuscar=intval($_POST['Chk2']);if($vbuscar!=0){$wbuscar2=$wbuscar2." and a2.IdPedido<>0";}
	$vbuscar=intval($_POST['ChkRE']);if($vbuscar!=0){$wbuscar2=$wbuscar2." and a2.Retorno=1";}
	//con productos y no persona
	$vbuscar=intval($_POST['CbProducto']);if($vbuscar!=0){$wbuscar=$wbuscar." and m.IdIC=$vbuscar";}
	//
	$tipo2=intval($_POST['CbTipo2']);//persona 1/camion 2
	$tienepedido=intval($_POST['Chk2']);//con pedidos solo camiones
	$rto=intval($_POST['TxtNro']);//remito solo camiones
	$prod=intval($_POST['CbProducto']);//producto solo camiones
	$ret=intval($_POST['ChkRE']);//retorno solo camiones
	//cambio where si busco sin egreso
	//querys base
	$queryproductos="SELECT distinct a2.Id,a2.IdPadre,a2.Rto,a2.Chofer,a2.DNI,a2.Fecha,a2.Hora,a2.Tipo,a2.IdPedido,cli.Nombre as Cliente,p.Nombre as NCH,p.Apellido as ACH,p.Documento,'VEH&Iacute;CULO' as TipoB,a2.Etapa,a2.Retorno From clientes cli,procesosop_e1 a2,personal p,procesosop_e1_it m Where a2.Id<>0 and a2.IdCli=cli.Id and a2.IdChofer=p.Id and m.IdPadre=a2.Id $wbuscar $wbuscar2 Order by a2.Fecha,a2.Hora,a2.Id";		
	$querypersonas="SELECT a2.Id,a2.IdPadre,'' as Rto,a2.Chofer,a2.DNI,a2.Fecha,a2.Hora,a2.Tipo,'' as IdPedido,cli.Nombre as Cliente,p.Nombre as NCH,p.Apellido as ACH,p.Documento,'PERSONA' as TipoB,a2.Etapa,'' as Retorno From clientes cli,procesosop_e2 a2,personal p Where a2.Id<>0 and a2.IdCli=cli.Id and a2.IdChofer=p.Id $wbuscar";
	$querycamiones="SELECT a2.Id,a2.IdPadre,a2.Rto,a2.Chofer,a2.DNI,a2.Fecha,a2.Hora,a2.Tipo,a2.IdPedido,cli.Nombre as Cliente,p.Nombre as NCH,p.Apellido as ACH,p.Documento,'VEH&Iacute;CULO' as TipoB,a2.Etapa,a2.Retorno From clientes cli,procesosop_e1 a2,personal p Where a2.Id<>0 and a2.IdCli=cli.Id and a2.IdChofer=p.Id $wbuscar $wbuscar2";
	//opciones de query
	if( (intval($_POST['Chk1'])==1 or $prod!=0) and $tipo2!=1){//con productos
		$_SESSION['TxtQPROCBAR']=$queryproductos;
	}else{//sin productos		
		if($tienepedido==0 and $rto==0 and $ret==0){
			if($tipo2==0){$_SESSION['TxtQPROCBAR']="SELECT x.* From ($querypersonas UNION ALL $querycamiones)x Order by x.Fecha,x.Hora,x.Id";}
			if($tipo2==1){$_SESSION['TxtQPROCBAR']="SELECT x.* From ($querypersonas)x Order by x.Fecha,x.Hora,x.Id";}
		}
		//camiones
		if($tipo2==2 or $tienepedido==1 or $rto!=0 or $ret==1){$_SESSION['TxtQPROCBAR']="SELECT x.* From ($querycamiones)x Order by x.Fecha,x.Hora,x.Id";}			
	}
	//vuelve
	header("Location:Consulta.php");
}



elseif (isset($_POST['CmdBorrarFila1'])){//personas
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From procesosop_e2 Where Id=".intval($_POST['TxtId']);	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Consulta.php"); 	
}


elseif (isset($_POST['CmdBorrarFila2'])){//camiones
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From procesosop_e1 Where Id=".intval($_POST['TxtId']);	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Consulta.php"); 	
}

?>