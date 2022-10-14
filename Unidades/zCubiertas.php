<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

if (isset($_POST['CmdBuscar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbUnidad']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdUnidad=$vbuscar";}
	$vbuscar=intval($_POST['CbMarca']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdMarca=$vbuscar";}
	$vbuscar=intval($_POST['ChkI1']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Ali=0";}
	$vbuscar=intval($_POST['ChkI2']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Bal=0";}
	if (!(empty($_POST['TxtBusqueda']))){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wbuscar=$wbuscar." and (u.Dominio Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";
		mysql_close($conn); 
	}
	//
	$_SESSION['TxtQuery']="SELECT a.*,t.Nombre as Marca,u.Dominio,u.Nombre From unidades_cubiertas a,unidades_marcascub t,unidades u where a.Id<>0 and  t.Id=a.IdMarca and a.IdUnidad=u.Id $wbuscar Order by a.Fecha";
	//
	header("Location:Cubiertas.php");
}



if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Unidad</th>\n";
			echo "<th>Dominio</th>\n";
			echo "<th>Fecha</th>\n";
			echo "<th>Marca</th>\n";
			echo "<th>Cantidad</th>\n";
			echo "<th>Medida</th>\n";		
			echo "<th>Odometro</th>\n";
			echo "<th>Km recorridos</th>\n";
			echo "<th>Alineacion</th>\n";
			echo "<th>Balanceo</th>\n";
			echo "<th>Ubicacion reemplazo</th>\n";
			echo "<th>Obs</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";
				echo "<td >".GLO_textoExcel($row['Dominio'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo "<td >".GLO_textoExcel($row['Marca'])."</td>\n";
				echo "<td >".$row['Cant']."</td>\n";
				echo "<td >".GLO_textoExcel($row['Med'])."</td>\n";
				echo "<td >".$row['Odo']."</td>\n";
				echo "<td >".$row['KmR']."</td>\n";
				echo "<td >".GLO_Si($row['Ali'])."</td>\n";
				echo "<td >".GLO_Si($row['Bal'])."</td>\n";
				echo "<td >".GLO_textoExcel($row['UbiR'])."</td>\n";
				echo "<td >".GLO_textoExcel($row['Obs'])."</td>\n";
				
				
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
}



?>