<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);




//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.FechaD,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.FechaD,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbUnidad']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdUnidad=$vbuscar";}
	$vbuscar=intval($_POST['CbInstrumento']);if($vbuscar!=0){$wbuscar=$wbuscar." and i.IdElemento=$vbuscar";}
	$vbuscar=intval($_POST['ChkActivo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.TIndef=1";}
	//estado
	$vbuscar=intval($_POST['CbEstado']);
	if($vbuscar==1){$wbuscar=$wbuscar." and a.FechaH='0000-00-00'";}
	if($vbuscar==2){$wbuscar=$wbuscar." and a.FechaH<>'0000-00-00'";}
	//nombre
	if (!(empty($_POST['TxtBusquedaN']))){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wbuscar=$wbuscar." and (i.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusquedaN'])."%')";
		mysql_close($conn); 
	}	
	//
	$_SESSION['TxtQACCASIG']="SELECT i.*,ui.Nombre as Ins,u.Nombre as Unidad,p.Nombre as Nom,p.Apellido as Ape,a.FechaD,a.FechaE,a.FechaH,a.Obs as ObsA,a.Id as IdAs,a.TIndef  From accesorios i,accesorios_tipo ui,accesorios_asig a,unidades u ,personal p where i.Id<>0 and i.IdElemento=ui.Id and a.IdInstrumento=i.Id and a.IdUnidad=u.Id and a.IdPersonal=p.Id $wbuscar Order by i.FechaBaja,i.Nombre,a.FechaH";
	header("Location:Asignaciones.php");
}




elseif (isset($_POST['CmdDevolver'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//valido y agrego fecha baja
	$fechab=date("Y-m-d");
	$query="UPDATE accesorios_asig set FechaH='$fechab' Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 	
	mysql_close($conn); 	
	header("Location:Asignaciones.php");
}


elseif (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$query="Delete From accesorios_asig Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 	
	mysql_close($conn); 	
	header("Location:Asignaciones.php");
}


elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQACCASIG'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Nombre</th>\n";
			echo "<th>Elemento</th>\n";
			echo "<th>Unidad</th>\n";
			echo "<th>Autorizado por</th>\n";
			echo "<th>Desde</th>\n";
			echo "<th>Hasta</th>\n";
			echo "<th>Devuelto</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo "<td >".$row['Id']."</td>\n";
				echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Ins'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Unidad'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Ape'].' '.$row['Nom'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaD'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaE'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaH'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ObsA'])."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

}


 elseif (isset($_POST['CmdImprimir'])){	
	$query=$_POST['TxtQACCASIG'];
	if ($query!=""){
		include("../FPDF/fpdf.php");
		$nivelarbol=$_SESSION["NivelArbol"];
		ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//pdf
		$pdf=new FPDF('L','mm','A4');
		$pdf->AddPage();
		//encabezado
		$titulo="ACCESORIOS ASIGNADOS";
		include("../IncludesPDF/bannerL.php");
		//items
		$y=$pdf->GetY();$y=$y+20;
		$pdf->SetXY(10,$y);	$pdf->SetFont('Arial','B',8);
		$pdf->Cell(105,5,'Unidad',0,0,'L');$pdf->Cell(105,5,'Accesorio',0,0,'L');$pdf->Cell(20,5,'Desde',0,0,'L');$pdf->Cell(20,5,'Hasta',0,0,'L');$pdf->Cell(20,5,'Devuelto',0,0,'L');
		$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,280,$y);	
		$pdf->SetFont('Arial','',8);
		//
		$rs=mysql_query($query,$conn);
		while($row=mysql_fetch_array($rs)){
			$pdf->Cell(105,5,GLO_textoFPDF(substr($row['Unidad'],0,55)),0,0,'L');
			$pdf->Cell(105,5,GLO_textoFPDF(substr($row['Nombre'],0,55)),0,0,'L');
			$pdf->Cell(20,5,GLO_FormatoFecha($row['FechaD']),0,0,'L');
			$pdf->Cell(20,5,GLO_FormatoFecha($row['FechaE']),0,0,'L');
			$pdf->Cell(20,5,GLO_FormatoFecha($row['FechaH']),0,0,'L');
			$pdf->Ln();	
		}mysql_free_result($rs);	
		//fin	
		$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
	}else{GLO_windowclose(0);}
}


?>


