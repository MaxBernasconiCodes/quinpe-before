<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//combos
	$f1d=$_POST['TxtFechaV1D'];if($f1d!=""){$wf1d="and DATEDIFF(e.Vto,'".FechaMySql($f1d)."')>=0";}else{$wf1d='';}
	$f1h=$_POST['TxtFechaV1H'];if($f1h!=""){$wf1h="and DATEDIFF(e.Vto,'".FechaMySql($f1h)."')<=0";}else{$wf1h='';}
	$f2d=$_POST['TxtFechaV2D'];if($f2d!=""){$wf2d="and DATEDIFF(e.VtoPH,'".FechaMySql($f2d)."')>=0";}else{$wf2d='';}
	$f2h=$_POST['TxtFechaV2H'];if($f2h!=""){$wf2h="and DATEDIFF(e.VtoPH,'".FechaMySql($f2h)."')<=0";}else{$wf2h='';}
	$uni=intval($_POST['CbUnidad']);if($uni!=0){$wuni="and e.IdUnidad=$uni";}else{$wuni='';}
	$nro=intval($_POST['TxtNro']);if($nro!=0){$wnro="and e.Nro=$nro";}else{$wnro='';}
	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and e.Baja=0";}else{$wactivo='';}

	$_SESSION['TxtQEXTSMA']="SELECT e.*,u.Nombre as Unidad,u.Dominio,ep.Nombre as Prod,ub.Nombre as Ubi From extintores e,unidades u,extintoresprod ep,extintoresubi ub where e.Id<>0 and e.IdUnidad=u.Id and e.IdProd=ep.Id and e.Ubicacion=ub.Id  $wnro $wuni $wf1d $wf1h $wf2d $wf2h $wactivo Order by e.Baja,e.Nro";
	header("Location:../ExtintoresSMA.php");
}




if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From extintores Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ExtintoresSMA.php"); 	
}

if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQEXTSMA'];$query=str_replace("\\", "", $query);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro17_Extintores.xls");
	$fila=5;
	while($row=mysql_fetch_array($rs)){ 
		$f1 = FormatoFecha($row['Vto']);if ($f1=='00-00-0000'){$f1="";}
		$f2= FormatoFecha($row['VtoPH']);if ($f2=='00-00-0000'){$f2="";}
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['Id']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['Nro']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, GLO_textoPHPExcel( $row['Unidad'].' '.$row['Dominio']));
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, GLO_textoPHPExcel( $row['Ubi']));
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, GLO_textoPHPExcel( $row['Prod']));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['Capacidad']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['Chapa']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['Manguera']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['Collarin']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['Precinto']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['Exterior']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $f1);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $f2);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, GLO_textoPHPExcel( $row['Obs']));
		$fila=$fila+1;		
	}mysql_free_result($rs);mysql_close($conn); 
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:../ExtintoresSMA.php");

}

?>