<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtAnio']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		$anio=intval($_POST['TxtAnio']); 
		$id=intval($_POST['TxtNumero']);	
		//pssa	
		$query="UPDATE pssa set Year=$anio, FechaA='$fechaa' Where Id=$id";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		//pssa items
		$aListaid=array_keys($_POST['TxtObs']);//id
		$aListace=($_POST['TxtCE']);//valor
		$aListaobj=($_POST['TxtObj']);$aListameta=($_POST['TxtMeta']);
		$aListaobs=($_POST['TxtObs']);
		$aListae1=($_POST['CbE1']);$aListae2=($_POST['CbE2']);$aListae3=($_POST['CbE3']);$aListae4=($_POST['CbE4']);$aListae5=($_POST['CbE5']);
		$aListae6=($_POST['CbE6']);$aListae7=($_POST['CbE7']);$aListae8=($_POST['CbE8']);$aListae9=($_POST['CbE9']);$aListae10=($_POST['CbE10']);
		$aListae11=($_POST['CbE11']);$aListae12=($_POST['CbE12']);
		foreach($aListaid as $iId) {
			$ce=mysql_real_escape_string($aListace[$iId]);
			$obj=intval($aListaobj[$iId]);$meta=intval($aListameta[$iId]);
			$obs=mysql_real_escape_string($aListaobs[$iId]);
			$e1=intval($aListae1[$iId]);$e2=intval($aListae2[$iId]);$e3=intval($aListae3[$iId]);$e4=intval($aListae4[$iId]);
			$e5=intval($aListae5[$iId]);$e6=intval($aListae6[$iId]);$e7=intval($aListae7[$iId]);$e8=intval($aListae8[$iId]);
			$e9=intval($aListae9[$iId]);$e10=intval($aListae10[$iId]);$e11=intval($aListae11[$iId]);$e12=intval($aListae12[$iId]);
			//update 
			$query="Update pssa_items Set CE='$ce',Mes1=$e1,Mes2=$e2,Mes3=$e3,Mes4=$e4,Mes5=$e5,Mes6=$e6,Mes7=$e7,Mes8=$e8,Mes9=$e9,Mes10=$e10,Mes11=$e11,Mes12=$e12,Obs='$obs',Obj=$obj,Meta=$meta Where Id=$iId";
			$rs=mysql_query($query,$conn);
		}
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}


//detalle
elseif (isset($_POST['CmdAddD'])){
	header("Location:AltaD.php?Id=".intval($_POST['TxtNumero']));//pasa el nro de insp
}
elseif (isset($_POST['CmdBorrarFilaD'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From pssa_items Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From pssa_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From pssa_archivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("pssa_archivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}


elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSSA.php");
}



elseif (isset($_POST['CmdExcel'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	//pssa
	$query="SELECT p.* From pssa p  where p.Id<>0 and p.Id=$id"; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$anio=$row['Year'];
		$fecha = FormatoFecha($row['FechaA']);if ($fecha=='00-00-0000'){$fecha="";}	
	}mysql_free_result($rs);	
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro20_PSSA.xls");
	$objPHPExcel->getActiveSheet()->setCellValue('H4',GLO_textoPHPExcel('PERIODO '.$anio));
	$fila=6;
	//items
	$query="SELECT ps.*,a.Nombre as Act,t.Nombre as Tipo,f.Nombre as Frec,r.Nombre as Resp From pssa_items ps ,pssa_act a,pssa_tipo t,pssa_frec f,pssa_resp r Where ps.IdPSSA=$id and ps.IdAct=a.Id and ps.IdTipo=t.Id and ps.IdFrec=f.Id and ps.IdResp=r.Id  Order by t.Nombre,f.Nombre,a.Nombre";
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$tipo=GLO_textoPHPExcel( $row['Tipo']);
		$act=GLO_textoPHPExcel( $row['Act']);
		$frec=GLO_textoPHPExcel( $row['Frec']);
		$resp=GLO_textoPHPExcel( $row['Resp']);
		$obs=GLO_textoPHPExcel( $row['Obs']);
		//exporto
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila+1, 1);//insertar fila
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,$tipo);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$act);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,$frec);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$resp);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$fila,$obs);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$fila,' ');
		//cumplimiento
		$col=7;
		for ($i=1; $i < 13; $i= $i +1) {
			//estado mes	(0,1prog,2cumpl,3atrasado)
			${'textoe'.$i}=' ';${'colore'.$i}='FFFFFFFF';
			if($row['Mes'.$i]==1){${'colore'.$i}='800080';${'textoe'.$i}='P';$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$fila)->getFill()->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);}//violeta
			if($row['Mes'.$i]==2){${'colore'.$i}='008000';${'textoe'.$i}='C';$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$fila)->getFill()->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);}//verde
			if($row['Mes'.$i]==3){${'colore'.$i}='FF0000';${'textoe'.$i}='A';$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$fila)->getFill()->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);}//rojo
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$fila,${'textoe'.$i});
			

			$col=$col+1;	
		}
		//sumo fila
		$fila=$fila+1;
		
	}mysql_free_result($rs);
	mysql_close($conn);
	//actualizado
	$fila=$fila+1;
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,'Actualizado: '.$fecha);
	 


	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


?>


