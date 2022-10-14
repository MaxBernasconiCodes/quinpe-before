<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);



if (isset($_POST['CmdBuscar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//nombre
	if ((empty($_POST['TxtBusquedaN']))){$wnom="";}
	else{$wnom="and (i.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusquedaN'])."%')";}
	//combos
	$uni=intval($_POST['CbUnidad']);if($uni!=0){$wuni="and a.IdUnidad=$uni";}else{$wuni='';}
	$ins=intval($_POST['CbInstrumento']);if($ins!=0){$wins="and i.IdElemento=$ins";}else{$wins='';}
	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="";}else{$wactivo="and i.FechaBaja='0000-00-00'";}
	//consulta
	if($uni==0){
		$_SESSION['TxtQACC']="SELECT i.*,ui.Nombre as Elem,f.Nombre as Fabric From accesorios i,accesorios_tipo ui,unidadesfabric f  where i.Id<>0 and  i.IdElemento=ui.Id and i.IdFabricante=f.Id  $wnom  $wins Order by i.FechaBaja,i.Nombre";
	}else{
		$_SESSION['TxtQACC']="SELECT i.*,ui.Nombre as Elem,f.Nombre as Fabric From accesorios i,accesorios_tipo ui,unidadesfabric f,accesorios_asig a  where i.Id<>0 and  i.IdElemento=ui.Id and i.IdFabricante=f.Id and a.IdInstrumento=i.Id and a.FechaH='0000-00-00'  $wnom  $wins Order by i.FechaBaja,i.Nombre";
	}
	mysql_close($conn); 
	header("Location:Consulta.php");
}



elseif (isset($_POST['CmdBorrarFila'])){	
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	//busco si tiene Foto
	$query="SELECT Foto From accesorios Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Foto'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	if($archivo==''){
		$query="Delete From accesorios Where Foto='' and Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(31);} 
	}else{GLO_feedback(31);}
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Consulta.php"); 	
}

//pdte hacer
elseif (isset($_POST['CmdExcel'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query=$_POST['TxtQACC'];
	if ($query!=""){
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Elemento</th>\n";
			echo "<th>Modelo</th>\n";				
			echo "<th>Nro.Serie</th>\n";
			echo "<th>Nombre</th>\n";
			echo "<th>Lote</th>\n";
			echo "<th>Fabricante</th>\n";
			echo "<th>Fabricacion</th>\n";
			echo "<th>Inspeccion</th>\n";
			echo "<th>Vto.Inspeccion</th>\n";
			echo "<th>Baja</th>\n";
			echo "<th>Obs</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				//datos
				echo "<tr>\n";
				echo "<td >".$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Elem'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Modelo'])."</td>\n";			
				echo '<td>'.GLO_textoExcel($row['NSE'])."</td>\n";
				echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Lote'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Fabric'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaF'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaI'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaV'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaBaja'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}mysql_free_result($rs);	
	}
	mysql_close($conn); 
}





?>


