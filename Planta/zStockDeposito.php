<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$_SESSION['TxtQSTOCKDEPPL']="";$_SESSION['TxtQSTOCKDEPPLR']="";		
	//init
	$wbuscar='';$wbuscardet='';$wbuscarres='';$wbuscarart='';
	//where comun a todos
	$wbuscar=$wbuscar." and d.Tipo=1 and s.Stock<>0";//solo muestra depositos tipo planta con productos
	$vbuscar=intval($_POST['CbDeposito']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdDeposito=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdCliente=$vbuscar";}	
	//where articulos
	$vbuscar=intval($_POST['CbRubro']);if($vbuscar!=0){$wbuscarart=$wbuscarart." and a.IdRubro=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscarart=$wbuscarart." and a.EPP=$vbuscar";}
	//buscar articulo/item
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//detallado
		$wbuscardet=$wbuscardet." and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
		//resumido
		$wbuscarres=$wbuscarres." and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda']).")) )";
		mysql_close($conn); 
	}
	
	//verifico si es resumido
	if(intval($_POST['Chk1'])==0){//no es resumido
		$_SESSION['TxtQSTOCKDEPPL']="SELECT a.*, d.Nombre as Dep,s.Stock,u.Abr,s.IdDeposito,s.Id as IdST,il.Nombre as Prod,il.Id as IdProd,c.Nombre as Cliente,s.IdCliente,u2.Abr as Abr2  From stockdepositos s,epparticulos a, unidadesmedida u,depositos d,items il,clientes c,unidadesmedida u2 where s.IdArticulo=a.Id and s.IdDeposito=d.Id and a.IdUnidad=u.Id and s.IdItem=il.Id and il.IdUnidad=u2.Id and s.IdCliente=c.Id $wbuscar $wbuscardet $wbuscarart Order by d.Nombre,c.Nombre,a.Nombre,il.Nombre"; 
	}else{//si es resumido
		$queryarticulos="SELECT SUM(s.Stock) as Stock,a.Id,a.Nombre,CONCAT(a.Id,'A') As IdR,u.Abr From stockdepositos s,depositos d,epparticulos a, unidadesmedida u where s.IdDeposito=d.Id and s.IdArticulo=a.Id and a.IdUnidad=u.Id and a.Id<>0 $wbuscar $wbuscarres $wbuscarart GROUP BY a.Id,a.Nombre,u.Abr";
		$queryproductos="SELECT SUM(s.Stock) as Stock,a.Id,a.Nombre,CONCAT(a.Id,'P') As IdR,u.Abr  From stockdepositos s,depositos d,items a,unidadesmedida u where s.IdDeposito=d.Id and s.IdItem=a.Id and a.IdUnidad=u.Id and a.Id<>0 $wbuscar $wbuscarres GROUP BY a.Id,a.Nombre,u.Abr";
		//si filtra rubro no trae productos
		if(empty($wbuscarart)){
			$_SESSION['TxtQSTOCKDEPPLR']="SELECT x.* From ($queryarticulos UNION ALL $queryproductos) x ORDER BY x.Nombre";
		}else{
			$_SESSION['TxtQSTOCKDEPPLR']="SELECT x.* From ($queryarticulos) x ORDER BY x.Nombre";
		}
		
	}
	
	header("Location:StockDeposito.php");
}



elseif (isset($_POST['CmdExcel'])){
	//valido si muestro detallado o resumido
	if(empty($_POST['TxtQSTOCKDEPPL'])){$query=$_POST['TxtQSTOCKDEPPLR'];$resumido=1;}
	else{$query=$_POST['TxtQSTOCKDEPPL'];$resumido=0;}
	//
	if ( !( empty($query)) ){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			if($resumido==0){
				echo "<th>Dep&oacute;sito</th>\n";
				echo "<th>Propietario</th>\n";
			}
			echo "<th>Art&iacute;culo o Producto</th>\n";
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
				if($resumido==0){
					echo '<td>'.$row['Dep']."</td>\n";
					echo '<td>'.$row['Cliente']."</td>\n";
				}
				echo '<td>'.$textoart."</td>\n";
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




?>