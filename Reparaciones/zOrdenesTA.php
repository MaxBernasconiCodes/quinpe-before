<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//where 
	$wbuscar="";
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(ra.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(ra.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbPersonal']);if($vbuscar!=0){$wbuscar=$wbuscar." and (ra.IdPersonal=$vbuscar or ra.IdPersonal1=$vbuscar or ra.IdPersonal2=$vbuscar or ra.IdPersonal3=$vbuscar )";}
	//asignadas
	$wbuscar=$wbuscar." and (ra.IdPersonal!=0 or ra.IdPersonal1!=0 or ra.IdPersonal2!=0 or ra.IdPersonal3!=0)";
	//query
	$_SESSION['TxtQREPORDTA']="SELECT ra.Id, rr.IdPR as IdOrden,u.Dominio,u.Nombre as Uni,ra.Fecha as FechaT,ra.Obs as ObsT,sm.Nombre as Sector,ins.Nombre as Instr,p.Nombre as Nom,p.Apellido as Ap,p1.Nombre as Nom1,p1.Apellido as Ap1,p2.Nombre as Nom2,p2.Apellido as Ap2,p3.Nombre as Nom3,p3.Apellido as Ap3 From pedidosrepord r,pedidosrepreq rr,pedidosrepreq_act ra,unidades u,sectorm sm,epparticulos ins,personal p,personal p1,personal p2,personal p3  where r.Id<>0 and rr.IdPR=r.Id  and ra.IdPRR=rr.Id and r.IdUnidad=u.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id and ra.IdPersonal=p.Id and ra.IdPersonal1=p1.Id and ra.IdPersonal2=p2.Id and ra.IdPersonal3=p3.Id $wbuscar Order by ra.Fecha,r.Id";
	header("Location:OrdenesTA.php");
}



elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQREPORDTA'];
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Orden</th>\n";
			echo "<th>Unidad</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Equipo</th>\n";
			//
			echo "<th>Responsable</th>\n";	
			echo "<th>Responsable</th>\n";	
			echo "<th>Responsable</th>\n";	
			echo "<th>Responsable</th>\n";	
			//
			echo "<th>Fecha T.</th>\n";	
			echo "<th>Tarea</th>\n";	
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				echo "<td >".$row['IdOrden']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";
				//	
				echo '<td>'.GLO_textoExcel($row['Ap'].' '.$row['Nom'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Ap1'].' '.$row['Nom1'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Ap2'].' '.$row['Nom2'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Ap3'].' '.$row['Nom3'])."</td>\n";	
				//
				echo '<td>'.GLO_FormatoFecha($row['FechaT'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ObsT'])."</td>\n";	
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
	
}
	

elseif (isset($_POST['CmdImprimir'])){
	include("../FPDF/fpdf.php");
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//pdf
	$pdf=new FPDF('L','mm','A4');
	$pdf->AddPage();
	$titulo="TAREAS ASIGNADAS";
	include("../IncludesPDF/bannerL.php");
	$pdf->SetY(40);
	//
	$query=$_POST['TxtQREPORDTA'];
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			$pdf->SetFont('Arial','B',8);$pdf->SetX(10);
			$pdf->Cell(15,5,'Orden',0,0,'L');
			$pdf->Cell(35,5,'Unidad',0,0,'L');
			$pdf->Cell(30,5,'Sector',0,0,'L');
			$pdf->Cell(30,5,'Equipo',0,0,'L');
			$pdf->Cell(20,5,'Responsable',0,0,'L');
			$pdf->Cell(20,5,'Responsable',0,0,'L');
			$pdf->Cell(20,5,'Responsable',0,0,'L');
			$pdf->Cell(20,5,'Responsable',0,0,'L');
			$pdf->Cell(20,5,'Fecha T.',0,0,'L');
			$pdf->Cell(60,5,'Tarea',0,0,'L');			
			$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,280,$y);
			while($row=mysql_fetch_array($rs)){ 
				$pdf->Ln(2);$pdf->SetX(10);
				$pdf->Cell(15,4,str_pad($row['IdOrden'], 6, "0", STR_PAD_LEFT),0,0,'L');
				$pdf->Cell(35,4,GLO_textoFPDF(substr($row['Uni'].' '.$row['Dominio'],0,20)),0,0,'L');
				$pdf->Cell(30,4,GLO_textoFPDF(substr($row['Sector'],0,15)),0,0,'L');
				$pdf->Cell(30,4,GLO_textoFPDF(substr($row['Instr'],0,15)),0,0,'L');				
				$pdf->Cell(20,4,GLO_textoFPDF(substr($row['Ap'].' '.$row['Nom'],0,9)),0,0,'L');
				$pdf->Cell(20,4,GLO_textoFPDF(substr($row['Ap1'].' '.$row['Nom1'],0,9)),0,0,'L');
				$pdf->Cell(20,4,GLO_textoFPDF(substr($row['Ap2'].' '.$row['Nom2'],0,9)),0,0,'L');
				$pdf->Cell(20,4,GLO_textoFPDF(substr($row['Ap3'].' '.$row['Nom3'],0,9)),0,0,'L');
				$pdf->Cell(20,4,GLO_FormatoFecha($row['FechaT']),0,0,'L');
				$pdf->MultiCell(60,4,GLO_textoFPDF($row['ObsT']),0,'L',0,4);				
				//renglones	
				$pdf->SetDrawColor(128,128,128);//rgb gris
				$pdf->Ln(2);$y=$pdf->GetY();$pdf->Line(10,$y,280,$y);
			}
		}mysql_free_result($rs);
	}	
	//desconecto y termino
	mysql_close($conn); 	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}





?>


