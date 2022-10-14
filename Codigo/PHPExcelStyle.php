<? 

//estilo
$style_boldtrue = array('font' => array('bold' => true));
$style_boldfalse = array('font' => array('bold' => false));
$style_border= array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN )));
$style_hleft=array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
$style_hcenter=array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
$style_vcenter = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
$style_gris=array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'EEEEEEEE')));
$style_white=array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFFFFFF')));

/*
FAQ
$objPHPExcel->getActiveSheet()->getStyle('C'.$rowex.':'.'X'.$rowex)->applyFromArray($style_boldtrue);//aplicar estilo
$objPHPExcel->getActiveSheet()->getStyle('B'.'7'.':'.'I'.$rowex)->getAlignment()->setWrapText(false); //ajustar a texto
$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex, 1);//insertar fila
$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowex.':T'.$rowex); //combinar celdas
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');	
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(15);
$objPHPExcel->getActiveSheet()->setShowGridlines(false);
$objPHPExcel->getActiveSheet()->setTitle('Servicio');
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$fila)->getFill()->getStartColor()->setARGB('FFCCFFCC');




*/

?>