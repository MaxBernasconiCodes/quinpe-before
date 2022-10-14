<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){ 	
	//conecto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wfechad="";$wfechah="";$wsoli="";$wsec="";$west="";$wauto="";
	//criterios
	if (!(empty($_POST['TxtFechaDCONP']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaDCONP'])."')>=0";}
	if (!(empty($_POST['TxtFechaHCONP']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaHCONP'])."')<=0";}
	$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Id=$nroped";}else{$wnroped="";}
	$soli=intval($_POST['CbSoli']);if($soli!=0){$wsoli="and np.IdPerSoli=$soli";}
	$auto=intval($_POST['CbAuto']);if($auto!=0){$wauto="and (np.IdPerPAuto=$auto or np.IdPerAuto=$auto)";}
	$sec=intval($_POST['CbSector']);if($sec!=0){$wsec="and np.IdSector=$sec";}
	//query pagina
	$_SESSION['TxtQNOTAP']="Select np.*,p1.Nombre as NomS,p1.Apellido as ApeS,s.Nombre as Sector From co_npedido np, personal p1,sector s Where np.IdPerSoli=p1.Id and np.IdSector=s.Id $wfechad $wfechah $wsoli $wsec $wauto $wnroped Order by np.Id";		
	//vuelvo
	mysql_close($conn);
	header("Location:NotasPedido.php");
}





elseif (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From co_npedido where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 	
	header("Location:NotasPedido.php");
}



elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQNOTAP'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Nro.Pedido</th>\n";
			echo "<th>Alta</th>\n";	
			echo "<th>Titulo</th>\n";			
			echo "<th>Solicitante</th>\n";	
			echo "<th>Sector</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Titulo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ApeS'].' '.$row['NomS'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }



?> 

