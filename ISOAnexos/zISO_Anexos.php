<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdBuscar'])){
	$consulta="";
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$nrodoc=intval($_POST['TxtNro']);if($nrodoc!=0){$wdoc="and d.Id=$nrodoc";}else{$wdoc='';}
	$sec=intval($_POST['CbSector']);if($sec!=0){$wsec="and d.IdSector=$sec";}else{$wsec='';}
	if ((empty($_POST['TxtBusqueda']))){$wnom="";}else{$wnom="and (d.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//consulta
	$consulta="Select d.*,s.Nombre as Sector From iso_anexos d,sector s Where d.Id<>0 and d.IdSector=s.Id $wnom $wsec $wdoc Order By d.Id";
	mysql_close($conn); 
	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtConsultaAnx']=$consulta;
	header("Location:../ISO_Anexos.php");
}




if (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From iso_anexos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_anexos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/SGIDoc/Anexos/'.$archivo) ;}
	mysql_close($conn); 
	header("Location:../ISO_Anexos.php");
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("iso_anexos",intval($_POST['TxtId']),"SGIDoc/Anexos/","Ruta");
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtConsultaAnx'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Numero</th>\n";			
			echo "<th>Nombre</th>\n";
			echo "<th>Origen</th>\n";
			echo "<th>Sector</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				$ori="";if($row['Origen']==1){$ori='Externo';}elseif($row['Origen']==2){$ori='Interno';}	
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Origen'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
 
 
?>