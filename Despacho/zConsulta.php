<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){ 	
	//conecto
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdTipo=$vbuscar";}	
	$vbuscar=intval($_POST['TxtRto']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Rto=$vbuscar";}

	//estado
	$vbuscar=intval($_POST['CbEstado']);
	$fromestado='';$whereestado='';
	if($vbuscar!=0){
		if($vbuscar==1){//pendiente(solicitud abierta) que no paso x barrera ni planta
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=0 and pp.Id NOT IN(SELECT IdPadre FROM procesosop_e1) and a.Id NOT IN(SELECT IdPedido FROM stockmov)';
		}
		if($vbuscar==2){//en proceso (solicitud abierta) que paso x barrera o planta
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=0 and ( pp.Id IN(SELECT IdPadre FROM procesosop_e1) OR a.Id IN(SELECT IdPedido FROM stockmov) )';

		}
		if($vbuscar==3){//finalizado(solicitud cerrada)
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=1';

		}
	}
	//pagina
	$_SESSION['TxtQOPEDES']="Select a.Id,a.Fecha,a.Hora,a.IdPadre,a.Rto,a.IdEstado,c.Nombre,t.Abr as Tipo,s1.Nombre as LineaA From despacho a,clientes c,despacho_tipo t,servicios s,serviciostipo1 s1 $fromestado  Where a.IdCliente=c.Id and t.Id=a.IdTipo and a.IdServicio=s.Id and s1.Id=s.IdTipo $whereestado $wbuscar Order by a.Id";
	//xls simple
	$_SESSION['TxtQOPEDESXLS']="Select a.Id,a.Fecha,a.Hora,a.Medio,a.Contacto,a.FechaEP,a.HoraEP,a.IdCliente,a.Rto,c.Nombre as Cli,t.Abr as Tipo,p.Apellido as AR,p.Nombre as NR,s1.Nombre as LineaA From despacho a,clientes c,despacho_tipo t,personal p,servicios s,serviciostipo1 s1 $fromestado Where a.IdCliente=c.Id and t.Id=a.IdTipo and a.IdPersonal=p.Id and a.IdServicio=s.Id and s1.Id=s.IdTipo $whereestado $wbuscar Order by a.Id";
	//xls detallado
	$_SESSION['TxtQOPEDESXLS2']="Select a.Id,a.Fecha,a.Hora,a.Medio,a.Contacto,a.FechaEP,a.HoraEP,a.IdCliente,a.Rto,c.Nombre as Cli,t.Abr as Tipo,p.Apellido as AR,p.Nombre as NR,s1.Nombre as LineaA,i.Id as IdItem, i.Nombre as Item,u.Abr as Uni,m.Cant,m.Lote,m.Destino,s2.Nombre as LineaB From despacho a,clientes c,despacho_tipo t,personal p,servicios s,serviciostipo1 s1,despacho_it m,items i,unidadesmedida u,itemscliente_serv si,itemscliente_serv_b sib,serviciostipo s2 $fromestado Where a.IdCliente=c.Id and t.Id=a.IdTipo and a.IdPersonal=p.Id and a.IdServicio=s.Id and s1.Id=s.IdTipo and a.Id=m.IdPadre and m.IdIC=i.Id and m.IdU=u.Id and m.IdItemServ=si.Id and si.Id=sib.IdPadre and sib.IdLB=s2.Id $whereestado $wbuscar Order by a.Id";
	//
	header("Location:Consulta.php");
}



elseif (isset($_POST['CmdBorrarFila'])){//ojo porque ahora los estados no se actualizan
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//busca solicitud
	$solicitud=0;$puedeborrar=1;
	$query="SELECT IdPadre FROM despacho Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$solicitud=$row['IdPadre'];}mysql_free_result($rs);
	//me fijo que la solicitud no este en barrera
	if($solicitud!=0){
		$query="SELECT Id FROM procesosop_e1 Where IdPadre=$solicitud LIMIT 1";$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){$$puedeborrar=0;}mysql_free_result($rs);
	}
	//solo borra si no hay registro barrera solicitud
	if($puedeborrar==1){
		// borra pedido y luego solicitud(ahora es 1-1 15/5/22)
		$query="Delete From despacho Where Id<>0 and Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
		if ($rs){
			if($solicitud!=0){$query="Delete From procesosop Where Id<>0 and Id=$solicitud";$rs=mysql_query($query,$conn);}
			GLO_feedback(1);
		}else{GLO_feedback(2);} 
	}else{GLO_feedback(2);}
	mysql_close($conn); 
	header("Location:Consulta.php"); 	
}





elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQOPEDESXLS'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Pedido</th>\n";
			echo "<th>Mes</th>\n";
			echo "<th>Semana</th>\n";
			echo "<th>Dia</th>\n";
			echo "<th>Fecha</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Medio</th>\n";
			echo "<th>Comprador</th>\n";
			echo "<th>Recibio</th>\n";
			echo "<th>Entrega</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Nro</th>\n";
			echo "<th>Cliente</th>\n";	
			echo "<th>Rto</th>\n";	
			echo "<th>Accion</th>\n";
			echo "<th>Linea A</th>\n";	
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.date("m",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.date("W",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.date("D",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_FormatoHora($row['Hora'])."</td>\n";
				echo '<td>'.GLO_textoExcel(substr(GLO_VerMedioRecepcion($row['Medio']),0,5))."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Contacto'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['AR'].' '.$row['NR'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaEP'])."</td>\n";//entrega
				echo '<td>'.GLO_FormatoHora($row['HoraEP'])."</td>\n";//entrega
				echo '<td>'.$row['IdCliente']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Cli'])."</td>\n";
				echo '<td>'.GLO_SinCero($row['Rto'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['LineaA'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}mysql_free_result($rs);	
		mysql_close($conn); 
	}
}

elseif (isset($_POST['CmdExcel2'])){
	$query=$_POST['TxtQOPEDESXLS2'];
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Pedido</th>\n";
			echo "<th>Mes</th>\n";
			echo "<th>Semana</th>\n";
			echo "<th>Dia</th>\n";
			echo "<th>Fecha</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Medio</th>\n";
			echo "<th>Comprador</th>\n";
			echo "<th>Recibio</th>\n";
			echo "<th>Entrega</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Nro</th>\n";
			echo "<th>Cliente</th>\n";	
			echo "<th>Rto</th>\n";	
			echo "<th>Accion</th>\n";
			echo "<th>Linea A</th>\n";	
			echo "<th>Linea B</th>\n";	
			echo "<th>Nro</th>\n";
			echo "<th>Item</th>\n";	
			echo "<th>Uni</th>\n";	
			echo "<th>Cant</th>\n";	
			echo "<th>Lote</th>\n";	
			echo "<th>Destino</th>\n";	
			echo "<th>Chofer</th>\n";
			echo "<th>DNI</th>\n";		
			echo "<th>Camion</th>\n";	
			echo "<th>Semi</th>\n";	
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){
				DES_Dominios($row['Id'],$conn,$domcamion,$domsemi);	
				DES_Chofer($row['Id'],$conn,$chofer,$dnichofer);	
				//
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.date("m",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.date("W",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.date("D",strtotime($row['Fecha']))."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_FormatoHora($row['Hora'])."</td>\n";
				echo '<td>'.GLO_textoExcel(substr(GLO_VerMedioRecepcion($row['Medio']),0,5))."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Contacto'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['AR'].' '.$row['NR'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaEP'])."</td>\n";//entrega
				echo '<td>'.GLO_FormatoHora($row['HoraEP'])."</td>\n";//entrega
				echo '<td>'.$row['IdCliente']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Cli'])."</td>\n";
				echo '<td>'.GLO_SinCero($row['Rto'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['LineaA'])."</td>\n";
				//items
				echo '<td>'.GLO_textoExcel($row['LineaB'])."</td>\n";
				echo '<td>'.$row['IdItem']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Item'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Uni'])."</td>\n";
				echo '<td>'.$row['Cant']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Lote'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Destino'])."</td>\n";
				//camion
				echo '<td>'.GLO_textoExcel($chofer)."</td>\n";
				echo '<td>'.GLO_textoExcel($dnichofer)."</td>\n";
				echo '<td>'.GLO_textoExcel($domcamion)."</td>\n";
				echo '<td>'.GLO_textoExcel($domsemi)."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}mysql_free_result($rs);	
		mysql_close($conn); 
	}
}


?> 

