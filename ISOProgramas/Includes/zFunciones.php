<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



function PL_TipoEntidadM($idtipoe,&$wquery,&$worder,&$wcampo){
	$wquery='';$worder="Order by c.Nombre";
	switch ($idtipoe) {
	case 1:	$wquery="c.Nombre as Entidad From clientes c";$wcampo='IdCliente';break;
	case 2:	$wquery="c.Nombre as Entidad From unidades c";$wcampo='IdUnidad';break;
	case 4:	$wquery="CONCAT(c.Apellido,' ',c.Nombre) as Entidad From personal c";$worder="Order by c.Apellido,c.Nombre";$wcampo='IdPersonal';break;
	case 5:	$wquery="c.Nombre as Entidad From servicios c";$wcampo='IdServicio';break;
	}
}


function PL_TipoEntidad($idtipoe,&$wquery,&$campo){
	$wquery='';$campo='Entidad';
	switch ($idtipoe) {
	case 1:	$wquery=",c.Nombre as Entidad From programas_t m,clientes c where m.IdCliente=c.Id and";break;//clientes
	case 2:	$wquery=",c.Nombre as Entidad From programas_t m,unidades c where m.IdUnidad=c.Id and";break;//unidades
	case 4:	$wquery=",CONCAT(c.Apellido,' ',c.Nombre) as Entidad From programas_t m,personal c where m.IdPersonal=c.Id and";break;//personal
	case 5:	$wquery=",c.Nombre as Entidad From programas_t m,servicios c where m.IdServicio=c.Id and";break;//servicio
	case 6:	$wquery="From programas_t m where ";$campo='Otro';break;//otro
	}
}

//Los cumplimientos se consideran para los meses finalizados
//Mensualmente rojo pendiente, amarillo es reprogramado, verde cumplido
function PLA_totalcumplmes(&$sumafilap,&$sumafilar,$prog,$real,$mescol,$v1,$aniop){//cumplimiento total ($v1 llamado desde excel)
	$hoy=date("d-m-Y"); list($diah,$mesh,$anioh)=explode("-",$hoy);	
	//mes actual cerrado o menor
	if( ($aniop<$anioh) or ($aniop==$anioh and $mescol<$mesh) ) {
		$sumafilap=$sumafilap+$prog;$sumafilar=$sumafilar+$real;
	}
}
function PLA_colorcumplmes(&$colorcumpl,$prog,$real,$mescol,$v1,$aniop){
	$hoy=date("d-m-Y"); list($diah,$mesh,$anioh)=explode("-",$hoy);
	$colorcumpl='';
	//mes actual cerrado o menor
	if( ($aniop<$anioh) or ($aniop==$anioh and $mescol<$mesh) ) {
		if($prog!=0 and $real>=$prog){$colorcumpl='background-color:#4CAF50;color: #FFFFFF;';}//verde
		if($prog!=0 and $real<$prog){$colorcumpl='background-color:#f44336;color: #FFFFFF;';}//rojo
		if($prog!=0 and $real==0){$colorcumpl='background-color:#ffcc00;color: #FFFFFF;';}//amarillo reprogramado
		if($prog==0 and $real>0){$colorcumpl='background-color:#4CAF50;color: #FFFFFF;';}//verde viene de amarillo
	}
}
function PLA_colorcumplmesxls(&$colorcumpl,$prog,$real,$mescol,$v1,$aniop){
	$hoy=date("d-m-Y"); list($diah,$mesh,$anioh)=explode("-",$hoy);
	$colorcumpl='FFFFFFFF';
	//mes actual cerrado o menor
	if( ($aniop<$anioh) or ($aniop==$anioh and $mescol<$mesh) ) {
		if($prog!=0 and $real>=$prog){$colorcumpl='FF99CC00';}//verde
		if($prog!=0 and $real<$prog){$colorcumpl='FFFF0000';}//rojo
		if($prog!=0 and $real==0){$colorcumpl='FFFFFF66';}//amarillo reprogramado
		if($prog==0 and $real>0){$colorcumpl='FF99CC00';}//verde viene de amarillo
	}
}


