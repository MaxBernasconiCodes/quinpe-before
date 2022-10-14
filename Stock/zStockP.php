<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST[CmdBuscar])){
	$consulta="";
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wfechad="and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";
	$wfechah="and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";		
	if ((empty($_POST['TxtBusqueda']))){$wnom="";}
	else{$wnom="and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	$tipo=intval($_POST['CbTipoMS']);
	$rubro=intval($_POST['CbRubro']);
	$dep=intval($_POST['CbDeposito']);
	if($tipo!=0){$wtipo="and s.IdTipoMov=$tipo";}else{$wtipo='';}
	if($rubro!=0){$wrubro="and a.IdRubro=$rubro";}else{$wrubro='';}
	if($dep!=0){$wdep="and s.IdDeposito=$dep";}else{$wdep='';}
	$nrooc=intval($_POST['TxtNroOC']);if($nrooc!=0){$wnrooc="and co.Nro=$nrooc";}else{$wnrooc="";}
	$consulta="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,p.Apellido as Proveedor,a.Nombre as Articulo,i.Cantidad,i.IdArticulo,i.IdOC,u.Abr,a.Modelo, m.Nombre as Marca,np.Nro as NroNP,np.Id as IdNP,co.Nro as NroOC2,npi.CantAuto From stockmov s,depositos d,stock_tipomov t,proveedores p,stockmov_items i,epparticulos a,unidadesmedida u,marcas m,co_npedido np,co_ocompra_it coi,co_ocompra co,co_npedido_it npi where i.IdItemOC=coi.Id and coi.IdItemNP=npi.Id and coi.IdOCompra=co.Id and np.Id=npi.IdNP and s.IdDeposito=d.Id and s.IdTipoMov=t.Id and s.IdProveedor=p.Id and i.IdMov=s.Id and i.IdArticulo=a.Id and a.IdUnidad=u.Id and a.IdMarca=m.Id and s.IdTipoMov=3 $wfechad $wfechah $wnom $wtipo $wrubro $wdep $wnrooc Order by s.Fecha,s.Id,i.IdOC,np.Nro";
	$_SESSION[TxtQuery71]=$consulta;
	mysql_close($conn); 
	header("Location:../StockP.php");
}



elseif (isset($_POST[CmdExcel])){
$query=$_POST['TxtQuery71'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Fecha </th>\n";
		echo "<th>Tipo</th>\n";
		echo "<th>Movimiento</th>\n";
		echo "<th>Cantidad</th>\n";			
		echo "<th>Pendiente</th>\n";
		echo "<th>Unidad</th>\n";
		echo "<th>Art&iacute;culo</th>\n";
		echo "<th>Descripci&oacute;n</th>\n";
		echo "<th>Marca</th>\n";
		echo "<th>Modelo</th>\n";
		echo "<th>Proveedor</th>\n";
		echo "<th>Dep&oacute;sito</th>\n";
		echo "<th>Rem/Fact</th>\n";
		echo "<th>Nro.IntOC</th>\n";
		echo "<th>Nro.OC</th>\n";
		echo "<th>Nro.IntPedido</th>\n";
		echo "<th>Nro.Pedido</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$pdte=0;$pdte=$row['CantAuto']-$row['Cantidad'];
			//muestra solo si pdte >0
			if($pdte>0){	
				if($pdte>0){$pdte=number_format($pdte,2, ',', '');}else{$pdte='';}			
				$compr="";if($row['Suc']>0 or $row['Nro']>0){$compr=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}	
				if($row['IdOC']==0){$oc='';}else{$oc=str_pad($row['IdOC'], 6, "0", STR_PAD_LEFT);}
				if($row['NroNP']==0){$np='';}else{$np=str_pad($row['NroNP'], 6, "0", STR_PAD_LEFT);}
				if($row['IdNP']==0){$nip='';}else{$nip=str_pad($row['IdNP'], 6, "0", STR_PAD_LEFT);}
				if($row['NroOC2']==0){$nrooc='';}else{$nrooc=str_pad($row['NroOC2'], 6, "0", STR_PAD_LEFT);}
				echo "<tr>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['TipoM'])."</td>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.number_format($row['Cantidad'],2, ',', '')."</td>\n";
				echo '<td>'.$pdte."</td>\n";
				echo '<td>'.$row['Abr']."</td>\n";
				echo '<td>'.$row['IdArticulo']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Articulo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Marca'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Modelo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Proveedor'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Deposito'])."</td>\n";
				echo '<td>'.$compr."</td>\n";
				echo '<td>'.$oc."</td>\n";
				echo '<td>'.$nrooc."</td>\n";
				echo '<td>'.$nip."</td>\n";
				echo '<td>'.$np."</td>\n";
				echo "</tr>\n";	
			}		
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }



?>