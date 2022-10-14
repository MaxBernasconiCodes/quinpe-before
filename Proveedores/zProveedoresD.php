<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//
	$wbuscar='';
	if (!(empty($_POST['TxtBusqueda']))){$wbuscar=$wbuscar." and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//query 
	$_SESSION['TxtQPROVD']='SELECT v.*,p.Apellido From proveedores_des v,proveedores p where v.Id<>0 and v.IdEntidad=p.Id '.$wbuscar.' Order by p.Apellido,v.Fecha';
	mysql_close($conn); 
	header("Location:ProveedoresD.php");
}




elseif (isset($_POST['CmdLinkRow2'])){
	header("Location:ModificarDes.php?gidf=1&gid=".intval($_POST['TxtId']));
}


elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQPROVD'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//PHPExcel 
			require_once '../PHPExcel/Classes/PHPExcel.php';
			require_once '../Codigo/PHPExcelStyle.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();			
			//titulos
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Razon Social');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Fecha');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Trayectoria');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Gestion');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Total');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Descripcion');
			//filas
			$fila=2;
			while($row=mysql_fetch_array($rs)){ 
                include ("Includes/zTotales.php");
                $color1=PROV_EPestilo($t3,1,1);
                //filtro estado
                if(intval($_POST['CbEstado'])==0){$muestrofila=1;}
                else{$muestrofila=PROV_WhereDes(intval($_POST['CbEstado']),$t3);}
                //muestro
                if($muestrofila==1){
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,GLO_textoPHPExcel($row['Apellido']));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,GLO_FormatoFecha($row['Fecha']));
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$t1);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$t2);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,$t3);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,GLO_textoPHPExcel(PROV_EPlabel($t3)));
					//
					$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':E'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':E'.$fila)->getFill()->getStartColor()->setARGB($color1);
					//
					$fila++;
				}
			}
			$fila--;
			//estilo 
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
			$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($style_boldtrue);//titulos
			$objPHPExcel->getActiveSheet()->getStyle('E1:E'.$fila)->applyFromArray($style_boldtrue);
			$objPHPExcel->getActiveSheet()->getStyle('F1:F'.$fila)->applyFromArray($style_boldtrue);
			$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$fila)->applyFromArray($style_border);	
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(30);			
			//
			include("../Codigo/ExcelHeader.php");	
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');						
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
}


?>