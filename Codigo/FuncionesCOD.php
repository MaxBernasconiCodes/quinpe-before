<?php include("Seguridad.php") ;

//mensaje
function GLO_feedback($tipo){
	switch ($tipo) {
	case 1:  $_SESSION['GLO_msgC']="Los cambios se grabaron correctamente";break;
	case 2:  $_SESSION['GLO_msgE']="Los cambios no se grabaron";break;
	case 3:  $_SESSION['GLO_msgE']="Por favor complete los campos requeridos";break;
	case 4:  $_SESSION['GLO_msgE']="Por favor revise el CUIT";break;
	case 5:  $_SESSION['GLO_msgE']="La clave actual no es correcta";break;
	case 6:  $_SESSION['GLO_msgE']="La clave y su confirmacion no coinciden";break;
	case 7:  $_SESSION['GLO_msgE']="La clave debe tener 8 caracteres";break;
	case 8:  $_SESSION['GLO_msgE']="La clave debe tener al menos un caracter numerico";break;
	case 9:  $_SESSION['GLO_msgE']="La clave debe tener al menos una letra";break;
	case 10: $_SESSION['GLO_msgE']="Por favor verifique las fechas";break;
	case 11: $_SESSION['GLO_msgE']="Por favor verifique la disponibilidad para el periodo";break;
	case 12: $_SESSION['GLO_msgE']="Por favor elimine primero los items asociados";break;
	case 13: $_SESSION['GLO_msgE']="El Codigo ya existe";break;
	case 14: $_SESSION['GLO_msgE']="Ya existe el documento. Las nuevas versiones deben generarse desde el documento";break;
	case 15: $_SESSION['GLO_msgC']="El mail fue enviado correctamente";break;
	case 16: $_SESSION['GLO_msgE']="El mail no pudo enviarse";break;
	case 17: $_SESSION['GLO_msgE']="Por favor aplique algun filtro de busqueda";break;
	case 18: $_SESSION['GLO_msgE']="Los cambios no se grabaron. Verifique si el dato ya existe";break;
	case 19: $_SESSION['GLO_msgC']="Los cambios se grabaron. Por favor complete el nuevo nombre";break;
	case 20: $_SESSION['GLO_msgC']="Los Examenes a Cuenta no son suficientes para armar el Paquete";break;
	case 21: $_SESSION['GLO_msgE']="Existe otro Cliente con ese CUIT";break;
	case 22: $_SESSION['GLO_msgE']="Por favor seleccione Tipo de IVA";break;
	case 23: $_SESSION['GLO_msgE']="Por favor NO seleccione Tipo de IVA";break;
	case 24: $_SESSION['GLO_msgE']="El Numero de cheque no pertenece a esta chequera";break;
	case 25: $_SESSION['GLO_msgE']="Por favor seleccione un lote menor o igual a 100 cheques";break;
	case 26: $_SESSION['GLO_msgE']="Por favor agregue una Orden de Compra";break;
	case 27: $_SESSION['GLO_msgE']="No existen datos que cumplan esos criterios";break;
	case 28: $_SESSION['GLO_msgE']="EL CUIT YA EXISTE, confirma que desea CREARLO?";break;
	case 30: $_SESSION['GLO_msgE']="No puedo efectuarse el reporte";break;
	case 31: $_SESSION['GLO_msgE']="Los cambios no se grabaron. El registro tiene datos asociados";break;
	case 32: $_SESSION['GLO_msgE']="Por favor seleccione el periodo";break;
	case 33: $_SESSION['GLO_msgE']="Los cambios no se grabaron. Por favor verifique si el Nombre ya existe";break;
	case 34: $_SESSION['GLO_msgE']="Por favor seleccione alguna fila";break;
	case 35: $_SESSION['GLO_msgE']="El archivo no se pudo grabar";break;	
	case 36: $_SESSION['GLO_msgE']="Por favor seleccione un archivo";break;
	}
}