//Anualmente rojo es 0 a 65%, amarillo 65% a 99%, verde >= 100% de cumplimiento
function PLA_totalcumplfila(&$colorcumpl,&$cumplfila,$sumafilap,$sumafilar,$v1){
	$colorcumpl='';
	if($sumafilap!=0){	
		$cumplfila=($sumafilar/$sumafilap)*100;
		if($cumplfila<65){$colorcumpl='TFRed';}
		if($cumplfila>=65 and $cumplfila<100){$colorcumpl='TFYellow';}
		if($cumplfila>=100){$colorcumpl='TFGreen';}
	}
}
function PLA_totalcumplfilaxls(&$colorcumpl,&$cumplfila,$sumafilap,$sumafilar,$v1){
	$colorcumpl='FFFFFFFF';
	if($sumafilap!=0){	
		$cumplfila=($sumafilar/$sumafilap);
		if(($cumplfila*100)<65){$colorcumpl='FFFF0000';}//rojo
		if(($cumplfila*100)>=65 and $cumplfila<100){$colorcumpl='FFFFFF66';}//amarillo
		if(($cumplfila*100)>=100){$colorcumpl='FF99CC00';}//verde
	}
}




/* 20/11/2020
function PLA_totalcumplfila(&$colorcumpl,&$cumplfila,$sumafilap,$sumafilar,$v1){
	$colorcumpl='';
	if($sumafilap!=0){	
		$cumplfila=($sumafilar/$sumafilap)*100;
		if($sumafilar>=$sumafilap){$colorcumpl='TFGreen';}if($sumafilar<$sumafilap){ $colorcumpl='TFRed'; }
	}
}
function PLA_totalcumplfilaxls(&$colorcumpl,&$cumplfila,$sumafilap,$sumafilar,$v1){
	$colorcumpl='FFFFFFFF';
	if($sumafilap!=0){	
		$cumplfila=($sumafilar/$sumafilap);
		if($sumafilar>=$sumafilap){$colorcumpl='FF99CC00';}	if($sumafilar<$sumafilap){$colorcumpl='FFFF0000';}
	}
}
*/



