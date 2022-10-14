<? include("Seguridad.php");include("FuncionesCOM.php");include("FuncionesFORM.php");include("FuncionesCOD.php");include("FuncionesEMP.php");

//seguridad
function GLO_ValidaGET($varget,$var1,$var2){//valida que no se acceda con GET 0 a esta pgina, va inicio
if(intval($varget)==0){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
}
function GLO_ValidaGETCLOSE($varget,$var1,$var2){//valida que no se acceda con GET 0 a esta pgina, cierra pestaa
if(intval($varget)==0){ echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";}
}
function GLO_ValidaSESSION($varget,$var1,$conn){//valida que no se acceda con GET 0 a esta pgina, ni refresh de False 
if(intval($varget)==0){mysql_close($conn);header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
}
function GLO_windowclose($v1){
	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}



//nuevo id
function GLO_generoID($tabla,$conn){
	$query="SELECT Max(Id) as UltimoId FROM $tabla";$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)==0){$nroId=1;}else{$nroId=$row10['UltimoId']+1;}mysql_free_result($rs10);
	return $nroId;
}

//file
function GLO_OpenFile($tabla,$id,$carpeta,$campo){
	include("Config.php");
	//busco ruta
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT $campo From $tabla Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$ruta=$row[$campo];}else{$ruta="";}mysql_free_result($rs);
	mysql_close($conn); 
	//abro file	
	$file='../Archivos/'.$carpeta.$ruta;
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}
}

function GLO_OpenPDF($ruta,$v1){//solo pdf, abre en navegador
	$file='../Archivos/'.$ruta;
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}else{GLO_windowclose(0);}
}

function GLO_Correlativo($tabla,$campo,$conn){
	$query="SELECT Max($campo) as UltimoId FROM $tabla";$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)==0){$nroId=1;}else{$nroId=$row10['UltimoId']+1;}mysql_free_result($rs10);
	return $nroId;
}





//utf
function GLO_textoFPDF($texto){
	$texto=utf8_decode($texto);
	return $texto;
}
function GLO_textoPHPExcel($texto){
	$texto=$texto;
	return $texto;
}
function GLO_textoExcel($texto){
	$texto=utf8_decode($texto);
	return $texto;
}


//cadena
function GLO_AjustarTextArea($texto,$rows,$width){// 100 caracteres una linea aprox 
	//saltos de linea
	$saltosLinea = explode("\n", $texto);
	$cantSaltosLinea = count($saltosLinea );	
	//caracteres
	$cantCaracteres = strlen($texto);	
	//caracteres por linea
	$limitelinea=ceil(($width*100)/700);//asumiendo que en 700 pixeles entran 100 caracteres
	//lineas
	$lineas=ceil($cantCaracteres/$limitelinea);	
	if($lineas<$cantSaltosLinea){$lineas=$cantSaltosLinea;}
	//limites
	if($lineas<$rows){$lineas=$rows;}/*limito minimo*/
	if($lineas>10){$lineas=10;}/*limito maximo*/
	echo $lineas;
}



function GLO_ListaTexto($cadena,$texto){
	if($cadena==''){$cadena=$texto;}else{$cadena=$cadena.', '.$texto;} 
    return $cadena;
}
function GLO_SinCero($var){
	if($var==0){$var='';}
    return $var;
}
function GLO_SinCeroSTRPAD($var,$cant){
	if($var==0){$var='';}
	else{$var=str_pad($var, $cant, "0", STR_PAD_LEFT);}
    return $var;
}


//check y opt
function GLO_SiNo($var){
	if($var==1){$var='SI';}else{$var='NO';}
    return $var;
}
function GLO_SiNo12($var){
	$res='';
	if($var==1){$res='SI';}
	if($var==2){$res='NO';}
    return $res;
}
function GLO_Si($var){
	if($var==1){$var='SI';}else{$var='';}
    return $var;
}



//moneda
function GLO_MostrarImporte($var){
	$res=number_format($var, 2, ',', '.');
	return $res;
}
function GLO_GrabarImporte($var){
	$res=$var;$res=str_replace('.','',$res);$res=str_replace(',','.',$res);if($res==''){$res=0;}
	return $res;
}




//fecha
function GLO_FechaVencida($fecha){//recibe dd/mm/aaaa
	$res=0;
	if($fecha!="" and (strtotime(date("d-m-Y"))-strtotime($fecha))>0){$res=1;}
	return $res;
}