function GLO_mensajeerror(){
	echo '<table  width="100%" border="0" cellspacing="0" cellpadding="0" >';
	echo '<tr align="center"> <td align="center" class="MuestraError" style="font-size:1.5rem;font-weight:bold;">'; if (!(empty($_SESSION['GLO_msgE']))){echo '<i class="fas fa-exclamation-circle iconvsmallsp"></i> '.$_SESSION['GLO_msgE'];} echo '</td> </tr>';
	echo '<tr align="center"> <td align="center" class="MuestraConf" >'; if (!(empty($_SESSION['GLO_msgC']))){echo '<i class="fas fa-check-circle iconvsmallsp"></i> '.$_SESSION['GLO_msgC'];} echo '</td> </tr>';
	echo '</table>';
}
	
function GLO_mensajeerrorE(){
	echo '<table  width="100%" border="0" cellspacing="0" cellpadding="0">';
	echo '<tr align="center"> <td align="center" class="MuestraError" style="font-size:1.5rem;font-weight:bold;">'; if (!(empty($_SESSION['GLO_msgE']))){echo '<i class="fas fa-exclamation-circle iconvsmallsp"></i> '.$_SESSION['GLO_msgE'];} echo '</td> </tr>';
	echo '</table>';
}
	
	



function GLO_Ancla($id){
echo '<a id="'.$id.'"></a>';
}



//html
function GLO_InitHTML($arbol,$body,$banner,$form,$tform,$v1,$v2,$v3){
	include ($arbol."Codigo/HeadFull.php");
    echo '<link rel="STYLESHEET" type="text/css" href="'.$arbol.'CSS/Estilo.css">';
	GLO_bodyform($body,0,0);
	include ($arbol."Codigo/".$banner.".php");
	GLO_formform('Formulario',$form.'.php',$tform,0,0);
}
function GLO_bodyform($campo,$flag1,$flag2){
if($campo==''){$onload='';}else{$onload='onLoad="document.forms['."'Formulario'"."]['".$campo."'].focus()".'"';}
echo '</head>';
echo '<body leftmargin="0" height="100%"  topmargin="0" marginwidth="0" marginheight="0" '.$onload.'>'; 
}
function GLO_formform($name,$action,$flag1,$flag2,$flag3){
if($flag1==1){$keypress='onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}"';}else{$keypress='';}
if($flag2==1){$enctype='enctype="multipart/form-data"';}else{$enctype='';}
echo '<form name="'.$name.'" action="'.$action.'" method="post" '.$keypress.' '.$enctype.'>'; 
}




//comentario
function GLO_initcomment($w,$v1){
	if($w==0){$w='100%';$pad='padding-left:5px;';}else{$pad='';}
	echo '<table  width="'.$w.'" border="0" cellspacing="0" cellpadding="0" ><tr><td class="comentario" style="line-height:1.7rem;'.$pad.'">';
}
function GLO_endcomment(){
	echo '</td></tr></table>';
}



//titulo
function GLO_tituloypath($help,$w2,$ruta,$titulo,$tipo){
	//help
	if(intval($help)==1){$help='<i class="far fa-question-circle iconsmallbt iconlgray" onClick="document.Formulario.target='."'_blank'".';document.Formulario.CmdManualIntra.click();"  ></i>';}else{$help='';}
	//titulo
	if($tipo!='sintitulo'){
		echo '<table width="'.$w2.'" border="0"  cellpadding="0" cellspacing="0" class="fondo" style="padding-top:1rem;">';
		echo '<tr > <td width="30%">'.$help.'</td><td align="center" valign="bottom" class="Titulo" width="40%" >'.$titulo.'</td><td width="30%" align="right">';
		//opciones
		switch ($tipo) {
			case 'basica':	echo '<input name="CmdAgregar" type="submit" class="boton"  title="Agregar" value="Agregar"> <button name="CmdSalir" type="submit" class="iconbtn"> <i '.GLO_IconSalir().'></i></button>'; break;
			case 'close':	echo '<i '.GLO_IconClose().' onClick="window.close();"></i>'; break;
			case 'salir':	echo '<i '.GLO_IconSalir().' onClick="document.Formulario.target='."'_self'".';document.Formulario.CmdSalir.click();"  ></i>'; break;
			case 'linksalir':	echo '<i '.GLO_IconSalir().' onClick="document.Formulario.target='."'_self'".';window.location.href='."'".$ruta."'".'"></i>'; break;
			break;
		}	
		//fin opciones
		echo '</td></tr><tr> <td style="height:0.4rem;"></td></tr></table> ';
	}
}




