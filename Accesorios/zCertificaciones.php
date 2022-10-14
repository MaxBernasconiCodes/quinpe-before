<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//emision
	$wfechad="";$wfechah="";$wfechadv="";$wfechahv="";
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(pp.FechaProg,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(pp.FechaProg,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	//vto
	if (!(empty($_POST['TxtFechaDCP']))){$wfechadv="and DATEDIFF(pp.FechaReal,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";}
	if (!(empty($_POST['TxtFechaHCP']))){$wfechahv="and DATEDIFF(pp.FechaReal,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";}
	$vto=intval($_POST['ChkVtoCP']);
	if($vto==1){$wvto="and (pp.FechaReal<>'0000-00-00' and DATEDIFF(pp.FechaReal,'".FechaMySql(date("d-m-Y"))."')<0 and pp.Inactivo=0)";}else{$wvto='';}

	//combos
	$ins=intval($_POST['CbInstrumento']);if($ins!=0){$wins="and pp.IdInstrumento=$ins";}else{$wins='';}
	$tins=intval($_POST['CbTInstrumento']);if($tins!=0){$wtins="and i.IdElemento=$tins";}else{$wtins='';}
	$cer=intval($_POST['CbCertif']);if($cer!=0){$wcer="and pp.IdTipoCertif=$cer";}else{$wcer='';}
	//consulta
	$_SESSION['TxtQACCCERT']="SELECT pp.*,i.Nombre,ui.Nombre as Ins,im.Nombre as TipoC From accesorios_prog pp,accesorios i,accesorios_tipo ui,instrumentostipocertif im  where pp.Id<>0 and pp.IdInstrumento=i.Id and i.IdElemento=ui.Id and pp.IdTipoCertif=im.Id and pp.Inactivo=0 $wfechad $wfechah $wfechadv $wfechahv $wvto $wins $wcer $wtins $westado Order by pp.Inactivo,pp.FechaProg,i.Nombre";
	mysql_close($conn); 
	header("Location:Certificaciones.php");
}



if (isset($_POST['CmdBorrarFila'])){	
	$query="Delete From accesorios_prog Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Certificaciones.php"); 	
}



if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQACCCERT'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Fecha</th>\n";
		echo "<th>Accesorio</th>\n";
		echo "<th>Elemento</th>\n";
		echo "<th>Certificaci&oacute;n</th>\n";		
		echo "<th>Certificado</th>\n";				
		echo "<th>Vencimiento</th>\n";	
		echo "<th>Observaciones</th>\n";
		echo "<th>Inactivo</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$fechar =GLO_FormatoFecha($row['FechaReal']);
			if ($row['Inactivo']==1){$inac="Inactivo";}else{$inac="";}	
			echo "<tr>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaProg'])."</td>\n";
			echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Ins'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['TipoC'])."</td>\n";				
			echo '<td>'.$row['Certificado']."</td>\n";	
			if ($fechar!="" and (strtotime(date("d-m-Y"))-strtotime($fechar))>0 and $row['Inactivo']==0)
			{echo "<td><font color=red>".$fechar."</font></td>\n";}else{echo '<td>'.$fechar."</td>\n";}				
			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
			echo "<td >".$inac."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>


