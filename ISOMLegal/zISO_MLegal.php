<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(15);




if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wbuscar='';
	//fecha carga
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	//fecha vto
	if (!(empty($_POST['TxtFechaD2']))){$wbuscar=$wbuscar." and DATEDIFF(m.FVto,'".FechaMySql($_POST['TxtFechaD2'])."')>=0";}
	if (!(empty($_POST['TxtFechaH2']))){$wbuscar=$wbuscar." and DATEDIFF(m.FVto,'".FechaMySql($_POST['TxtFechaH2'])."')<=0";}
	//fecha eval
	if (!(empty($_POST['TxtFechaD3']))){$wbuscar=$wbuscar." and DATEDIFF(m.FEval,'".FechaMySql($_POST['TxtFechaD3'])."')>=0";}
	if (!(empty($_POST['TxtFechaH3']))){$wbuscar=$wbuscar." and DATEDIFF(m.FEval,'".FechaMySql($_POST['TxtFechaH3'])."')<=0";}
	
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and m.IdAlcance=$vbuscar";}
	$vbuscar=intval($_POST['CbPer']);if($vbuscar!=0){$wbuscar=$wbuscar." and m.IdPeriod=$vbuscar";}
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$wbuscar=$wbuscar." and m.Eval=$vbuscar";}
	
	$_SESSION['TxtQuery65']="Select m.*,a.Nombre as Alcance,p.Nombre as Per From iso_matriz m,iso_matriz_a a,iso_matriz_p p Where m.IdAlcance=a.Id and m.IdPeriod=p.Id  $wbuscar Order by m.Fecha";
	header("Location:../ISO_MLegal.php");
}


if (isset($_POST['CmdBorrarFila'])){	
	$query="Delete From iso_matriz Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:../ISO_MLegal.php"); 	
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery65'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Fecha</th>\n";			
			echo "<th>Alcance</th>\n";	
			echo "<th>Req.Legal</th>\n";			
			echo "<th>Identificaci&oacute;n</th>\n";
			echo "<th>Detalle de Identificaci&oacute;n</th>\n";	
			echo "<th>Periodicidad</th>\n";		
			echo "<th>F.Vto</th>\n";
			echo "<th>Responsable</th>\n";
			echo "<th>Registro de Verificacion.</th>\n";
			echo "<th>Eval.</th>\n";
			echo "<th>F.Eval</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				$colorestado='';$cumpl='';
				if ($row['Eval']==1) {$cumpl='SI';$colorestado=' style="font-weight:bold;color:#4CAF50"';}// VERDE 	
				if ($row['Eval']==2) {$cumpl='NO';$colorestado=' style="font-weight:bold;color:#f44336"';}//ROJO
				if ($row['Eval']==3) {$cumpl='N/A';}
				//fecha
			if($row['FVto']!='0000-00-00'){$fechav =FormatoFecha($row['FVto']);}else{$fechav='';}
			if($row['FEval']!='0000-00-00'){$fechae =FormatoFecha( $row['FEval']);}else{$fechae='';}
				
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Alcance'])."</td>\n";					
				echo '<td>'.GLO_textoExcel($row['Req'])."</td>\n";					
				echo '<td>'.GLO_textoExcel($row['Ident'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Detalle'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Per'])."</td>\n";
				echo '<td>'.$fechav."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Resp'])."</td>\n";		
				echo '<td>'.GLO_textoExcel($row['Reg'])."</td>\n";	
				echo "<td ".$colorestado.">".$cumpl."</td>\n";
				echo '<td>'.$fechae."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
?>