function GLO_obsform($w1,$w2,$titulo,$campo,$row,$tipo){//$tipo=0 text,$tipo=1 char max 200,$tipo=2 char max 100
	$w3=$w1-$w2;$w4=$w3-50;if($tipo==1){$maxl=200;}if($tipo==2){$maxl=100;}
	echo '<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>';         
	echo '<table width="'.$w1.'" border="0"  cellspacing="0" class="Tabla" >'; 
	echo '<tr> <td width"'.$w2.'" height="3"></td> <td width="'.$w3.'"></td></tr>'; 
	if ($tipo==1 or $tipo==2){
		echo '<tr> <td height="18"  align="right" valign="top" >'.$titulo.':</td><td  valign="top">&nbsp;<input name="'.$campo.'"  type="text"  class="TextBox"  style="width:'.$w4.'px" maxlength="'.$maxl.'"  value="'; echo $_SESSION[$campo]; echo '" ></td></tr>';
	}else{
		echo '<tr> <td height="18"  align="right" valign="top" >'.$titulo.':</td><td  valign="top">&nbsp;<textarea name="'.$campo.'" style="width:'.$w4.'px" rows="'.$row.'" class="TextBox" onKeyPress="event.cancelBubble=true;">'; echo $_SESSION[$campo]; echo '</textarea></td></tr>';
	}
	echo '</table>'; 
}

function GLO_obs($w1,$w2,$titulo,$campo,$row,$tipo,$tab){//$tipo=0 text,$tipo=1 char max 200,$tipo=2 char max 100
	$w3=$w1-$w2;$w4=$w3-50;if($tipo==1){$maxl=200;}if($tipo==2){$maxl=100;}
	echo '<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>';         
	echo '<table width="'.$w1.'" border="0"  cellspacing="0" class="Tabla" >'; 
	echo '<tr> <td width"'.$w2.'" height="3"></td> <td width="'.$w3.'"></td></tr>'; 
	if ($tipo==1 or $tipo==2){
		echo '<tr> <td height="18"  align="right" valign="top" >'.$titulo.':</td><td  valign="top">&nbsp;<input name="'.$campo.'"  type="text"  class="TextBox" tabindex="'.$tab.'" style="width:'.$w4.'px" maxlength="'.$maxl.'"  value="'; echo $_SESSION[$campo]; echo '" ></td></tr>';
	}else{
		echo '<tr> <td height="18"  align="right" valign="top" >'.$titulo.':</td><td  valign="top">&nbsp;<textarea name="'.$campo.'" tabindex="'.$tab.'" style="width:'.$w4.'px" rows="'.$row.'" class="TextBox" onKeyPress="event.cancelBubble=true;">'; echo $_SESSION[$campo]; echo '</textarea></td></tr>';
	}
	echo '</table>'; 
}


function GLO_guardar($w1,$tab,$v2){
	echo '<table width="'.$w1.'" border="0"   cellspacing="0" class="Tabla TMT" >'; 
	echo '<tr> <td height="5"  ></td></tr><tr><td height="18"  align="center">';
	echo '<input name="CmdAceptar" type="submit" class="boton" tabindex="'.$tab.'" value="Guardar" onClick="document.Formulario.target='."'_self'".'">';
	echo '</td> </tr></table>'; 
}



function GLO_botonesform($w1,$flag1,$flag2){//flag1: 'Guardar' (0 muestra,1 oculta),flag2: 'Cerrar' (0 muestra,1 close, 2 oculta)
echo '<table width="'.$w1.'" border="0"   cellspacing="0" class="Tabla TMT" >'; 
echo '<tr> <td height="5"  ></td></tr><tr><td height="18"  align="center">';
if($flag1==0){echo '<input name="CmdAceptar" type="submit" class="boton"  value="Guardar" onClick="document.Formulario.target='."'_self'".'">';}
if($flag2==0){echo '&nbsp;&nbsp;<input name="CmdCancelar" type="submit" class="boton"  value="Cerrar" onClick="document.Formulario.target='."'_self'".'">';}
if($flag2==1){echo '&nbsp;&nbsp;<input name="CmdCancelar"  type="button" class="boton"  value="Cerrar" onClick="window.close();">';}
echo '</td> </tr></table>'; 
}