function PL_TablaTareas($idpadre,$tipo,$idtipoe,$aniop,$conn){
$idpadre=intval($idpadre); 
PL_TipoEntidad($idtipoe,$wquery,$campo);
//query
$query="SELECT m.*".$wquery." m.IdP=$idpadre Order by m.Id";$rs=mysql_query($query,$conn); 
//botones filtro
$totalreg=mysql_num_rows($rs);
$nroreg=0;
if($totalreg>10){
	if(intval($_SESSION['TxtNLMin'])==0){$_SESSION['TxtNLMin']=1;}
	if(intval($_SESSION['TxtNLMax'])==0){$_SESSION['TxtNLMax']=$totalreg;}
	$minreg=$_SESSION['TxtNLMin'];$maxreg=$_SESSION['TxtNLMax'];
	$filtro='<input name="TxtNLMin" type="text"  class="TextBox" maxlength="3"  value="'.$_SESSION['TxtNLMin'].'" onchange="this.value=validarEntero(this.value);" style="text-align:center;width:20px;color: #86868b;"><label class="TGray" style="font-weight:normal;"> - </label><input name="TxtNLMax" type="text"  class="TextBox" maxlength="3"  value="'.$_SESSION['TxtNLMax'].'" onchange="this.value=validarEntero(this.value);" style="text-align:center;width:20px;color: #86868b;">&nbsp; de <label class="TGray" style="font-weight:normal;"> '.$totalreg.' </label> &nbsp;<button name="CmdRango" type="submit" class="iconbtn" > <i class="fa fa-search iconvsmallbt TGray"></i></button>';	
}else{$filtro='<label class="TGray" style="font-weight:normal;"> '.$totalreg.' registros </label>';}
//Titulos de la tabla
$tablaclientes='<table  width="1270" border="0" cellspacing="0" cellpadding="0" ><tr><td style="color: #86868b;">R: Referencia, P: Programado, E: Ejecutado</td><td style="text-align:right;color: #86868b;">'.$filtro.'</td></tr></table>';
$tablaclientes .=GLO_inittabla(1270,1,0,0);
$tablaclientes .='<td width="80" class="TableShowT" rowspan="2"> </td>';
$tablaclientes .='<td width="80" class="TableShowT" rowspan="2" style="font-weight:normal;">'.substr($_SESSION['TxtNombre1'],0,10).'</td>';
$tablaclientes .='<td width="80" class="TableShowT" rowspan="2" style="font-weight:normal;">'.substr($_SESSION['TxtNombre2'],0,10).'</td>';
for ($i=1; $i < 13; $i= $i +1) {
	$tablaclientes .='<td width="75" class="TableShowT TAC bordeleftdark" colspan="3" style="font-size:9px">'.G_NombreMes($i)."</td>";  
}
$tablaclientes .='<td width="80" class="TableShowT TAC bordeleftdark" colspan="3"> Cumplimiento</td>';
$tablaclientes .='<td width="50" class="TableShowT TAR"></td>';
$tablaclientes .='</tr>'; 
//subtitulo 
$tablaclientes .='<tr>';
for ($i=1; $i < 13; $i= $i +1) {
	$tablaclientes .='<td width="25" class="TableShowT TAC bordetopnone bordeleftdark">'.'R'."</td>";//referencia 
	$tablaclientes .='<td width="25" class="TableShowT TAC bordetopnone ">'.'P'."</td>";  //programado
	$tablaclientes .='<td width="25" class="TableShowT TAC bordetopnone">'.'E'."</td>"; //ejecutado
}
$tablaclientes .='<td width="20" class="TableShowT TAC bordetopnone  bordeleftdark">'.'P'."</td>"; //programado
$tablaclientes .='<td width="20" class="TableShowT TAC bordetopnone">'.'E'."</td>";//ejecutado 
$tablaclientes .='<td width="40" class="TableShowT TAC bordetopnone">'.'C (%)'."</td>"; 
$tablaclientes .='<td width="50" class="TableShowT TAR bordetopnone">';
if($idtipoe==6){//otros (individual)
	$tablaclientes .='<button name="CmdAddT" type="button" class="iconbtn" title="Agregar" value=" " onClick="window.location.href='."'AltaTarea.php?Id=".$idpadre."';".'"><i class="fas fa-folder-plus iconsmallbt iconlgray"></i></button>';
}else{//entidades (masiva)
	$tablaclientes .='<button name="CmdAddT" type="button" class="iconbtn" title="Agregar" value=" " onClick="window.location.href='."'AltaTareaM.php?Id=".$idpadre."';".'"><i class="fas fa-folder-plus iconsmallbt iconlgray"></i></button>';
}
$tablaclientes .='</td></tr>'; 
//total columna
for ($i=1; $i < 13; $i= $i +1){${'tcolp'.$i}=0;${'tcolr'.$i}=0;}
//filas
while($row=mysql_fetch_array($rs)){
	$sumafilap=0;$sumafilar=0;$cumplfila=0;
	//valido rango
	$nroreg++;
	if ( ($totalreg>10 and $nroreg>=$minreg and $nroreg<=$maxreg) or $totalreg<=10){
		//muestro
		$tablaclientes .='<tr '.GLO_highlight($row['Id']).'>'; 
		$tablaclientes .='<td  class="TableShowD" >'.substr($row[$campo],0,10)."</td>"; 
		$tablaclientes .='<td  class="TableShowD" >'.substr($row['Obs2'],0,10)."</td>"; 
		$tablaclientes .='<td  class="TableShowD" >'.substr($row['Obs3'],0,10)."</td>"; 
		for ($i=1; $i < 13; $i= $i +1) {
			//campos
			$nomsp='TxtM'.$i.'P';$nomsr='TxtM'.$i.'R';$nomsq='TxtM'.$i.'Q';//nombre txt
			$nomrp='M'.$i.'P';$nomrr='M'.$i.'R';$nomrq='M'.$i.'Q';//nombre campo
			//referencia
			$tablaclientes .='<td width="25" class="TableShowD TAC bordeleftdark">'.'<input name="'.$nomsq.'['.$row['Id'].']" maxlength="1" type="text"  class="TextBox" style="width:15px;text-align:center;color: #727272;" onKeyUp="this.value=this.value.toUpperCase()" value="'.$row[$nomrq].'"></td>';  
			//programado
			if($row[$nomrp]>0){$colorcumplp='background-color:#e0e0ff;';}else{$colorcumplp='';}
			$tablaclientes .='<td width="25" class="TableShowD TAC bordeleftnone">'.'<input name="'.$nomsp.'['.$row['Id'].']" maxlength="2" type="text"  class="TextBox" style="width:18px;text-align:center;'.$colorcumplp.'" onChange="this.value=validarEntero(this.value);"  value="';
			if($row[$nomrp]!=0){$tablaclientes .=$row[$nomrp].'">'."</td>";}else{$tablaclientes .='">'."</td>";}
			//cumplimiento
			PLA_colorcumplmes($colorcumpl,$row['M'.$i.'P'],$row['M'.$i.'R'],$i,0,$aniop);
			//real
			$tablaclientes .='<td width="25" class="TableShowD TAC bordeleftnone">'.'<input name="'.$nomsr.'['.$row['Id'].']" maxlength="2" type="text"  class="TextBox" style="width:18px;text-align:center;'.$colorcumpl.'" onChange="this.value=validarEntero(this.value);" value="';  
			if($row[$nomrr]!=0){$tablaclientes .=$row[$nomrr].'">'."</td>";}else{$tablaclientes .='">'."</td>";}
			//totales fila
			PLA_totalcumplmes($sumafilap,$sumafilar,$row['M'.$i.'P'],$row['M'.$i.'R'],$i,0,$aniop);
			//totales columna
			${'tcolp'.$i}=${'tcolp'.$i}+$row['M'.$i.'P'];${'tcolr'.$i}=${'tcolr'.$i}+$row['M'.$i.'R'];
		}
		//cumplimiento
		PLA_totalcumplfila($colorcumpl,$cumplfila,$sumafilap,$sumafilar,0);
		//
		$tablaclientes .='<td width="30" class="TableShowD TAC bordeleftdark">'.$sumafilap."</td>"; 
		$tablaclientes .='<td width="30" class="TableShowD TAC">'.$sumafilar."</td>"; 
		$tablaclientes .='<td width="30" class="TableShowD TAC TBold '.$colorcumpl.'">'.number_format($cumplfila,1)."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">'; 
		$tablaclientes .='<button name="CmdModificarFilaT" type="button" class="iconbtn" onClick="window.location.href='."'ModificarTarea.php?id=".$row['Id']."&Flag1=True';".'"  '.GLO_mouseoverbutton($row['Id'],0).'>'.GLO_IconSearch().'</button>';				
		$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
		$tablaclientes .='</td></tr>'; 
	}
}
//totales programa
$sumafilap=0;$sumafilar=0;$cumplfila=0;
$tablaclientes .='<tr><td class="TableShowT bordetopnone" colspan="3"> </td>';
for ($i=1; $i < 13; $i= $i +1) {
	$tablaclientes .='<td class="TableShowT TAC bordetopnone bordeleftdark">'."</td>"; 
	$tablaclientes .='<td class="TableShowT TAC bordetopnone">'.${'tcolp'.$i}."</td>";  
	$tablaclientes .='<td class="TableShowT TAC bordetopnone">'.${'tcolr'.$i}."</td>";  
	//totales programa
	PLA_totalcumplmes($sumafilap,$sumafilar,${'tcolp'.$i},${'tcolr'.$i},$i,0,$aniop);
}
//cumplimiento
PLA_totalcumplfila($colorcumpl,$cumplfila,$sumafilap,$sumafilar,0);
//
$tablaclientes .='<td class="TableShowT TAC bordetopnone  bordeleftdark">'.$sumafilap."</td>"; 
$tablaclientes .='<td class="TableShowT TAC bordetopnone">'.$sumafilar."</td>"; 
$tablaclientes .='<td class="TableShowT TAC bordetopnone TBold '.$colorcumpl.'">'.number_format($cumplfila,1)."</td>"; 
$tablaclientes .='<td class="TableShowT TAR bordetopnone"></td>'; 
$tablaclientes .='</tr>';
//
$tablaclientes .="</table></td></tr></table>";
echo $tablaclientes;	
mysql_free_result($rs);
}





