<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){ 	
	//conecto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wfechad="";$wfechah="";$wnro="";$wsoli="";$wsec="";$west="";$wauto="";$wctro="";
	$wprov="";$wnropi="";
	//criterios
	if (!(empty($_POST['TxtFechaDCOCOT']))){$wfechad="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaDCOCOT'])."')>=0";}
	if (!(empty($_POST['TxtFechaHCOCOT']))){$wfechah="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaHCOCOT'])."')<=0";}
	$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and co.Id=$nro";}
	$nropi=intval($_POST['TxtNroPI']);if($nropi!=0){$wnropi="and np.Id=$nropi";}
	$soli=intval($_POST['CbSoli']);if($soli!=0){$wsoli="and np.IdPerSoli=$soli";}
	$auto=intval($_POST['CbAuto']);if($auto!=0){$wauto="and (np.IdPerPAuto=$auto or np.IdPerAuto=$auto)";}
	$sec=intval($_POST['CbSector']);if($sec!=0){$wsec="and np.IdSector=$sec";}
	$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and co.IdProv=$prov";}
	$est=intval($_POST['CbEstado']);if($est!=0){$west="and co.IdEstado=$est";}
	//buscar articulo/item
	$wnom="";
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$wnom="and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
	}
	//query
	$query="Select co.*,np.Id as IdNP,np.Prioridad,npi.CantAuto as CantAutoItem,np.Obs as ObsNP,p1.Nombre as NomS,p1.Apellido as ApeS,s.Nombre as Sector,a.Id as IdArticuloItem, a.Nombre as Articulo,um.Abr,p.Apellido as Prov,e.Nombre as Estado,i.Id as IdIC,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_pcotiz as co,co_pcotiz_it i,co_npedido np,co_npedido_it npi, personal p1,sector s,epparticulos a,unidadesmedida um,proveedores p,co_pcotiz_est e,items il,unidadesmedida u2 Where co.Id=i.IdPCotiz and npi.Id=i.IdItemNP and np.Id=npi.IdNP and np.IdPerSoli=p1.Id and np.IdSector=s.Id and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and co.IdProv=p.Id and co.IdEstado=e.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id $wfechad $wfechah $wnro $wnropi $wsoli $wsec $west $wnom $wauto $wprov Order by np.Id";		
	//vuelvo
	mysql_close($conn);
	$_SESSION['TxtQuery20']=$query;
	header("Location:CotizacionesD.php");
}






elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery20'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Cotiz.</th>\n";
			echo "<th>Alta Cotiz.</th>\n";
			echo "<th>Proveedor Cotiz.</th>\n";	
			echo "<th>Solicitante</th>\n";	
			echo "<th>Sector</th>\n";	
			echo "<th>Cant</th>\n";	
			echo "<th>UnMed</th>\n";
			echo "<th>Art&iacute;culo o Producto</th>\n";	
			echo "<th>Pedido</th>\n";
			echo "<th>Estado Cotiz.</th>\n";
			echo "<th>Obs.Pedido Interno</th>\n";
			echo "<th>Obs.Cotizaci&oacute;n</th>\n";		
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				//articulo,producto u observaciones
				$textoart='';$abr='';
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}
				if($row['IdProd']>0){
					$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
				}
	
				if($row['IdProv']==0){$prov=substr($row['Obs2'],0,30);}else{$prov=substr($row['Prov'],0,30);}
				//estado
				$colorest='';
				if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}//verde
				if($row['IdEstado']==4){$colorest=' style="font-weight:bold;color:#f44336"';}//rojo
				//
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($prov)."</td>\n";						
				echo '<td>'.GLO_textoExcel($row['ApeS'].' '.$row['NomS'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.number_format($row['CantAutoItem'],2, ',', '')."</td>\n";
				echo '<td>'.$abr."</td>\n";	
				echo '<td>'.$textoart."</td>\n";
				echo '<td>'.$row['IdNP']."</td>\n";	
				echo "<td ".$colorest.">".$row['Estado']."</td>\n";		
				echo '<td>'.GLO_textoExcel($row['ObsNP'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";	
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }



?> 