function GLO_botonform($w1,$value,$v1,$v2){
echo '<table width="'.$w1.'" border="0"   cellspacing="0" class="Tabla TMT" >'; 
echo '<tr> <td height="5"  ></td></tr><tr><td height="18"  align="center"  >';
echo '<input name="CmdAceptar" type="submit" class="boton"  value="'.$value.'" onClick="document.Formulario.target='."'_self'".'">';
echo '</td> </tr></table>'; 
}

function GLO_guardarform($w,$guardar,$cerrar,$exportar,$v1){//Guardar:0 muestra,1 oculta,Cerrar:0 muestra,1 close, 2 oculta
$wl=150;$wc=$w-300;
echo '<table width="'.$w.'" border="0"  cellspacing="0" class="Tabla TMT" >'; 
echo '<tr> <td height="5" width="'.$wl.'" ></td><td width="'.$wc.'"></td><td width="'.$wl.'" ></td></tr>'; 
echo '<tr ><td height="18" ></td><td align="center" >';
if($guardar==0){echo '<input name="CmdAceptar" type="submit" class="boton"  value="Guardar" onClick="document.Formulario.target='."'_self'".'">';}
if($cerrar==0){echo '&nbsp;&nbsp;<input name="CmdCancelar" type="submit" class="boton"  value="Cerrar" onClick="document.Formulario.target='."'_self'".'">';}
if($cerrar==1){echo '&nbsp;&nbsp;<input name="CmdCancelar"  type="button" class="boton"  value="Cerrar" onClick="window.close();">';}
echo '</td><td align="right">'; 		
if($exportar==1){echo GLO_FAButton('CmdImprimir','submit','80','blank','Imprimir','print','boton02');}			
echo '&nbsp;</td></tr></table>'; 
}




