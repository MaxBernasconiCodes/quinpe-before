<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wfechad="";$wfechah="";$wnro="";$west="";$wprov="";
	//criterios
	if (!(empty($_POST['TxtFechaDCOCOT']))){$wfechad="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaDCOCOT'])."')>=0";}
	if (!(empty($_POST['TxtFechaHCOCOT']))){$wfechah="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaHCOCOT'])."')<=0";}
	$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and co.Id=$nro";}
	$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and co.IdProv=$prov";}
	$est=intval($_POST['CbEstado']);if($est!=0){$west="and co.IdEstado=$est";}
	//query
	$query="Select co.*,p.Apellido as Prov,e.Nombre as Estado From co_pcotiz co,proveedores p,co_pcotiz_est e Where co.IdProv=p.Id and  co.IdEstado=e.Id $wfechad $wfechah $wnro $wprov $west Order by co.Id";		
	$_SESSION['TxtQuery17']=$query;
	header("Location:Cotizaciones.php");
}



elseif (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//verifico si tiene items
	$query="SELECT * From co_pcotiz_it where IdPCotiz=".intval($_POST['TxtId']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){//no tiene:borro
		$query="Delete From co_pcotiz where Id=".intval($_POST['TxtId']);$rs2=mysql_query($query,$conn);
	}else{
		GLO_feedback(12); 
	}mysql_free_result($rs);
	mysql_close($conn); 	
	header("Location:Cotizaciones.php");
}




elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery17'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Alta</th>\n";	
			echo "<th>Proveedor</th>\n";		
			echo "<th>Estado</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				//estado
				$colorest='';
				if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}//verde
				if($row['IdEstado']==4){$colorest=' style="font-weight:bold;color:#f44336"';}//rojo
				if($row['IdProv']==0){$prov=substr($row['Obs2'],0,30);}else{$prov=substr($row['Prov'],0,30);}
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($prov)."</td>\n";			
				echo "<td ".$colorest.">".$row['Estado']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }



?> 