function PL_ExportarPlan($idpadre,$conn){
	$idpadre=intval($idpadre);	
	//fechas cumplimiento
	$hoy=date("d-m-Y"); list($diah,$mesh,$anioh)=explode("-",$hoy);
	//programa
	$query="SELECT p.*,e.Nombre as Entidad,t.Obs as Ref,s.Nombre as Sector From programas p,programas_ent e,iso_tiporef t,sector s where p.IdTipoE=e.Id and p.IdSector=s.Id and p.Id<>0 and p.IdRef=t.Id and p.Id=$idpadre"; 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$titulo=$row['Nombre'];	$obsp=$row['Obs'];$sec=$row['Sector'];
		$idtipoe=$row['IdTipoE'];$entidad=$row['Entidad'];
		$tdet1=$row['T1'];$tdet2=$row['T2'];$fechap=$row['Fecha'];
		$aniop=$row['Fecha'];//anio programa
		$obsref=$row['Ref'];
	}mysql_free_result($rs);	
	//exporto
	require_once $_SESSION["NivelArbol"].'PHPExcel/Classes/PHPExcel.php';
	require_once $_SESSION["NivelArbol"].'Codigo/PHPExcelFunciones.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load($_SESSION["NivelArbol"]."Archivos/Plantillas/Libro34_Programas.xls");
	//hoja 2
	$fhoja2=2;
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->setCellValue('A1',GLO_textoPHPExcel($entidad));		
	//hoja 1
	$f=2;
	$objPHPExcel->setActiveSheetIndex(0);	
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$f,GLO_textoPHPExcel($titulo));$f=$f+4;
	//encabezado
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$f,'FECHA: '.$fechap);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$f,GLO_textoPHPExcel($sec));
	$objPHPExcel->getActiveSheet()->setCellValue('AD'.$f,GLO_textoPHPExcel($obsp));$f=$f+3;
	//tabla	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$f,GLO_textoPHPExcel($entidad));
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$f,GLO_textoPHPExcel($tdet1));
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$f,GLO_textoPHPExcel($tdet2));	$f=$f+2;
	//exporto tareas
	PL_TipoEntidad($idtipoe,$wquery,$campo);
	$query="SELECT m.*".$wquery." m.IdP=$idpadre Order by m.Id";$rs=mysql_query($query,$conn); 
	while($row=mysql_fetch_array($rs)){
		//total fila cumplimiento
		$sumafilap=0;$sumafilar=0;$cumplfila=0;
		//datos
		$nomentidad=GLO_textoPHPExcel( $row[$campo]);
		$detalle=GLO_textoPHPExcel($row['Obs2']).' ';$detalle2=GLO_textoPHPExcel($row['Obs3']).' ';
		$obstarea=GLO_textoPHPExcel($row['Obs']);
		//hoja 2
		$objPHPExcel->setActiveSheetIndex(1);
		if($obstarea!=''){
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($fhoja2+1, 1);//insertar fila
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$fhoja2,$nomentidad);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fhoja2,$obstarea);
			$fhoja2++;		
		}		
		//hoja 1
		$objPHPExcel->setActiveSheetIndex(0);
		//exporto filas texto
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($f+1, 1);//insertar fila
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$f,$nomentidad);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$f,$detalle);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$f,$detalle2);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$f,' ');
		//exporto filas programado/real
		$col=5;
		for ($i=1; $i < 13; $i= $i +1) {
			$nomrp='M'.$i.'P';$nomrr='M'.$i.'R';$nomrq='M'.$i.'Q';
			//referencia
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$f,GLO_textoPHPExcel($row[$nomrq]));
			$col++;			
			//programado 
			if($row[$nomrp]!=0){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$f,$row[$nomrp]);
				//si hay programado marco gris
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$f)->getFill()->getStartColor()->setARGB('FFE0E0FF');
			}
			//sumo si es mes actual o menor
			if( ($aniop<$anioh) or ($aniop==$anioh and $i<$mesh) ) {$formulacumplp=$formulacumplp.'+'.PHPExcel_letracol($col).$f;}
			$col++;
			//real //sumo si es mes actual o menor
			if($row[$nomrr]!=0){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$f,$row[$nomrr]);}			
			//sumo si es mes actual o menor
			if( ($aniop<$anioh) or ($aniop==$anioh and $i<$mesh) ) {$formulacumplr=$formulacumplr.'+'.PHPExcel_letracol($col).$f;}
			//cumplimiento
			PLA_colorcumplmesxls($colorcumpl,$row['M'.$i.'P'],$row['M'.$i.'R'],$i,0,$aniop);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$f)->getFill()->getStartColor()->setARGB($colorcumpl);
			$col++;
			//totales fila
			PLA_totalcumplmes($sumafilap,$sumafilar,$row['M'.$i.'P'],$row['M'.$i.'R'],$i,1,$aniop);
		}
		//cumplimiento
		PLA_totalcumplfilaxls($colorcumpl,$cumplfila,$sumafilap,$sumafilar,0);
	   //subtotales fila	
		$objPHPExcel->getActiveSheet()->setCellValue('AP'.$f,$sumafilap);//programado	
		$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$f,$sumafilar);//real		
		$objPHPExcel->getActiveSheet()->setCellValue('AR'.$f,$cumplfila);//cumplimiento
		//color cumplimiento
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col+2,$f)->getFill()->getStartColor()->setARGB($colorcumpl);
		//sumo fila
		$f++;		
	}mysql_free_result($rs);
	mysql_close($conn);
	//elimino filas sobrantes que use en la plantilla
	if($f>6){$objPHPExcel->getActiveSheet()->removeRow($f,1);}
	//exribo referencias
	$f=$f+3;	
	if($obsref!=''){
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$f,'Referencias');$f++;
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$f,$obsref);
	}
	//completo segunda hoja
	$objPHPExcel->setActiveSheetIndex(1);
	//finalizo
	$objPHPExcel->setActiveSheetIndex(0);	
	include($_SESSION["NivelArbol"]."Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}
?>