<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	$origen=0;//compras
	include("../Stock/Includes/zBuscarSTCod.php") ;
	$_SESSION['TxtQStock']=$query;
	header("Location:../Stock.php");
}



elseif (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//verifico si tiene items
	$query="SELECT * From stockmov_items where IdMov=".intval($_POST['TxtId']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){//no tiene:borro
		$query="Delete From stockmov Where Id=".intval($_POST['TxtId']);$rs2=mysql_query($query,$conn);
	}else{
		GLO_feedback(12);
	}mysql_free_result($rs);
	mysql_close($conn); 	
	header("Location:../Stock.php");
}



elseif (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQStock'];$query=str_replace("\\", "", $query);
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
		echo "<th>Proveedor</th>\n";
		echo "<th>Dep&oacute;sito</th>\n";
		echo "<th>Rem/Fact</th>\n";
		echo "<th>Observaciones</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$ingreso=0;$egreso=0; $mov=$row['Id'];
			$query2="SELECT sum(Cantidad) as Total From stockmov_items where IdMov=$mov";$rs2=mysql_query($query2,$conn);
			while($row2=mysql_fetch_array($rs2)){$total=$row2['Total'];}mysql_free_result($rs2);
			if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){$ingreso=$total;}else{$egreso=$total;}		
			$compr="";if($row['Suc']>0 or $row['Nro']>0){$compr=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}	
			echo "<tr>\n";
			echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['TipoM'])."</td>\n";
			echo '<td>'.$row['Id']."</td>\n";
			echo '<td>'.number_format($ingreso,2, ',', '')."</td>\n";
			echo '<td>'.number_format($egreso,2, ',', '')."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Proveedor'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Deposito'])."</td>\n";
			echo '<td>'.$compr."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }



?>