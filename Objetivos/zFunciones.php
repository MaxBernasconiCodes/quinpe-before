<? include("../Codigo/Seguridad.php"); 

function OBJ_TablaMostrar($tipo,$conn){
	switch ($tipo) {
		case 1:	$tablaobj="obj_vision";$idedit=1;$align='TAC'; break;
		case 2:	$tablaobj="obj_mision";$idedit=2;$align='TAC'; break;
		case 3:	$tablaobj="obj_valores";$idedit=3;$align=''; break;
		case 4:	$tablaobj="obj_objetivos";$idedit=4;$align=''; break;
		case 5:	$tablaobj="obj_estrategia";$idedit=5;$align=''; break;
	}
	//solo modifica admin
	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2){
		$editar='<button type="button" onClick="window.location.href='."'"."Consulta.php?ido=".$idedit."'".';" class="iconbtn"  title="Modificar"><i class="fas fa-edit iconsmallbt iconlgray"></i></button>';
	}else{$editar='';}
	//
	$query="Select * From $tablaobj Order by Anio DESC LIMIT 1";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){	
		//titulo
		echo '<table width="700" border="0"   cellspacing="0" class="TablaFondo tablanotif">
		<tr> <td align="center" class="titulonotif" colspan="3">'.$row['Titulo'].'</td>
		<td align="right">'.$editar.'&nbsp;</td></tr>
		<tr> <td height="3" width="20"></td><td class="bordenotif" width="660"></td><td width="20"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		//			
		echo '<tr><td></td><td class="entrynotif '.$align.'" style="font-size:1.2rem;">'.str_replace("\n", "<br/>", $row['Nombre']).'</td><td></td></tr>';
		echo '<tr><td></td><td class="entrynotif TGray'.'" align="right">'.GLO_FormatoFecha($row['Fecha']).'</td><td></td></tr>';
		//cierra
		echo '</table>';
	}mysql_free_result($rs);
}


function OBJ_titulo($id){
	$res='';
	switch (intval($id)) {
		case 1:	$res="VISION"; break;
		case 2:	$res="MISION";break;
		case 3:	$res="VALORES";break;
		case 4:	$res="OBJETIVOS"; break;
		case 5:	$res="ESTRATEGIA"; break;
	}
	return $res;
}

function OBJ_tabla($id){
	$res='obj_vision';//por seguridad asigno una tabla para que no quede vacio
	switch (intval($id)) {
		case 1:	$res="obj_vision"; break;
		case 2:	$res="obj_mision";break;
		case 3:	$res="obj_valores";break;
		case 4:	$res="obj_objetivos"; break;
		case 5:	$res="obj_estrategia"; break;
	}
	return $res;
}


function OBJ_volver($id){
	$res='';
	switch (intval($id)) {
		case 1:	$res=1; break;
		case 2:	$res=1;break;
		case 3:	$res=2;break;
		case 4:	$res=3; break;
		case 5:	$res=4; break;
	}
	return $res;
}

?>


