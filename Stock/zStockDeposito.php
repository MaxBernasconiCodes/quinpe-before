<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//	
	$wbuscar='';
	$vbuscar=intval($_POST['CbRubro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdRubro=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.EPP=$vbuscar";}
	$vbuscar=intval($_POST['CbDeposito']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdDeposito=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdCliente=$vbuscar";}	
	$vbuscar=intval($_POST['ChkVer']);if($vbuscar==0){$wbuscar=$wbuscar." and s.Stock<>0";}//default no muestra stock 0
	//buscar articulo/item
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wbuscar=$wbuscar." and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
		mysql_close($conn);
	}
	//
	$_SESSION['TxtQSTOCKDEP']="SELECT a.*, m.Nombre as Marca, r.Nombre as Rubro,d.Nombre as Dep,s.Stock,u.Abr,s.IdDeposito,s.Id as IdST,il.Nombre as Prod,il.Id as IdProd,c.Nombre as Cliente,s.IdCliente,u2.Abr as Abr2 From stockdepositos s,epparticulos a,marcas m, rubros r,unidadesmedida u,depositos d,items il,clientes c,unidadesmedida u2 where s.IdArticulo=a.Id and a.IdMarca=m.Id and a.IdRubro=r.Id and s.IdDeposito=d.Id and a.IdUnidad=u.Id and s.IdItem=il.Id  and s.IdCliente=c.Id and il.IdUnidad=u2.Id $wbuscar Order by d.Nombre,c.Nombre,a.Nombre,il.Nombre"; 
	// 
	header("Location:StockDeposito.php");
}



elseif (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQSTOCKDEP'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Dep&oacute;sito</th>\n";
		echo "<th>Propietario</th>\n";
		echo "<th>Art&iacute;culo o Producto</th>\n";
		echo "<th>Marca</th>\n";
		echo "<th>Modelo</th>\n";			
		echo "<th>Stock</th>\n";
		echo "<th>Unidad</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			//articulo,producto u observaciones
			if($row['Id']>0){//articulo
				$textoart=str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.$row['Nombre'];$abr=$row['Abr'];
			}else{//producto
				$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
			}

			echo "<tr>\n";
			echo '<td>'.$row['Dep']."</td>\n";
			echo '<td>'.$row['Cliente']."</td>\n";
			echo '<td>'.$textoart."</td>\n";
			echo '<td>'.$row['Marca']."</td>\n";
			echo '<td>'.$row['Modelo']."</td>\n";
			echo '<td>'.number_format($row['Stock'],2, ',', '')."</td>\n";
			echo '<td>'.$abr."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }


/*	
//cambia el deposito 
elseif (isset($_POST['CmdWM'])){//hacer backup de stockdepositos antes!!!!!!
	$deposito_nuevo=1;//ALMACEN QUINPE 1
	$deposito_viejo=19;//ADMINISTRACION 19
	//
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//deposito viejo ADMINISTRACION (lo busco para borrarlo o actualizarlo)
	$query="select * from stockdepositos where IdDeposito=$deposito_viejo";	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){ 
		$idreg_old=$row['Id'];
		$idart_old=$row['IdArticulo'];
		$stock_old=$row['Stock'];
		$cliente_old=$row['IdCliente'];
		//deposito nuevo ALMACEN QUINPE + ese articulo (lo busco para actualizarlo)
		$query="select * from stockdepositos where IdDeposito=$deposito_nuevo and IdCliente=$cliente_old and IdArticulo=$idart_old";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){
			//actualizo el deposito nuevo
			$stock=$stock_old + $row2['Stock'];
			$query="update stockdepositos set Stock=$stock Where IdDeposito=$deposito_nuevo and IdCliente=$cliente_old and IdArticulo=$idart_old";$rs3=mysql_query($query,$conn);
			//borro el que tiene deposito viejo porque ya se lo sume/reste al nuevo
			$query="delete from stockdepositos Where Id=$idreg_old";$rs3=mysql_query($query,$conn);
		}else{
			//actualizo el que tiene deposito viejo (no encontre del nuevo para sumar/restar)
			$query="update stockdepositos set IdDeposito=$deposito_nuevo Where Id=$idreg_old";
			$rs3=mysql_query($query,$conn);
		}
		mysql_free_result($rs2);
	}mysql_free_result($rs);	
	mysql_close($conn); 
	//
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:StockDeposito.php");

}	


//cambia el cliente
elseif (isset($_POST['CmdWM'])){//hacer backup de stockdepositos antes!!!!!!
	$deposito=1;//ALMACEN QUINPE 1
	$cliente=135;//QUINPE SRL 135
	//
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//deposito ALMACEN QUINPE + cliente vacio
	$query="select * from stockdepositos where IdDeposito=$deposito and IdCliente=0";
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){ 
		$idregistro1=$row['Id'];
		$idarticulo=$row['IdArticulo'];
		$stock1=$row['Stock'];
		//deposito ALMACEN QUINPE + cliente QUINPE SRL + ese articulo
		$query="select * from stockdepositos where IdDeposito=$deposito and IdCliente=$cliente and IdArticulo=$idarticulo";
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){
			//actualizo el que tiene cliente QUINPE SR
			$stock=$stock1 + $row2['Stock'];
			$query="update stockdepositos set Stock=$stock Where IdDeposito=$deposito and IdCliente=$cliente and IdArticulo=$idarticulo";
			$rs3=mysql_query($query,$conn);
			//borro el que tiene cliente vacio
			$query="delete from stockdepositos Where Id=$idregistro1";
			$rs3=mysql_query($query,$conn);
		}else{
			//actualizo el que tiene cliente vacio
			$query="update stockdepositos set IdCliente=$cliente Where Id=$idregistro1";
			$rs3=mysql_query($query,$conn);
		}
		mysql_free_result($rs2);
	}mysql_free_result($rs);	
	mysql_close($conn); 
	//
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:StockDeposito.php");

}	
*/


?>