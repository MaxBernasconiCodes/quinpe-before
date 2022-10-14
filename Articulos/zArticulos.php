<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.EPP=$vbuscar";}	
	$vbuscar=intval($_POST['CbRubro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdRubro=$vbuscar";}
	$vbuscar=intval($_POST['ChkReq']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Stock=1";}
	$vbuscar=intval($_POST['ChkF1']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Stock=0";}
	
	//nombre
	if (!(empty($_POST['TxtBusqueda']))){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wbuscar=$wbuscar." and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";
		mysql_close($conn); 
	}	
	//
	$activo=intval($_POST['ChkActivo']);
	$vto=intval($_POST['ChkVE']);
	if($activo!=0 or $vto!=0){
		$wbuscar=$wbuscar." and (a.FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',a.FechaBaja)<0)";
		if($vto!=0){$wbuscar=$wbuscar." and (DATEDIFF('".FechaMySql(date("d-m-Y")). "',a.FechaV)>0)";} 
	}
	//query pagina
	$_SESSION['TxtQArt']="SELECT a.*, m.Nombre as Marca, r.Nombre as Rubro From epparticulos a,marcas m, rubros r where a.Id<>0 and a.IdMarca=m.Id and a.IdRubro=r.Id $wbuscar  Order by a.FechaBaja,a.Nombre";
	//query excel
	$_SESSION['TxtQArtEX']="SELECT a.*, m.Nombre as Marca, r.Nombre as Rubro, u.Nombre as Unidad,u.Abr From epparticulos a,marcas m, rubros r, unidadesmedida u where a.Id<>0 and a.IdMarca=m.Id and a.IdRubro=r.Id and a.IdUnidad=u.Id $wbuscar Order by a.FechaBaja,a.Nombre";
	header("Location:../Articulos.php");
}



if (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$query="Delete From epparticulos Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 	
	header("Location:../Articulos.php");
}



if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQArtEX'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Numero</th>\n";
		echo "<th>Descripci&oacute;n</th>\n";
		echo "<th>Tipo</th>\n";
		echo "<th>Rubro</th>\n";
		echo "<th>Marca</th>\n";
		echo "<th>Modelo</th>\n";		
		echo "<th>Unidad</th>\n";		
		echo "<th>Stock</th>\n";
		echo "<th>Frecuencia</th>\n";
		echo "<th>NSE</th>\n";
		echo "<th>Obs</th>\n";
		echo "<th>Vto</th>\n";
		echo "<th>Baja</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			if($row['Stock']==1){$stock='Stock';}else{$stock='';}
			echo "<tr>\n";
			echo '<td>'.$row['Id']."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
			echo '<td>'.GLO_textoExcel(ART_Tipo($row['EPP']))."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Rubro'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Marca'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Modelo'])."</td>\n";			
			echo '<td>'.GLO_textoExcel($row['Unidad'])."</td>\n";
			echo '<td>'.$stock."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Frecuencia'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['NSE'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaV'])."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaBaja'])."</td>\n";
			echo "</tr>\n";			
		}mysql_free_result($rs);	
		echo "</table>\n";				
	}mysql_close($conn); 
}
}




?>