function GLO_exportarform($w1,$flag1,$flag2,$flag3,$flag4,$flag5){
echo '<table width="'.$w1.'" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td align="right">'; 
if($flag1==1){echo ' '.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02');}
if($flag2==1){echo ' '.GLO_FAButton('CmdExcel2','submit','80','self','Exportar','excel','boton02');}
if($flag3==1){echo ' '.GLO_FAButton('CmdImprimir','submit','80','blank','Imprimir','print','boton02');}
if($flag4==1){echo ' '.GLO_FAButton('CmdEnviar','submit','80','self','Enviar','mail','boton02');}
echo '</td> </tr></table>'; 
}


function GLO_cierratablaform(){
//comand
echo '<input name="CmdLinkRow" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow1" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow2" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow3" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow4" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow5" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow6" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow7" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow8" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow9" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdLinkRow10" type="submit" style="visibility:hidden" value="" >'; //click modificar fila tabla
echo '<input name="CmdSalir"  	type="submit" style="visibility:hidden" value="">';//click boton salir GLO_tituloypath
echo '<input name="CmdManualIntra" type="submit" style="visibility:hidden" value="">';//click boton help GLO_tituloypath
echo '<input name="GLO_getid"   type="hidden" value="'; echo $_SESSION['GLO_getid'];  echo '" >';
echo '<input name="GLO_getidp"  type="hidden" value="'; echo $_SESSION['GLO_getidp']; echo '" >';
echo '<input name="GLO_getidf"  type="hidden" value="'; echo $_SESSION['GLO_getidf']; echo '" >';
echo '</Form>';
}




function GLO_LinkRowTablaInit(&$estilo,&$link,$id,$tipo){
	$estilo=" style='cursor:pointer;' ";
	$txtid=' onclick="document.Formulario.TxtId.value='.$id.';';
	$target1='document.Formulario.target='."'_self'".';';
	$target2='document.Formulario.target='."'_blank'".';';
	switch ($tipo) {
		case 0:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow.click();"'; break;
		case 1:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow1.click();"'; break;
		case 2:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow2.click();"'; break;
		case 3:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow3.click();"'; break;
		case 4:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow4.click();"'; break;
		case 5:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow5.click();"'; break;
		case 6:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow6.click();"'; break;
		case 7:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow7.click();"'; break;
		case 8:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow8.click();"'; break;
		case 9:	$link=$txtid.$target1.'document.Formulario.CmdLinkRow9.click();"'; break;
		case 10: $link=$txtid.$target1.'document.Formulario.CmdLinkRow10.click();"'; break;
		case 99: $link=$txtid.$target2.'document.Formulario.CmdLinkRow.click();"'; break;
	}
}



function GLO_inittabla($w,$v1,$v2,$v3){//$v1=1 TShow
	$texto='<table  width="'.$w.'" border="0" cellspacing="0" cellpadding="0" ><tr> <td  height="3" ></td></tr><tr valign="top"><td  align="center" valign="top" >';
	if($v1==0){$texto .='<table width="'.$w.'" border="0" cellspacing="0" cellpadding="0"><tr>';}
	if($v1==1){$texto .='<table width="'.$w.'" class="TableShow" id="tshow"><tr>';}//TShow
	return $texto;
}

function GLO_fintabla($v1,$v2,$v3){
	//nombre
	$nombre=' registros';
	if($v2==1){$nombre=' examenes';}
	//recuento
	$texto='</table></td></tr>';	
	if($v3!=0){$texto .='<tr><td class="comentario" style="vertical-align:top;text-align:right;">'.$v3.$nombre.'</td></tr>';}
	else{$texto .='<tr><td  height=5 ></td></tr>';}
	//botones
	if($v1==1){$texto .='<tr><td align="right">'.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02').'</td></tr>';}
	if($v1==2){$texto .='<tr><td align="right">'.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02').' '.GLO_FAButton('CmdExcel2','submit','80','self','Detalle','excel','boton02').'</td></tr>';}
	if($v1==3){$texto .='<tr><td align="right">'.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02').' '.GLO_FAButton('CmdImprimir','submit','80','blank','Imprimir','print','boton02').'</td></tr>';}
	//
	$texto .='<tr><td  height=5 ></td></tr></table>';
	return $texto;
}
function GLO_fintablaConSuma($v1,$v2,$v3,$v4,$v5){
	//recuento y suma
	$texto='</table></td></tr>';	
	if($v3!=0){$texto .='<tr><td class="comentario" style="vertical-align:top;text-align:right;">'.$v3.' registros | '.$v4.' '.$v5.'</td></tr>';}
	else{$texto .='<tr><td  height=5 ></td></tr>';}
	//botones
	if($v1==1){$texto .='<tr><td align="right">'.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02').'</td></tr>';}
	if($v1==2){$texto .='<tr><td align="right">'.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02').' '.GLO_FAButton('CmdExcel2','submit','80','self','Detalle','excel','boton02').'</td></tr>';}
	$texto .='<tr><td  height=5 ></td></tr></table>';
	return $texto;
}



//hidden
function GLO_Hidden($campo,$v1){
	echo '<input name="'.$campo.'" type="hidden" value="'.$_SESSION[$campo].'" >';
}




function GLO_linkbutton($w,$n1,$l1,$n2,$l2,$n3,$l3){
	echo '<table  width="'.$w.'" border="0" cellspacing="0" cellpadding="0" >
	<tr><td  height=3 ></td></tr>
	<tr><td align="left" valign="bottom" >
	<input name="Cmd'.$n1.'" type="button" class="boton" value="'.$n1.'" style="width:8rem;" onClick="document.Formulario.target='."'_self'".';window.location.href='."'".$l1."'".'">';
	if($n2!=''){echo ' <input name="Cmd'.$n2.'" type="button" class="boton" value="'.$n2.'" style="width:8rem;" onClick="document.Formulario.target='."'_self'".';window.location.href='."'".$l2."'".'">';}
	if($n3!=''){echo ' <input name="Cmd'.$n3.'" type="button" class="boton" value="'.$n3.'" style="width:8rem;"  onClick="document.Formulario.target='."'_self'".';window.location.href='."'".$l3."'".'">';}
	echo '</td></tr></table>';	
}




//check
function GLO_CheckColor($texto,$check,$v1){ 
	if(intval($check)==0){echo '<label style="border:none;">'.$texto.'</label>';}
	else{echo '<label style="border: none;color:#f44336;">'.$texto.'</label>';}
}

function GLO_CmdAddRefresh($campo,$v1){
echo '<button name="CmdAdd'.$campo.'" type="submit" class="iconbtn" title="Agregar" onClick="document.Formulario.target='."'_blank'".'"><i class="fa fa-plus iconvsmallbt iconlgray"></i></button>';
echo ' <button name="CmdRefresh'.$campo.'" type="submit" class="iconbtn"  title="Actualizar" onClick="document.Formulario.target='."'_self'".'"><i class="fa fa-redo iconvsmallbt iconlgray"></i></button>';
}

function GLO_highlight($id){ return ' id="'.$id.'" onmouseover="CheckRowShadow('."'".$id."'".',1);" onmouseout="CheckRowShadow('."'".$id."'".',0);"';}


function GLO_Search($campo,$v1){echo GLO_FAButton($campo,'submit','','self','Buscar','lupa','iconbtn').'&nbsp;';}


//icon buttons
function GLO_IconSalir(){ return 'class="fas fa-arrow-left iconmedium iconlgray"';}
function GLO_IconClose(){ return 'class="fas fa-times iconmedium iconlgray"';}
function GLO_IconEraser(){ echo 'class="fas fa-eraser iconsmallbt iconlgray"';}
function GLO_IconSearch(){ return '<i class="fas fa-search iconsmallbt iconlgray"></i>';}
function GLO_IconSave(){ return '<i class="fas fa-save iconsmallbt iconlgray"></i>';}
function GLO_IconExcel(){ return '<i class="far fa-file-excel iconsmallbt iconlgray"></i>';}
function GLO_IconEdit(){ return '<i class="fas fa-edit iconsmallbt iconlgray"></i>';}




//buttons
function GLO_linkrow($id,$title,$icon,$color,$strow,$target,$link,$v1){
	GLO_faicon($icon,$class,$sizeicon);
	if($strow==1){$strow=GLO_mouseoverbutton($id,0);}
	//self/blank
	if($target==0){$target='onClick="window.location.href='."'".$link."'".';" ';
	}else{$target='onClick="window.open('."'".$link."')".';" ';}
	//button
	return '<button type="button" class="iconbtn"  title="'.$title.'" id="'.$id.'" '.$target.$strow.' ><i class="'.$icon.' iconsmall '.$class.' '.$color.'"></i></button>';
}


function GLO_mouseoverbutton($id,$v1){
	$res=' onmouseover="OverRow('.$id.',1);"  onmouseout="OverRow('.$id.',0);"';
	return $res;
}
function GLO_rowbutton($name,$id,$title,$target,$icon,$color,$conf,$strow,$v2,$v3){
	GLO_faicon($icon,$class,$sizeicon);
	if($conf!=''){$conf='return confirm('."'".$conf."'".');';}
	if($strow==1){$strow=GLO_mouseoverbutton($id,0);}
	return '<button name="'.$name.'" type="submit" class="iconbtn"  title="'.$title.'" id="'.$id.'" onClick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_".$target."'".';'.$conf.'" '.$strow.' ><i class="'.$icon.' iconsmall '.$class.' '.$color.'"></i></button>';
}

function GLO_formbutton($name,$type,$width,$target,$texto,$icon,$classb,$tab,$v2,$v3){
	$sizeicon=' iconsmall';
	GLO_faicon($icon,$class,$sizeicon);
	//variables
	if($tab!=0){$tab=' tabindex="'.$tab.'"';}else{$tab='';}
	if($classb==''){$classb='boton';}
	$title='';
	$width='style="width:'.$width.'px;"';
	$icono='<i class="'.$class.' '.$sizeicon.'"></i> ';
	//sin icono
	if($icon==''){$icono='';}
	//solo icono
	if($classb=='iconbtn'){$icono='<i class="'.$class.' iconsmallbt iconlgray"></i> ';$title='title="'.$texto.'"';$texto='';}
	//escribe button
	return '<button name="'.$name.'" type="'.$type.'" '.$tab.' class="'.$classb.'" '.$width.' '.$title.' onClick="document.Formulario.target='."'_".$target."'".'">'.$icono.$texto.'</button>';
}


function GLO_FAButton($name,$type,$width,$target,$texto,$icon,$classb){
	$sizeicon=' iconsmall';
	GLO_faicon($icon,$class,$sizeicon);
	//variables
	if($classb==''){$classb='boton';}
	$title='';
	$width='style="width:'.$width.'px;"';
	$icono='<i class="'.$class.' '.$sizeicon.'"></i> ';
	//sin icono
	if($icon==''){$icono='';}
	//solo icono
	if($classb=='iconbtn'){$icono='<i class="'.$class.' iconsmallbt iconlgray"></i> ';$title='title="'.$texto.'"';$texto='';}			
	//escribe button
	return '<button name="'.$name.'" type="'.$type.'" class="'.$classb.'" '.$width.' '.$title.' onClick="document.Formulario.target='."'_".$target."'".'">'.$icono.$texto.'</button>';
}
function GLO_FAButtonIcon($name,$type,$width,$target,$texto,$icon,$classb){
	GLO_faicon($icon,$class,$sizeicon);
	//solo icono
	$icono='<i class="'.$class.' iconsmallbt '.$classb.'"></i> ';
	//escribe button
	return '<button name="'.$name.'" type="'.$type.'" class="iconbtn"  title="'.$texto.'" onClick="document.Formulario.target='."'_".$target."'".'">'.$icono.'</button>';
}

function GLO_faicon($icon,&$class,&$sizeicon){
	switch ($icon) {
		case 'excel':  $class='far fa-file-excel'; break;
		case 'mail':   $class='fas fa-paper-plane'; break;
		case 'unlock': $class='fas fa-unlock'; break;
		case 'lock': $class='fas fa-lock'; break;
		case 'print': $class='fas fa-file-pdf'; break;
		case 'print2': $class='far fa-file-pdf'; break;
		case 'file': $class='far fa-file'; break;
		case 'lupa': $class='fas fa-search'; break;
		case 'pago': $class='fas fa-dollar-sign'; break;
		case 'load': $class='fas fa-redo'; break;
		case 'cross': $class='fas fa-times-circle'; break;
		case 'save': $class='fas fa-save'; break;
		case 'user': $class='fas fa-user'; break;
		case 'bill': $class='fas fa-money-check'; break;
		case 'medrx': $class='fas fa-file-prescription'; break;
		case 'medfile': $class='fas fa-file-medical'; break;
		case 'medcom': $class='fas fa-comment-medical'; break;
		case 'clock': $class='far fa-clock'; break;
		case 'flag': $class='fas fa-flag'; break;
		case 'calc': $class='fas fa-calculator'; break;
		case 'cart': $class='fas fa-shopping-cart'; break;
		case 'stock': $class='fas fa-dolly-flatbed'; break;
		case 'folder': $class='fas fa-folder-open'; break;
		case 'key': $class='fas fa-key'; break;
		case 'light': $class='fas fa-lightbulb'; break;
		case 'add': $class='fas fa-folder-plus'; break;
		case 'del': $class='fas fa-folder-minus'; break;
		case 'sort': $class='fas fa-sort'; break;
		case 'edit': $class='fas fa-edit'; break;
		case 'firma': $class='fas fa-marker'; break;
		case 'trash': $class='fas fa-trash'; $sizeicon=' iconvsmall';break;
		case 'down': $class='fas fa-download'; break;
		case 'check': $class='fas fa-check'; break;
		case 'anul': $class='fas fa-ban'; break;
		case 'close': $class='fas fa-times'; break;
		case 'cloudd': $class='fas fa-cloud-download-alt'; break;
		case 'clip': $class='fas fa-paperclip'; break;
		case 'certif': $class='fas fa-file-signature'; break;
		case 'upload': $class='fas fa-upload'; break;
		case 'help': $class='far fa-question-circle'; break;
		case 'unlink': $class='fas fa-unlink'; break;
		case 'dep': $class='fas fa-warehouse'; break;
		case 'clone': $class='fas fa-clone'; break;
		case 'checklist': $class='fas fa-clipboard-check'; break;
		case 'card': $class='fas fa-address-card'; break;
		case 'undo': $class='fas fa-delete-left'; break;
		case 'done': $class='fas fa-circle-check'; break;
		//flags
		case 'flagblue': $class='fas fa-shield-alt iconblue2'; break;
		case 'flagorange': $class='fas fa-shield-alt iconorange'; break;
		case 'flaggreen': $class='fas fa-shield-alt icongreen'; break;
		case 'flagviolet': $class='fas fa-shield-alt iconviolet'; break;
	}
}



//new
function GLOF_init($body,$banner,$form,$tform,$menuh,$etype,$v2,$v3){
	//head
	include ($_SESSION["NivelArbol"]."Codigo/HeadFull.php");
    echo '<link rel="STYLESHEET" type="text/css" href="'.$_SESSION["NivelArbol"].'CSS/Estilo.css">';
	if($body==''){$onload='';}else{$onload='onLoad="document.forms['."'Formulario'"."]['".$body."'].focus()".'"';}
	echo '</head>';
	//body
	echo '<body leftmargin="0" height="100%"  topmargin="0" marginwidth="0" marginheight="0" '.$onload.'>'; 
	//banner
	include ($_SESSION["NivelArbol"]."Codigo/".$banner.".php");
	//submenu
	if($menuh!=''){$menuh=$menuh.'.php';include($menuh);}
	//form name
	if($form!=''){$form=$form.'.php';}
	//form enter behavior
	if($tform==1){$keypress='onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}"';}else{$keypress='';}
	//form upload file
	if($etype==1){$etype='enctype="multipart/form-data"';}else{$etype='';}
	//form
	echo '<form name="Formulario" action="'.$form.'" method="post" '.$keypress.' '.$etype.'>'; 
}


function GLOF_botonesform($w,$g,$c,$t,$v){//g: 'Guardar' (0 muestra,1 oculta),c: 'Cerrar' (0 muestra,1 close, 2 oculta)
//variables
if($t==0){$t='';}else{$t='tabindex="'.$t.'"';}
//clase
if($v==0){$clase='Tabla TMT';}else{$clase='TablaBuscar TMT';}
//muestra
echo '<table width="'.$w.'" border="0"  cellspacing="0" class="'.$clase.'" >'; 
echo '<tr><td align="center" style="padding-top:5px;">';
if($g==0){echo '<input name="CmdAceptar" type="submit" class="boton" '.$t.' value="Guardar" onClick="document.Formulario.target='."'_self'".'">';}
if($c==0){echo '&nbsp;&nbsp;<input name="CmdCancelar" type="submit" class="boton" '.$t.' value="Cerrar" onClick="document.Formulario.target='."'_self'".'">';}
if($c==1){echo '&nbsp;&nbsp;<input name="CmdCancelar"  type="button" class="boton" '.$t.' value="Cerrar" onClick="window.close();">';}
echo '</td></tr>'; 					
echo '</table>'; 
}


//buttons
function GLOF_buttonpanel($class,$value,$onclick,$v1,$v2,$v3){
	echo '<input name="Cmd" type="button" class="'.$class.'" value=" '.$value.'" onClick="window.location.href='."'".$onclick."'".';">';
}


//eventos
function GLO_keypress($v1){
echo ' onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}"';
}


function GLO_formfocus($campo,$v1){//focus
	if ( empty($_SESSION['GLO_Focus']) ){$focus=$campo;}else{$focus=$_SESSION['GLO_Focus'];}
	return $focus;
}


function GLO_hora($campo,$tab){
	echo '<input name="'.$campo.'" id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="'.$_SESSION[$campo].'" onChange="this.value=validarHora(this.value);" tabindex="'.$tab.'">';
}

?>