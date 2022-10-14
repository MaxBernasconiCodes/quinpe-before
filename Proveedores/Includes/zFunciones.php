<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//resultado
function PROV_EPestilo($total,$tipo,$salida){
	if($salida==0){//pagina
		if($tipo==1){$res='background-color: #f44336;color: #ffffff;';}else{$res='color: #f44336;';}//rojo
		if($total>=4){if($tipo==1){$res='background-color: #ff9900;color: #ffffff;';}else{$res='color: #ff9900';} }//amarillo
		if($total>7){if($tipo==1){$res='background-color: #4CAF50;color: #ffffff;';}else{$res='color: #4CAF50';} }//verde
	}else{//phpexcel
		if($tipo==1){$res='FFFF0000';}//rojo
		if($total>=4){$res='FFFFFF66';}//amarillo
		if($total>7){$res='FF99CC00';}//verde
	}
	return $res;
}


function PROV_EPlabel($total){
	$res="RECHAZADO";
	if($total>=4){$res="APROBADO CON OBSERVACIONES";}
	if($total>7){$res="APROBADO";}
	return $res;
}
function PROV_ColorExcel($total){
	$res='C30';//red
	if($total>=4){$res='E30';}//yellow
	if($total>7){$res='G30';}//green
	return $res;
}
function PROV_WhereDes($estado,$total){// 1: aprobado, 2:aprobado con obs, 3: rechazado
	$res=0;//no muestra
	switch ($estado) {
	case 1:if($total>7){$res=1;}break;
	case 2:if($total<=7 and $total>=4){$res=1;}break;
	case 3:if($total<4){$res=1;}break;
	}
	return $res;
}



function PROV_CbDes($campo){
$combo="";
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."APROBADO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."APROBADO"."</option>\n";}
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."APROBADO C/OBS"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."APROBADO C/OBS"."</option>\n";}
if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."RECHAZADO"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."RECHAZADO"."</option>\n";}
echo $combo;
}



function PROV_CbEP1($campo,$tipo){
//variables
$combo="";$op1='';$op2='';$op3='';
$esp1='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';$esp2='&nbsp;&nbsp;&nbsp;';
//opciones
switch ($tipo) {
case 1:
	$op1='1 '.$esp1.'  + de 2 a&ntilde;os o + de 3 servicios equivalentes';
	$op2='0.5 '.$esp2.' 1-2 a&ntilde;os o + de 2 servicios equivalentes';
	$op3='0 '.$esp1.'  sin experiencia previa';
	break;
case 2:	
	$op1='1 '.$esp1.'  desvios/pedidos del 0-10%';
	$op2='0.5 '.$esp2.' desvios/pedidos del 0-50%';
	$op3='0 '.$esp1.'  desvios/pedidos del 51-100%';
	break;
case 3:	
	$op1='1 '.$esp1.'  economico, con relacion a otros competidores';
	$op2='0.5 '.$esp2.' intermedio, con relacion a otros competidores';
	$op3='0 '.$esp1.'  costoso, con relacion a otros competidores';
	break;
case 4:	
	$op1='1 '.$esp1.'  permiten pago a + de 30 dias';
	$op2='0.5 '.$esp2.' requieren pago a 30 o - dias';
	$op3='0 '.$esp1.'  requieren anticipo y pago contado';
	break;
case 5:	
	$op1='1 '.$esp1.'  condiciones impositivas-legales actualizadas';
	$op2='0.5 '.$esp2.' se observa faltante de documentacion';
	$op3='0 '.$esp1.'  no cumple requisitos legales NO APTO';
	break;
case 6:	
	$op1='1 '.$esp1.'  responde inmediatamente (0-5 dias)';
	$op2='0.5 '.$esp2.' responde en un lapso de 6-25 dias';
	$op3='0 '.$esp1.'  no responde';
	break;
case 7:	
	$op1='1 '.$esp1.'  asesora consultas con creatividad y propone mejoras';
	$op2='0.5 '.$esp2.' responde a la solicitud pero no aporta nuevas opciones';
	$op3='0 '.$esp1.'  no presta asesoria';
	break;
case 8:	
	$op1='1 '.$esp1.'  vendedor comercial tecnico asignado, existe buena comunicacion';
	$op2='0.5 '.$esp2.' atencion comercial tecnico con varios vendedores, problemas de comunicacion';
	$op3='0 '.$esp1.'  no interactuan comercialmente, mala comunicacion';
	break;
case 9:	
	$op1='1 '.$esp1.'  proporciona certificado de calidad';
	$op2='0.5 '.$esp2.' sigue controles de calidad';
	$op3='0 '.$esp1.'  no sigue controles ni presenta certificado de calidad';
	break;
case 10:	
	$op1='1 '.$esp1.'  no registra';
	$op2='0.5 '.$esp2.' registra solo 1 no conformidad';
	$op3='0 '.$esp1.'  registra + de 1 no conformidad';
	break;
case 11:	
	$op1='1 '.$esp1.'  realiza periodicamente auditorias internas y externas';
	$op2='0.5 '.$esp2.' realiza ocasionalmente auditorias internas, pero no externas';
	$op3='0 '.$esp1.'  no realiza ni auditorias internas, ni externas';
	break;
case 12:	
	$op1='1 '.$esp1.'  aplica un procedimiento de evaluacion de AA e IA y Evaluacion de Riesgo';
	$op3='0 '.$esp1.'  no posee procedimiento de evaluacion de AA e IA y Evaluacion de Riesgo';
	break;
}
//combo
if("1"==$_SESSION[$campo]){$combo .='<option value="1" selected="selected">'.$op1.'</option>\n';}
else{$combo .='<option value="1">'.$op1.'</option>\n';}

if($tipo!=12){
if("0.5"==$_SESSION[$campo]){$combo .='<option value="0.5" selected="selected">'.$op2.'</option>\n';}
else{$combo .='<option value="0.5">'.$op2.'</option>\n';}
}

if("0"==$_SESSION[$campo]){$combo .='<option value="0" selected="selected">'.$op3.'</option>\n';}
else{$combo .='<option value="0">'.$op3.'</option>\n';}
echo $combo;
}










?>