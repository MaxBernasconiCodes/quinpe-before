<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarDes.php?gid=".intval($_POST['TxtNumero'])."&gidp=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosEP.php");
		//actualizo
		$query="UPDATE proveedores_des set Fecha='$fechaa',IdP1=$p1,IdP2=$p2,E1=$e1,E2=$e2,E3=$e3,E4=$e4,E5=$e5,E6=$e6,E7=$e7,E8=$e8,E9=$e9,E10=$e10,E11=$e11,E12=$e12,I1='$i1',I2='$i2',I3='$i3',I4='$i4',I5='$i5',I6='$i6',I7='$i7',I8='$i8',I9='$i9',I10='$i10',I11='$i11',I12='$i12' Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarDes.php?gidf=1&gid=".intval($_POST['TxtNumero']));
	}
}





elseif (isset($_POST['CmdSalir']) ){
if(intval($_SESSION['GLO_IdLocationPROVD'])==1){header("Location:ProveedoresD.php");}
else{header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}
}


elseif (isset($_POST['CmdExcel'])){
	require_once '../PHPExcel/Classes/PHPExcel.php';
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro32_EvalProv.xls");
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos proveedor
	$query="SELECT p.*, l.Nombre as Loc,a.Nombre as Act From proveedores p,localidades l,actividades a  where p.Id<>0 and p.IdLocalidad=l.Id and p.IdActividad=a.Id and p.Id=".intval($_POST['TxtNroEntidad']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
		//identificacion
		$objPHPExcel->getActiveSheet()->setCellValue('A4', GLO_textoPHPExcel('Razon social: '.$row['Apellido']));
		$objPHPExcel->getActiveSheet()->setCellValue('A5', GLO_textoPHPExcel('Domicilio: '.$row['Direccion'].' '.$row['Loc']));
		$objPHPExcel->getActiveSheet()->setCellValue('A6', GLO_textoPHPExcel('Pagina web: '.$row['PW']));
		$objPHPExcel->getActiveSheet()->setCellValue('A7', GLO_textoPHPExcel('CUIT: '.$row['Identificacion']));
		$objPHPExcel->getActiveSheet()->setCellValue('A8', GLO_textoPHPExcel('Persona de contacto: '.$row['PC']));
		$objPHPExcel->getActiveSheet()->setCellValue('F4', GLO_textoPHPExcel('Actividad/Rubro: '.$row['Act']));
		//$objPHPExcel->getActiveSheet()->setCellValue('F5', GLO_textoPHPExcel('Tel/Fax: '.$row['xx']));
		$objPHPExcel->getActiveSheet()->setCellValue('F6', GLO_textoPHPExcel('Email: '.$row['EMail']));
		$objPHPExcel->getActiveSheet()->setCellValue('F8', GLO_textoPHPExcel('Cargo: '.$row['PCC']));
	}mysql_free_result($rs);	
	//datos evaluacion
	$query="SELECT p.* From proveedores_des p where p.Id<>0 and p.Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
		$objPHPExcel->getActiveSheet()->setCellValue('F7', GLO_textoPHPExcel('Fecha de evaluacion: ').GLO_FormatoFecha($row['Fecha']));
		//trayectoria eval
		$objPHPExcel->getActiveSheet()->setCellValue('F11', $row['E1']);
		$objPHPExcel->getActiveSheet()->setCellValue('F12', $row['E2']);
		$objPHPExcel->getActiveSheet()->setCellValue('F13', $row['E3']);
		$objPHPExcel->getActiveSheet()->setCellValue('F14', $row['E4']);
		$objPHPExcel->getActiveSheet()->setCellValue('F15', $row['E5']);
		$objPHPExcel->getActiveSheet()->setCellValue('F16', $row['E6']);
		$objPHPExcel->getActiveSheet()->setCellValue('F17', $row['E7']);
		$objPHPExcel->getActiveSheet()->setCellValue('F18', $row['E8']);
		//trayectoria obs
		$objPHPExcel->getActiveSheet()->setCellValue('G11', GLO_textoPHPExcel($row['I1']));
		$objPHPExcel->getActiveSheet()->setCellValue('G12', GLO_textoPHPExcel($row['I2']));
		$objPHPExcel->getActiveSheet()->setCellValue('G13', GLO_textoPHPExcel($row['I3']));
		$objPHPExcel->getActiveSheet()->setCellValue('G14', GLO_textoPHPExcel($row['I4']));
		$objPHPExcel->getActiveSheet()->setCellValue('G15', GLO_textoPHPExcel($row['I5']));
		$objPHPExcel->getActiveSheet()->setCellValue('G16', GLO_textoPHPExcel($row['I6']));
		$objPHPExcel->getActiveSheet()->setCellValue('G17', GLO_textoPHPExcel($row['I7']));
		$objPHPExcel->getActiveSheet()->setCellValue('G18', GLO_textoPHPExcel($row['I8']));
		//gestion eval
		$objPHPExcel->getActiveSheet()->setCellValue('F21', $row['E9']);
		$objPHPExcel->getActiveSheet()->setCellValue('F22', $row['E10']);
		$objPHPExcel->getActiveSheet()->setCellValue('F23', $row['E11']);
		$objPHPExcel->getActiveSheet()->setCellValue('F24', $row['E12']);
		//gestion obs
		$objPHPExcel->getActiveSheet()->setCellValue('G21', GLO_textoPHPExcel($row['I9']));
		$objPHPExcel->getActiveSheet()->setCellValue('G22', GLO_textoPHPExcel($row['I10']));
		$objPHPExcel->getActiveSheet()->setCellValue('G23', GLO_textoPHPExcel($row['I11']));
		$objPHPExcel->getActiveSheet()->setCellValue('G24', GLO_textoPHPExcel($row['I12']));	
		//totales
		include ("Includes/zTotales.php");	
	}mysql_free_result($rs);	
	mysql_close($conn); 
	//colores total	
	$colorexcel=PROV_ColorExcel($t3);
	$objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle($colorexcel), 'F29:F29');
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
		header("Location:ModificarDes.php?gidf=1&gid=".intval($_POST['TxtNumero']));
}


?>


