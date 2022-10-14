<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$wbuscar="";
	if(!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(d.FechaCRE,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if(!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(d.FechaCRE,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	//
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and d.IdTipoDoc=$vbuscar";}
	$vbuscar=intval($_POST['CbOrigen']);if($vbuscar!=0){$wbuscar=$wbuscar." and d.Origen=$vbuscar";}
	$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and d.IdSector=$vbuscar";}	
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=999){$wbuscar=$wbuscar." and d.IdEstado=$vbuscar";}	
	$vbuscar=intval($_POST['TxtNro']);if($vbuscar!=0){$wbuscar=$wbuscar." and d.Id=$vbuscar";}
	//
	$vbuscar=mysql_real_escape_string($_POST['TxtCod']);
	if($vbuscar!=''){$wbuscar=$wbuscar." and (d.Codigo Like '%".$vbuscar."%')";}
	//
	$vbuscar=mysql_real_escape_string($_POST['TxtBusqueda']);
	if($vbuscar!=''){$wbuscar=$wbuscar." and (d.Nombre Like '%".$vbuscar."%')";}
	//consulta
	$_SESSION['TxtConsultaDoc']="Select d.*,t.Nombre as Tipo,e.Nombre as Estado,s.Nombre as Sector,r.Nombre as Req,r.Nro as NReq ,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3,pr.Apellido as RSProv From iso_doc d,iso_doc_tipo t,iso_doc_estados e,sector s,iso_nc_req r,personal p1,personal p2,personal p3,proveedores pr Where t.Id=d.IdTipoDoc and e.Id=d.IdEstado and s.Id=d.IdSector and r.Id=d.IdReq and p1.Id=d.IdPersCRE and pr.Id=d.IdProvCRE and p2.Id=d.IdPersCON and p3.Id=d.IdPersAPR $wbuscar Order By d.Codigo";
	mysql_close($conn); 
	header("Location:../ISO_Doc.php");
}

if (isset($_POST['CmdRefresh'])){	
	$_SESSION["TxtConsultaDoc"]="";
	header("Location:../ISO_Doc.php");
}


if (isset($_POST['CmdBorrarFila'])){//borra si esta 0:elaborado,3:rev.controlado y sin adjunto
	$query="Delete From iso_doc Where Ruta='' and Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Doc.php");
}



if (isset($_POST['CmdVerFile'])){	
	GLO_OpenFile("iso_doc",intval($_POST['TxtId']),"SGIDoc/","Ruta");
}


if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtConsultaDoc'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th> Doc.</th>\n";			
			echo "<th>C&oacute;digo</th>\n";		
			echo "<th>Nombre</th>\n";
			echo "<th>Versi&oacute;n</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Tipo</th>\n";
			echo "<th>Origen</th>\n";
			echo "<th>Estado</th>\n";
			echo "<th>Creaci&oacute;n</th>\n";
			echo "<th>Control</th>\n";
			echo "<th>Aprobaci&oacute;n</th>\n";
			echo "<th>Expiraci&oacute;n</th>\n";
			echo "<th>Cre&oacute;</th>\n";
			echo "<th>Control&oacute;</th>\n";
			echo "<th>Aprob&oacute;</th>\n";
			echo "<th>Coment.Creador</th>\n";
			echo "<th>Coment.Controlador</th>\n";
			echo "<th>Coment.Aprobador</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				if($row['FechaCRE']!='0000-00-00'){$fecha1 =FormatoFecha($row['FechaCRE']);}else{$fecha1='';}
				if($row['FechaCON']!='0000-00-00'){$fecha2 =FormatoFecha($row['FechaCON']);}else{$fecha2='';}
				if($row['FechaAPR']!='0000-00-00'){$fecha3 =FormatoFecha($row['FechaAPR']);}else{$fecha3='';}
				if($row['FechaEXP']!='0000-00-00'){$fecha4 =FormatoFecha($row['FechaEXP']);}else{$fecha4='';}
				$ori='';if($row['Origen']==1){$ori='Externo';}if($row['Origen']==2){$ori='Interno';}
				//excel
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Codigo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.$row['Version']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($ori)."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";				
				echo '<td>'.$fecha1."</td>\n";
				echo '<td>'.$fecha2."</td>\n";
				echo '<td>'.$fecha3."</td>\n";
				echo '<td>'.$fecha4."</td>\n";
				echo '<td>'.GLO_textoExcel($row['A1'].' '.$row['N1'].'   '.$row['RSProv'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['A2'].' '.$row['N2'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['A3'].' '.$row['N3'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['ComentCRE'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ComentCON'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ComentAPR'])."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
 
 
?>