<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//vehiculo propios y terceros 



//comunes a los dos
$id=intval($_POST['TxtNumero']);//id procesosop_e1
$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
$tipo=intval($_POST['CbTipo']);
$obs=mysql_real_escape_string($_POST['TxtObs']);
$temp=floatval($_POST['TxtTemp']);
$olf=intval($_POST['CbOlf']);
$mot=mysql_real_escape_string($_POST['TxtMotivo']);
$rto=mysql_real_escape_string($_POST['TxtRto']);
$idpadre=intval($_POST['TxtNroEntidad']);//solicitud
$fv="0000-00-00";
if(intval($_POST['CbEtapa'])==1){$etapa=0;}else{$etapa=1;}//0:ingreso,1:salida

//especificos
if($tipo==1){//propio
	$per=intval($_POST['CbPersonal']);
	$uni=intval($_POST['CbUnidad']);
	$uni2=intval($_POST['CbUnidad2']);
	$km=intval($_POST['TxtKm']); 
	$ret=intval($_POST['ChkRE']);
}else{//terceros
	$prov=intval($_POST['CbProv']); 
	$cli=intval($_POST['CbCliente']);
	$cho=mysql_real_escape_string($_POST['TxtChofer']);
	$doc=mysql_real_escape_string($_POST['TxtDoc']);
	$sedro=mysql_real_escape_string($_POST['TxtSedronar']);
	$mar=intval($_POST['CbMarca']); 
	$cat=intval($_POST['CbCateg']); 
	$mod=mysql_real_escape_string($_POST['TxtModelo']);
	$dom=mysql_real_escape_string($_POST['TxtDominio']);
	$mar2=intval($_POST['CbMarca2']); 
	$cat2=intval($_POST['CbCateg2']); 
	$mod2=mysql_real_escape_string($_POST['TxtModelo2']);
	$dom2=mysql_real_escape_string($_POST['TxtDominio2']);
	$chk1=intval($_POST['Chk1']); //Certificado de analisis
	$chk2=intval($_POST['Chk2']); //Hojas de seguridad de los productos
	$chku1=intval($_POST['ChkU1']);$chku2=intval($_POST['ChkU2']);$chku3=intval($_POST['ChkU3']);
	$chks1=intval($_POST['ChkS1']);$chks2=intval($_POST['ChkS2']);$chks3=intval($_POST['ChkS3']);
	$chkc1=intval($_POST['ChkC1']);$chkc2=intval($_POST['ChkC2']);
	$fu1=GLO_FechaMySql($_POST['TxtFechaU1']);$fu2=GLO_FechaMySql($_POST['TxtFechaU2']);$fu3=GLO_FechaMySql($_POST['TxtFechaU3']);
	$fs1=GLO_FechaMySql($_POST['TxtFechaS1']);$fs2=GLO_FechaMySql($_POST['TxtFechaS2']);$fs3=GLO_FechaMySql($_POST['TxtFechaS3']);
	$fc1=GLO_FechaMySql($_POST['TxtFechaC1']);$fc2=GLO_FechaMySql($_POST['TxtFechaC2']);
}



