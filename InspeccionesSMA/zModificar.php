<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbCentro']) or empty($_POST['CbYac']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}	
		$centro=intval($_POST['CbCentro']); 
		$yac=intval($_POST['CbYac']); 
		$p1=intval($_POST['CbP1']); 
		$p2=intval($_POST['CbP2']); 
		$p3=intval($_POST['CbP3']); 
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$id=intval($_POST['TxtNumero']);
		for ($i=1; $i < 9; $i= $i +1) {$opt='CbU'.$i;${'idu'.$i}=intval($_POST[$opt]);}
		for ($i=1; $i < 9; $i= $i +1) {$opt='CbEU'.$i;${'ideu'.$i}=intval($_POST[$opt]);}
		for ($i=1; $i < 13; $i= $i +1) {$opt='ChkI'.$i;${'insp'.$i}=intval($_POST[$opt]);}
		//$wq
		$wq='';
		for ($i=1; $i < 9; $i= $i +1) {$wq=$wq.",IdU".$i."=".${'idu'.$i};}
		for ($i=1; $i < 9; $i= $i +1) {$wq=$wq.",IdEU".$i."=".${'ideu'.$i};}
		for ($i=1; $i < 13; $i= $i +1) {$wq=$wq.",I".$i."=".${'insp'.$i};}
		
		$query="UPDATE inspecciones set Fecha='$fechaa',Hora='$hora',IdCentro=$centro,IdYac=$yac,IdP1=$p1,IdP2=$p2,IdP3=$p3,Obs='$obs'".$wq." Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}



elseif (isset($_POST['CmdAddD'])){
	header("Location:AltaD.php?Id=".intval($_POST['TxtNumero']));//pasa el nro de insp
}