function GLO_calendariovto($fecha,$ruta,$tipo,$tab){ 
	if($tab!=0){$tab='tabindex="'.$tab.'"';}else{$tab='';}
	if ($_SESSION[$fecha]!='' and (strtotime(date("d-m-Y"))-strtotime($_SESSION[$fecha]))>0){$clase="color:#f44336;";}else{$clase="";}
	echo '<input name="'.$fecha.'"  id="'.$fecha.'" type="text" class="TextBox"  style="width:65px;'.$clase.'" maxlength="10" '.$tab.' onchange="this.value=validarFecha(this.value);" value="'.$_SESSION[$fecha].'">';
	calendario($fecha,$ruta,$tipo);
}
function GLO_calendario($fecha,$ruta,$tipo,$tab){ 
	if($tab!=0){$tab='tabindex="'.$tab.'"';}else{$tab='';}
	echo '<input name="'.$fecha.'"  id="'.$fecha.'" type="text" class="TextBox"  style="width:65px" maxlength="10" '.$tab.' onchange="this.value=validarFecha(this.value);" value="'.$_SESSION[$fecha].'">';
	calendario($fecha,$ruta,$tipo);
}
function calendario($fecha,$ruta,$tipo){ 
  $myCalendar = new tc_calendar($fecha, true, false);
  $myCalendar->setIcon($ruta."calendar/images/calendario.png");
  $myCalendar->setDate(date("d"), date("m"), date("Y")); $myCalendar->setPath("./");
  if($tipo=='actual'){$myCalendar->setYearInterval(2000, 2030);$myCalendar->dateAllow('2000-01-01', '2030-01-01');}
  if($tipo=='nac'){$myCalendar->setYearInterval(1940, 2030);$myCalendar->dateAllow('1940-01-01', '2030-01-01');}
  $myCalendar->setDateFormat('j F Y'); $myCalendar->writeScript();
}

function GLO_FormatoHora($var){
	$var=date("H:i",strtotime($var)); if ($var=='00:00'){$var="";}
    return $var;
}
function GLO_FormatoFecha($f){
	list($a,$m,$d)=explode("-",$f);$var=$d."-".$m."-".$a;
	if ($var=='00-00-0000'){$var ="";}
    return $var;
}
function GLO_FechaMySql($var){
	if ($var==''){$var ="0000-00-00";}
	else{list($d,$m,$a)=explode("-",$var);$var=$a."-".$m."-".$d;}
	return $var;
}


//claculos fecha
function GLO_HoraaDecimal($var){
	list($h1,$m1,$s1)=explode(":",$var);$h1=$h1*3600;$m1=$m1*60;$var=number_format((($h1+$m1)/3600),2, ',', '');
    return $var;
}

function GLO_SegundosaDecimal($var){
	$var=number_format((($var)/3600),2, ',', '');
    return $var;
}


function FormatoFecha($f){
    list($a,$m,$d)=explode("-",$f);
    return $d."-".$m."-".$a;
}
function FechaMySql($fechavieja){
    list($d,$m,$a)=explode("-",$fechavieja);
    return $a."-".$m."-".$d;}
function FechaMySqlHora($fechavieja){
	list($f,$h)=explode(" ",$fechavieja);
    list($d,$m,$a)=explode("-",$f);
    return $a."-".$m."-".$d.' '.$h;}
function FormatoFechaHora($fechavieja){
	list($f,$h)=explode(" ",$fechavieja);
    list($a,$m,$d)=explode("-",$f);
	list($h1,$h2,$h3)=explode(":",$h);
    return $d."-".$m."-".$a.' '.$h1.':'.$h2;
}	
function FechaMesYear($fechavieja){
	list($f,$h)=explode(" ",$fechavieja);
    list($a,$m,$d)=explode("-",$f);
    return $m."-".$a;}
	
function dias_transcurridos($fecha_i,$fecha_f){//incluye desde (el dia hasta no lo cuenta)
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
function dias_transcurridos_2($fecha_i,$fecha_f){//incluye desde y hasta
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);	
	if($dias>=0){$dias++;}	
	return $dias;
}