//insert 1/update 2
if($tipocambio==1){
	//insert propio
	if($tipo==1){
		//busca pedido de despacho y completa unidad y chofer
		$tipocompletar='unidad';include ("Includes/zBuscarSolicitud.php");
		//insert
		$nroId=GLO_generoID('procesosop_e1',$conn);
		$query="INSERT INTO procesosop_e1(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,IdUnidad,IdSemi,Km,Chofer,DNI,IdMarca,IdCateg,Modelo,Dominio,IdMarca2,IdCateg2,Modelo2,Dominio2,IdProv,IdCli,Rto,Mot,Chk1,Chk2,ChkU1,ChkU2,ChkU3,ChkS1,ChkS2,ChkS3,ChkC1,ChkC2,FU1,FU2,FU3,FS1,FS2,FS3,FC1,FC2,Sedro,Obs,Temp,Olf,IdPedido,Etapa,Retorno) VALUES ($nroId,$idpadre,$tipo,'$fecha','$hora',$per,$uni,$uni2,0,'','',0,0,'','',0,0,'','',0,0,'','',0,0,0,0,0,0,0,0,0,0,'$fv','$fv','$fv','$fv','$fv','$fv','$fv','$fv','','',0,0,0,$etapa,0)";
		$rs=mysql_query($query,$conn);
		if ($rs){
			GLO_feedback(1);$grabook=1;
			//busca pedido de despacho y completa items
			$tipocompletar='items';include ("Includes/zBuscarSolicitud.php");
		}else{GLO_feedback(2);$grabook=0;} 
	}
	//insert terceros
	if($tipo==2){
		//busca pedido de despacho y completa unidad y chofer
		$tipocompletar='unidad';include ("Includes/zBuscarSolicitud.php");
		//update
		$nroId=GLO_generoID('procesosop_e1',$conn);
		$query="INSERT INTO procesosop_e1(Id,IdPadre,Tipo,Fecha,Hora,IdChofer,IdUnidad,IdSemi,Km,Chofer,DNI,IdMarca,IdCateg,Modelo,Dominio,IdMarca2,IdCateg2,Modelo2,Dominio2,IdProv,IdCli,Rto,Mot,Chk1,Chk2,ChkU1,ChkU2,ChkU3,ChkS1,ChkS2,ChkS3,ChkC1,ChkC2,FU1,FU2,FU3,FS1,FS2,FS3,FC1,FC2,Sedro,Obs,Temp,Olf,IdPedido,Etapa,Retorno) VALUES ($nroId,$idpadre,$tipo,'$fecha','$hora',0,0,0,0,'$cho','$doc',$mar,$cat,'$mod','$dom',$mar2,$cat2,'$mod2','$dom2',$prov,$cli,'','',0,0,$chku1,$chku2,$chku3,$chks1,$chks2,$chks3,$chkc1,$chkc2,'$fu1','$fu2','$fu3','$fs1','$fs2','$fs3','$fc1','$fc2','$sedro','',0,0,0,$etapa,0)";
		$rs=mysql_query($query,$conn);
		if ($rs){
			GLO_feedback(1);$grabook=1;
			//busca pedido de despacho y completa items
			$tipocompletar='items';include ("Includes/zBuscarSolicitud.php");
		}else{GLO_feedback(2);$grabook=0;} 
	}
}else{
	//where
	$wheregral="update procesosop_e1 set IdPadre=$idpadre,Fecha='$fecha',Hora='$hora',Obs='$obs',Rto='$rto',Mot='$mot',Temp=$temp,Olf=$olf";

	//update propio
	if($tipo==1){
		//
		$query="$wheregral,IdChofer=$per,IdUnidad=$uni,IdSemi=$uni2,Km=$km,Retorno=$ret Where Id=$id";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
	//update terceros
	if($tipo==2){
		//
		$query="$wheregral,Chofer='$cho',DNI='$doc',IdMarca=$mar,IdCateg=$cat,Modelo='$mod',Dominio='$dom',IdMarca2=$mar2,IdCateg2=$cat2,Modelo2='$mod2',Dominio2='$dom2',IdProv=$prov,IdCli=$cli,Chk1=$chk1,Chk2=$chk2,ChkU1=$chku1,ChkU2=$chku2,ChkU3=$chku3,ChkS1=$chks1,ChkS2=$chks2,ChkS3=$chks3,ChkC1=$chkc1,ChkC2=$chkc2,FU1='$fu1',FU2='$fu2',FU3='$fu3',FS1='$fs1',FS2='$fs2',FS3='$fs3',FC1='$fc1',FC2='$fc2',Sedro='$sedro' Where Id=$id";
		$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
}



?>