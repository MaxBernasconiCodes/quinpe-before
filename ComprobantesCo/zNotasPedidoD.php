<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//trae maximo x registros debido a error por max_post_size
if (isset($_POST['CmdBuscar'])){ 	
	//conecto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wbuscar='';
	//criterios
	if (!(empty($_POST['TxtFechaDCONP']))){$wbuscar=$wbuscar." and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaDCONP'])."')>=0";}
	if (!(empty($_POST['TxtFechaHCONP']))){$wbuscar=$wbuscar." and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaHCONP'])."')<=0";}
	$vbuscar=intval($_POST['TxtNroPedido']);if($vbuscar!=0){$wbuscar=$wbuscar." and np.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbSoli']);if($vbuscar!=0){$wbuscar=$wbuscar." and np.IdPerSoli=$vbuscar";}
	$vbuscar=intval($_POST['CbAuto']);if($vbuscar!=0){$wbuscar=$wbuscar." and (np.IdPerPAuto=$vbuscar or np.IdPerAuto=$vbuscar)";}
	$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and np.IdSector=$vbuscar";}
	$vbuscar=intval($_POST['CbProv']);if($vbuscar!=0){$wbuscar=$wbuscar." and npi.IdProv=$vbuscar";}
	$vbuscar=intval($_POST['CbPrio']);if($vbuscar!=0){$wbuscar=$wbuscar." and np.Prioridad=$vbuscar";}
    //tipo item
    $vbuscar=intval($_POST['CbTipo']);
    if($vbuscar==1){$wbuscar=$wbuscar." and npi.IdItem=0 and npi.IdArticulo<>0";}//articulo
    if($vbuscar==2){$wbuscar=$wbuscar." and npi.IdArticulo=0 and npi.IdItem<>0";}//producto
	//estado
	//es un prefiltro, el filtro final se hace en la consulta validando oc y remitos
	$vbuscar=intval($_POST['CbEstado']);
	switch ($vbuscar) {
		case 1:	$wbuscar=$wbuscar." and npi.IdEstado=1"; break;//abierto
		case 2:	$wbuscar=$wbuscar." and npi.IdEstado=2"; break;//preauto
		case 3:	$wbuscar=$wbuscar." and npi.IdEstado=3"; break;//auto
		case 4:	$wbuscar=$wbuscar." and npi.IdEstado=4"; break;//rech
		case 5:	$wbuscar=$wbuscar." and npi.IdEstado=5"; break;//rech
		case 6:	$wbuscar=$wbuscar." and npi.IdEstado=8"; break;//en proceso (tiene oc pero no entro a stock)
		case 7:	$wbuscar=$wbuscar." and npi.IdEstado=8"; break;//comprado (tiene oc y entro a stock)
		case 8:	$wbuscar=$wbuscar." and npi.IdEstado=8"; break;//comprar (no tiene oc)
		case 9:	$wbuscar=$wbuscar." and npi.IdEstado=3"; break;//resuelto (fue directo a almacen)
	}
	

	
	//buscar articulo/item
	$wnom="";
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$wbuscar=$wbuscar." and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
	}
	//query
	$query="Select np.*,npi.Id as IdNPI,npi.IdEstado,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,p1.Nombre as NomS,p1.Apellido as ApeS,p2.Nombre as NomA,p2.Apellido as ApeA,p3.Nombre as NomPA,p3.Apellido as ApePA,s.Nombre as Sector,a.Id as IdArticuloItem, a.Nombre as Articulo, um.Abr,e.Nombre as Estado,np.IdPerPAuto,np.IdPerAuto,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,personal p1,personal p2,personal p3,sector s,epparticulos a,unidadesmedida um,co_npedido_est e,items il,unidadesmedida u2 Where np.Id=npi.IdNP and np.IdPerSoli=p1.Id and np.IdPerAuto=p2.Id and np.IdPerPAuto=p3.Id and np.IdSector=s.Id and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdEstado=e.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id $wbuscar Order by np.Id LIMIT 2000";		
	//vuelvo
	mysql_close($conn);
	$_SESSION['TxtQNOTAPDET']=$query;
	header("Location:NotasPedidoD.php");
}




elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQNOTAPDET'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Nro.Pedido</th>\n";
			echo "<th>Alta</th>\n";			
			echo "<th>Solicitante</th>\n";	
			echo "<th>Estado</th>\n";
			echo "<th>Art&iacute;culo</th>\n";	
			echo "<th>Cant</th>\n";	
			echo "<th>Cant.Autorizada</th>\n";	
			echo "<th>UnMedida</th>\n";
			echo "<th>Obs.Nota Pedido</th>\n";
			echo "<th>Obs.Item Pedido</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				$idestado=NP_BuscarEstadoNPIId($row['IdNPI'],$row['IdEstado'],$conn);
				$estado=NP_BuscarEstadoNPI($row['IdNPI'],$row['Estado'],$conn);
				$colorestado=NP_BuscarEstadoNPIColor($idestado);
				$muestra=1;$estfiltro=intval($_POST['CbEstado']);if($estfiltro!=0){if($idestado!=$estfiltro){$muestra=0;}}
				//articulo,producto u observaciones
				$textoart=$row['ObsItem'];$abr='';
				if($row['IdArticuloItem']>0){$textoart=$row['Articulo'];$abr=$row['Abr'];}
				if($row['IdProd']>0){$textoart=$row['Prod'];$abr=$row['Abr2'];}
				//
				if($muestra==1){
					echo "<tr>\n";
					echo '<td>'.$row['Id']."</td>\n";
					echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";				
					echo '<td>'.GLO_textoExcel($row['ApeS'].' '.$row['NomS'])."</td>\n";
					echo "<td ".$colorestado.">".$estado."</td>\n";
					echo '<td>'.GLO_textoExcel($textoart)."</td>\n";
					echo '<td>'.number_format($row['CantItem'],2, ',', '')."</td>\n";
					echo '<td>'.number_format($row['CantAutoItem'],2, ',', '')."</td>\n";
					echo '<td>'.$abr."</td>\n";	
					echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
					echo '<td>'.GLO_textoExcel($row['ObsItem'])."</td>\n";
					echo "</tr>\n";	
				}		
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }


elseif (isset($_POST['CmdPreautorizar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);$aListacant=$_POST['TxtCant'];
		$fecha=FechaMySql(date("d-m-Y"));$cont=0;
		foreach($aListaid as $iId) {
			$cantauto=floatval($aListacant[$iId]);
			if($cantauto!=0){
				$query="UPDATE co_npedido_it set CantAuto=$cantauto,IdEstado=2,FechaPAuto='$fecha' Where IdEstado=1 and Id=$iId";
				$rs=mysql_query($query,$conn);if($rs){ $cont=$cont+1;}
			}else{$_SESSION['GLO_msgE']='Para autorizar el pedido es necesario registrar la Cantidad Autorizada';}
		}mysql_close($conn); 
		$_SESSION['GLO_msgC']="Se actualizaron ".$cont." pedidos";
 	}else{$_SESSION['GLO_msgE']="Por favor seleccione algun pedido";}	
	header("Location:NotasPedidoD.php");
}

elseif (isset($_POST['CmdAutorizar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);$aListacant=$_POST['TxtCant'];
		$fecha=FechaMySql(date("d-m-Y"));$cont=0;
		foreach($aListaid as $iId) {
			$cantauto=floatval($aListacant[$iId]);
			if($cantauto!=0){
				$query="UPDATE co_npedido_it set CantAuto=$cantauto,IdEstado=3,FechaAuto='$fecha' Where (IdEstado=1 or IdEstado=2) and Id=$iId";
				$rs=mysql_query($query,$conn);if($rs){ $cont=$cont+1;}
			}else{$_SESSION['GLO_msgE']='Para autorizar el pedido es necesario registrar la Cantidad Autorizada';}
		}mysql_close($conn); 
		$_SESSION['GLO_msgC']="Se actualizaron ".$cont." pedidos";
 	}else{$_SESSION['GLO_msgE']="Por favor seleccione algun pedido";}	
	header("Location:NotasPedidoD.php");
}

elseif (isset($_POST['CmdRechazarPre'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);$fecha=FechaMySql(date("d-m-Y"));$cont=0;
		foreach($aListaid as $iId) {
			$query="UPDATE co_npedido_it set IdEstado=4 Where IdEstado=1 and Id=$iId";
			$rs=mysql_query($query,$conn);if($rs){ $cont=$cont+1;}			
		}mysql_close($conn); 
		$_SESSION['GLO_msgC']="Se actualizaron ".$cont." pedidos";
 	}else{$_SESSION['GLO_msgE']="Por favor seleccione algun pedido";}	
	header("Location:NotasPedidoD.php");
}

elseif (isset($_POST['CmdRechazarAuto'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);$fecha=FechaMySql(date("d-m-Y"));$cont=0;
		foreach($aListaid as $iId) {
			$query="UPDATE co_npedido_it set IdEstado=5 Where (IdEstado=1 or IdEstado=2) and Id=$iId";
			$rs=mysql_query($query,$conn);if($rs){ $cont=$cont+1;}
		}mysql_close($conn); 
		$_SESSION['GLO_msgC']="Se actualizaron ".$cont." pedidos";
 	}else{$_SESSION['GLO_msgE']="Por favor seleccione algun pedido";}	
	header("Location:NotasPedidoD.php");
}





?> 

