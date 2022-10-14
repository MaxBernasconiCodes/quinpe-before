<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	$origen=0;//compras
	include("../Stock/Includes/zBuscarSTDCod.php") ;
	$_SESSION['TxtQStockD']=$query;
	header("Location:../StockD.php");
}



elseif (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQStockD'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Fecha </th>\n";
		echo "<th>Tipo</th>\n";
		echo "<th>Movimiento</th>\n";
		echo "<th>Ingreso</th>\n";			
		echo "<th>Egreso</th>\n";
		echo "<th>Unidad</th>\n";
		echo "<th>Art&iacute;culo o Producto</th>\n";
		echo "<th>Proveedor</th>\n";
		echo "<th>Propietario</th>\n";
		echo "<th>Dep&oacute;sito</th>\n";
		echo "<th>Rem/Fact</th>\n";
		echo "<th>Nro.OC</th>\n";
		echo "<th>Nro.Pedido</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			//articulo,producto u observaciones
			$textoart='';$abr='';
			if($row['IdArticulo']>0){
				$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
			}
			if($row['IdProd']>0){
				$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
			}
			$ingreso=0;$egreso=0;
			if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){$ingreso=$row['Cantidad'];}else{$egreso=$row['Cantidad'];}	
			$compr="";if($row['Suc']>0 or $row['Nro']>0){$compr=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}	
			if($row['NroOC']=='0' and $row['NroOC']==''){$oc='';}else{$oc=$row['NroOC'];}
			if($row['IdNP']==0){$nip='';}else{$nip=str_pad($row['IdNP'], 6, "0", STR_PAD_LEFT);}
			echo "<tr>\n";
			echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['TipoM'])."</td>\n";
			echo '<td>'.$row['Id']."</td>\n";
			echo '<td>'.number_format($ingreso,2, ',', '')."</td>\n";
			echo '<td>'.number_format($egreso,2, ',', '')."</td>\n";
			echo '<td>'.$abr."</td>\n";
			echo '<td>'.GLO_textoExcel($textoart)."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Proveedor'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Cliente'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Deposito'])."</td>\n";
			echo '<td>'.$compr."</td>\n";
			echo '<td>'.$oc."</td>\n";
			echo '<td>'.$nip."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }



?>