<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST[CmdBuscar])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wfechad="";$wfechah="";$west="";$wprov="";
	//criterios
	if (!(empty($_POST['TxtFechaDORD']))){$wfechad="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaDORD'])."')>=0";}
	if (!(empty($_POST['TxtFechaHORD']))){$wfechah="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaHORD'])."')<=0";}
	$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and co.Id=$nro";}else{$wnro="";}
	$nrooc=intval($_POST['TxtNroOC']);if($nrooc!=0){$wnrooc="and co.Nro=$nrooc";}else{$wnrooc="";}
	$nropi=intval($_POST['TxtNroPI']);if($nropi!=0){$wnropi="and np.Nro=$nropi";}else{$wnropi="";}
	$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and co.IdProv=$prov";}
	$est=intval($_POST['CbEstado']);if($est!=0){$west="and co.IdEstado=$est";}
	//query
	if($nropi==0){//si no consulta nro nota pedido
		$_SESSION['TxtQCOOR']="Select co.*,p.Apellido as Prov,e.Nombre as Estado From co_ocompra co,proveedores p,co_ocompra_est e Where co.IdProv=p.Id and co.IdEstado=e.Id  $wfechad $wfechah $wnro $wprov $west $wnrooc Order by co.Id";	
		//excel
		$_SESSION['TxtQCOOREX']="Select co.*,p.Apellido as Prov,e.Nombre as Estado,p1.Nombre as NomE,p1.Apellido as ApeE,p2.Nombre as NomA,p2.Apellido as ApeA From co_ocompra co,proveedores p,co_ocompra_est e,personal p1,personal p2 Where co.IdProv=p.Id and co.IdEstado=e.Id and co.IdPerEjec=p1.Id and co.IdPerAuto=p2.Id $wfechad $wfechah $wnro $wprov $west $wnrooc Order by co.Id";	
	}else{
		$_SESSION['TxtQCOOR']="Select distinct co.*,p.Apellido as Prov,e.Nombre as Estado From co_ocompra co,proveedores p,co_ocompra_est e,co_ocompra_it i,co_npedido np Where co.IdProv=p.Id and co.IdEstado=e.Id and co.Id=i.IdOCompra and np.Id=i.IdNPedido $wfechad $wfechah $wnro $wprov $west $wnrooc $wnropi Order by co.Id";	
		//excel
		$_SESSION['TxtQCOOREX']="Select distinct co.*,p.Apellido as Prov,e.Nombre as Estado,p1.Nombre as NomE,p1.Apellido as ApeE,p2.Nombre as NomA,p2.Apellido as ApeA From co_ocompra co,proveedores p,co_ocompra_est e,personal p1,personal p2,co_ocompra_it i,co_npedido np Where co.IdProv=p.Id and co.IdEstado=e.Id and co.IdPerEjec=p1.Id and co.IdPerAuto=p2.Id and co.Id=i.IdOCompra and np.Id=i.IdNPedido $wfechad $wfechah $wnro $wprov $west $wnrooc $wnropi Order by co.Id";	
	}
	header("Location:Ordenes.php");
}



elseif (isset($_POST[CmdBorrarFila])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//verifico si tiene items
	$query="SELECT * From co_ocompra_it where IdOCompra=".intval($_POST['TxtId']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){//no tiene:borro
		$query="Delete From co_ocompra where Id=".intval($_POST['TxtId']);$rs2=mysql_query($query,$conn);
	}else{
		GLO_feedback(12);
	}mysql_free_result($rs);
	mysql_close($conn); 	
	header("Location:Ordenes.php");
}



elseif (isset($_POST[CmdExcel])){
	$query=$_POST['TxtQCOOREX'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Nro.Interno</th>\n";
			echo "<th>Nro.OC</th>\n";
			echo "<th>Alta</th>\n";	
			echo "<th>Proveedor</th>\n";							
			echo "<th>Ejecutante</th>\n";
			echo "<th>Autorizante</th>\n";	
			echo "<th>Estado</th>\n";		
			echo "<th>Efectivo</th>\n";			
			echo "<th>Cheque</th>\n";
			echo "<th>CCorriente</th>\n";
			echo "<th>Transferencia</th>\n";
			echo "<th>Transferencia Dif.</th>\n";
			echo "<th>Factura</th>\n";
			echo "<th>Remito</th>\n";	
			echo "<th>Observaciones</th>\n";		
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				//estado
				$colorest='';
				if($row['IdEstado']==2){$colorest=' style="font-weight:bold;color:#4CAF50"';}
				if($row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#00bcd4"';}
				if($row['IdEstado']==3 or $row['IdEstado']==6){$colorest=' style="font-weight:bold;color:#f44336"';}				
				if($row['Efe']==1){$efe='SI ';}else{$efe='';}
				if($row['Che']==1){$che='SI ';}else{$che='';}
				if($row['CC']==1){$cc='SI ';}else{$cc='';}
				if($row['Fact1']==1){$f1='SI ';}else{$f1='';}
				if($row['Rem']==1){$rem='SI ';}else{$rem='';}
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.$row['Nro']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Prov'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['ApeE'].' '.$row['NomE'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ApeA'].' '.$row['NomA'])."</td>\n";
				echo "<td ".$colorest.">".$row['Estado']."</td>\n";
				echo '<td>'.$efe.$row['Efe2']."</td>\n";				
				echo '<td>'.$che.$row['Che2']."</td>\n";
				echo '<td>'.$cc."</td>\n";
				echo '<td>'.GLO_Si($row['Tran'])."</td>\n";
				echo '<td>'.GLO_Si($row['TranD'])."</td>\n";
				echo '<td>'.$f1.$row['Fact1Nro']."</td>\n";
				echo '<td>'.$rem.$row['RemNro']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }


?> 