elseif (isset($_POST['CmdBorrarFilaD'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From inspecciones_det Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


//archivos adjuntos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoAdjunto.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From inspeccionesarchivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From inspeccionesarchivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;} 
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("inspeccionesarchivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}




//foto form
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("inspecciones",intval($_POST['TxtNumero']),"Fotos/","Foto");
}
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="UPDATE inspecciones set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}








elseif (isset($_POST['CmdExcel'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="SELECT i.*,e.Nombre as Centro,y.Nombre as Yac,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3,u1.Nombre as Uni1,u2.Nombre as Uni2,u3.Nombre as Uni3,u4.Nombre as Uni4,u5.Nombre as Uni5,u6.Nombre as Uni6,u7.Nombre as Uni7,u8.Nombre as Uni8 From inspecciones i,epparticulos e,yacimientos y,personal p1,personal p2,personal p3,unidades u1,unidades u2,unidades u3,unidades u4,unidades u5,unidades u6,unidades u7,unidades u8 where i.Id<>0 and i.IdCentro=e.Id and i.IdYac=y.Id and i.IdP1=p1.Id and i.IdP2=p2.Id and i.IdP3=p3.Id and i.IdU1=u1.Id and i.IdU2=u2.Id  and i.IdU3=u3.Id  and i.IdU4=u4.Id  and i.IdU5=u5.Id  and i.IdU6=u6.Id  and i.IdU7=u7.Id  and i.IdU8=u8.Id  and i.Id=$id";
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$fecha = FormatoFecha($row['Fecha']);if ($fecha=='00-00-0000'){$fecha="";}
		$hora=date("H:i",strtotime($row['Hora'])); if ($hora=='00:00'){$hora="";}
		$yac=GLO_textoPHPExcel( $row['Yac']);
		$centro=GLO_textoPHPExcel( $row['Centro']);
		$obs=GLO_textoPHPExcel( $row['Obs']);
		$p1=GLO_textoPHPExcel( $row['A1'].' '.$row['N1']);
		$p2=GLO_textoPHPExcel( $row['A2'].' '.$row['N2']);
		$p3=GLO_textoPHPExcel( $row['A3'].' '.$row['N3']);
		for ($i=1; $i < 9; $i= $i +1) {$opt='Uni'.$i;${'uni'.$i}=$row[$opt];}
		for ($i=1; $i < 9; $i= $i +1) {$opt='IdEU'.$i;${'ideu'.$i}=$row[$opt];}
		for ($i=1; $i < 13; $i= $i +1) {$opt='I'.$i;if($row[$opt]==0){${'insp'.$i}='';}else{${'insp'.$i}='X';}}
	}mysql_free_result($rs);mysql_close($conn); 
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro18_Inspecciones.xls");
	//completo plantilla
	$objPHPExcel->getActiveSheet()->setCellValue('C4', $fecha);
	$objPHPExcel->getActiveSheet()->setCellValue('C5', $yac);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', $centro);
	$objPHPExcel->getActiveSheet()->setCellValue('C7', $hora);
	$objPHPExcel->getActiveSheet()->setCellValue('G5', $p1);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', $p2);
	$objPHPExcel->getActiveSheet()->setCellValue('G7', $p3);
	$objPHPExcel->getActiveSheet()->setCellValue('O5', $cmd1);
	$objPHPExcel->getActiveSheet()->setCellValue('O6', $cmd2);
	$objPHPExcel->getActiveSheet()->setCellValue('O7', $cmd3);
	$objPHPExcel->getActiveSheet()->setCellValue('B26', $obs);	
	//equipos	
	for ($i=1; $i < 9; $i= $i +1) {
		$fila=9+$i;$col=${'ideu'.$i};
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$fila,${'uni'.$i});
		if($col>0){$col=$col+10;$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,'X');}		
	}
	//inspecciones
	$objPHPExcel->getActiveSheet()->setCellValue('E20', $insp1);	
	$objPHPExcel->getActiveSheet()->setCellValue('K20', $insp2);
	$objPHPExcel->getActiveSheet()->setCellValue('Q20', $insp3);
	$objPHPExcel->getActiveSheet()->setCellValue('E21', $insp4);	
	$objPHPExcel->getActiveSheet()->setCellValue('K21', $insp5);
	$objPHPExcel->getActiveSheet()->setCellValue('Q21', $insp6);
	$objPHPExcel->getActiveSheet()->setCellValue('E22', $insp7);	
	$objPHPExcel->getActiveSheet()->setCellValue('K22', $insp7);
	$objPHPExcel->getActiveSheet()->setCellValue('Q22', $insp9);
	$objPHPExcel->getActiveSheet()->setCellValue('E23', $insp10);	
	$objPHPExcel->getActiveSheet()->setCellValue('K23', $insp11);
	$objPHPExcel->getActiveSheet()->setCellValue('Q23', $insp12);
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdExcel2'])){//detalle
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro19_Inspecciones.xls");
	//consulta
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$fila=10;	
	$query="SELECT d.*, e.Nombre as Estado,p.Nombre,p.Apellido,ce.Nombre as Centro,y.Nombre as Yac,i.fecha as FechaI  From inspecciones_det d,inspecciones_det_est e,personal p,inspecciones i,epparticulos ce,yacimientos y where d.IdInsp=i.Id and d.IdEstado=e.id and d.Id<>0 and p.Id=d.IdPersonal and i.IdCentro=ce.Id and i.IdYac=y.Id and i.Id=$id Order by d.Fecha, p.Apellido,p.Nombre";$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){ 
		//datos encabezado
		$fechai = FormatoFecha($row['FechaI']);if ($fechai=='00-00-0000'){$fechai="";}
		$yac=GLO_textoPHPExcel( $row['Yac']);
		$centro=GLO_textoPHPExcel( $row['Centro']);
		//datos fila
		$fecha = FormatoFecha($row['Fecha']);if ($fecha=='00-00-0000'){$fecha="";}
		$fecha2 = FormatoFecha($row['Fecha2']);if ($fecha2=='00-00-0000'){$fecha2="";}
		$obs=GLO_textoPHPExcel( $row['Obs']);
		$p1=GLO_textoPHPExcel( $row['Apellido'].' '.$row['Nombre']);
		$est=GLO_textoPHPExcel( $row['Estado']);
		//exporto
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$fila,$fecha);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$fila,$obs);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$p1);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$est);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$fecha2);
		$fila=$fila+1;
	}mysql_free_result($rs);mysql_close($conn); 
	//encabezado
	$objPHPExcel->getActiveSheet()->setCellValue('C5', $fechai);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', $centro);
	$objPHPExcel->getActiveSheet()->setCellValue('C7', $yac);
	
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


?>


