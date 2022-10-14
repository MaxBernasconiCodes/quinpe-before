<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//persona propios y terceros 

//comunes a los dos
$id=intval($_POST['TxtNumero']);//id procesosop_e2
$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
$tipo=intval($_POST['CbTipo']);//1:propio, 2:terceros
$obs=mysql_real_escape_string($_POST['TxtObs']);
$temp=floatval($_POST['TxtTemp']);
$olf=intval($_POST['CbOlf']);
$idpadre=intval($_POST['TxtNroEntidad']);//proceso
$fv="0000-00-00";
if(intval($_POST['CbEtapa'])==1){$etapa=0;}else{$etapa=1;}//0:ingreso,1:salida



//especificos
if($tipo==1){//propio
	$per=intval($_POST['CbPersonal']);
}else{//terceros
	$prov=intval($_POST['CbProv']); 
	$cli=intval($_POST['CbCliente']);
	$cho=mysql_real_escape_string($_POST['TxtChofer']);
	$doc=mysql_real_escape_string($_POST['TxtDoc']);
}




//insert 1/update 2
if($tipocambio==1){
	//insert propio
	if($tipo==1){
		$nroId=GLO_generoID('procesosop_e2',$conn);
		$query="INSERT INTO procesosop_e2(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,Chofer,DNI,IdProv,IdCli,Obs,Temp,Olf,Etapa) VALUES ($nroId,0,$tipo,'$fecha','$hora',$per,'','',0,0,'$obs',$temp,$olf,$etapa)";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0;} 
	}
	//insert terceros
	if($tipo==2){
		//buscar datos dni persona
		$cho=BAR_datos_persona($doc,0,$conn);
		$cho=mysql_real_escape_string($cho);
		//
		$nroId=GLO_generoID('procesosop_e2',$conn);
		$query="INSERT INTO procesosop_e2(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,Chofer,DNI,IdProv,IdCli,Obs,Temp,Olf,Etapa) VALUES ($nroId,0,$tipo,'$fecha','$hora',0,'$cho','$doc',$prov,$cli,'',0,0,$etapa)";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0;} 
	}
}else{
	//where
	$wheregral="update procesosop_e2 set IdPadre=$idpadre,Tipo=$tipo,Fecha='$fecha',Hora='$hora',Obs='$obs',Temp=$temp,Olf=$olf";

	//update propio
	if($tipo==1){
		$query="$wheregral,IdChofer=$per Where Id=$id";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
	//update terceros
	if($tipo==2){
		//
		$query="$wheregral,Chofer='$cho',DNI='$doc',IdProv=$prov,IdCli=$cli Where Id=$id";
		$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
}
?>