function CompararFechas($fecha1,$fecha2){
	$fecha1 = strtotime($fecha1);
	$fecha2 = strtotime($fecha2);	
	if($fecha1 > $fecha2){$res=1;}
	if($fecha1 < $fecha2){$res=2;}
	if($fecha1 == $fecha2){$res=0;}	
	return $res;
}

	
function edad($edad){
list($anio,$mes,$dia) = explode("-",$edad);
$anio_dif = date("Y") - $anio;$mes_dif = date("m") - $mes;$dia_dif = date("d") - $dia;
if (($mes_dif < 0) or($dia_dif < 0 and $mes_dif == 0))
$anio_dif--;
return $anio_dif;
}	
function ObtenerDiaSemana($fecha){//0=domingo	
	$numdia=date('w',strtotime($fecha));
	switch ($numdia) {
	case 0:	$nomdia='Domingo';break;
	case 1:	$nomdia='Lunes';break;
	case 2:	$nomdia='Martes';break;
	case 3:	$nomdia='Miercoles';break;
	case 4:	$nomdia='Jueves';break;
	case 5:	$nomdia='Viernes';break;	
	case 6:	$nomdia='Sabado';break;	
	}
	return $nomdia;
}	
function ObtenerDiaSemanaCorto($fecha){//0=domingo	
	$numdia=date('w',strtotime($fecha));
	switch ($numdia) {
	case 0:	$nomdia='Do';break;
	case 1:	$nomdia='Lu';break;
	case 2:	$nomdia='Ma';break;
	case 3:	$nomdia='Mi';break;
	case 4:	$nomdia='Ju';break;
	case 5:	$nomdia='Vi';break;	
	case 6:	$nomdia='Sa';break;	
	}
	return $nomdia;
}	
function G_NombreMes($m){ 
	switch ($m) {
		case 1:	$mes="Enero";break;
		case 2:	$mes="Febrero";break;
		case 3:	$mes="Marzo";break;
		case 4:	$mes="Abril";break;
		case 5:	$mes="Mayo";break;	
		case 6:	$mes="Junio";break;	
		case 7:	$mes="Julio";break;	
		case 8:	$mes="Agosto";break;	
		case 9:	$mes="Septiembre";break;	
		case 10:$mes="Octubre";break;	
		case 11:$mes="Noviembre";break;	
		case 12:$mes="Diciembre";break;	
	}		
	return $mes;
}


//cuit
function cuitValido($cuit,&$cuit_rearmado){
	$coeficiente[0]=5;
	$coeficiente[1]=4;
	$coeficiente[2]=3;
	$coeficiente[3]=2;
	$coeficiente[4]=7;
	$coeficiente[5]=6;
	$coeficiente[6]=5;
	$coeficiente[7]=4;
	$coeficiente[8]=3;
	$coeficiente[9]=2;
	$resultado=1;
	$resultadofuncion=1;
	//separo cualquier caracter que no tenga que ver con numeros
	for ($i=0; $i < strlen($cuit); $i= $i +1) {    
		if ((Ord(substr($cuit, $i, 1)) >= 48) && (Ord(substr($cuit, $i, 1)) <= 57)){
			$cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
		}
	}
	//si to estan todos los digitos
	if (strlen($cuit_rearmado) <> 11) { $resultado=0;$resultadofuncion=0;} 
	else {
		$sumador = 0;
		$verificador = substr($cuit_rearmado, 10, 1); //tomo el digito verificador
		//separo cada digito y lo multiplico por el coeficiente
		for ($i=0; $i <=9; $i=$i+1) { $sumador = $sumador + (substr($cuit_rearmado, $i, 1)) * $coeficiente[$i];	}
		$resultado = $sumador % 11;
		$resultado = 11 - $resultado;  //saco el digito verificador
		if ($resultado==11){$resultado=0;}
		$veri_nro = intval($verificador);
		if ($veri_nro <> $resultado) {$resultado=0;	$resultadofuncion=0;} 
		else { $cuit_rearmado = substr($cuit_rearmado, 0, 2) . "-" . substr($cuit_rearmado, 2, 8) . "-" . substr($cuit_rearmado, 10, 1);}
	}
	return $resultadofuncion;
}



//mail
function EnviarMail($a,$asunto,$cuerpo,$adjunto){ 
	include("Config.php");require_once('PHPMailer/class.phpmailer.php'); 
	//host y remitente
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT * From parametros";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$de=$row['MailFrom'];$pass=$row['Password'];$usuario=$row['Usuario'];$servidor=$row['ServerSMTP'];		
	}mysql_free_result($rs);
	mysql_close($conn); 
	//destinatario
	$a=str_replace(';',',',$a);//reemplaza ; por ,
	$para = explode( ",", $a );
	//adjuntos
	$fadjuntos = explode( ",", $adjunto);
	//setear
	$mail = new phpmailer();
	$mail->Mailer = "smtp";
	$mail->Host = $servidor;
	$mail->SMTPAuth = true;
	$mail->Username = $usuario;
	$mail->Password = $pass;
	$mail->IsHTML(true);
	$mail->From = $de;
	$mail->FromName = $de;
	$mail->Subject = $asunto;
	$body = $cuerpo;
	$mail->Body = $body;
	$mail->AltBody = $altbody;
	$mail->Timeout=20;
	foreach( $para as $destino ) {if ($destino!=''){$mail->addAddress( trim($destino) );}}
	if($adjunto!=''){foreach( $fadjuntos as $adj ) {if ($adj!=''){$mail->AddAttachment($adj);}}	} 	
	//enviar	
	$exito = $mail->Send();   
	$intentos=1; 
    while((!$exito)&&($intentos<2)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
        sleep(5);$exito = $mail->Send();$intentos=$intentos+1;                
    }
	//resultado
    if ($mail->ErrorInfo=="SMTP Error: Data not accepted") { $exito=true;}
	return $exito; 
}


?>