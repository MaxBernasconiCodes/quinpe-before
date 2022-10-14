<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios y terceros vehiculo

//generales
$id=intval($_POST['TxtNumero']);//id procesosop_e1
$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
$tipo=intval($_POST['CbTipo']);
$obs=mysql_real_escape_string($_POST['TxtObs']);
$temp=floatval($_POST['TxtTemp']);
$olf=intval($_POST['CbOlf']);
$mot=mysql_real_escape_string($_POST['TxtMotivo']);
$rto=mysql_real_escape_string($_POST['TxtRto']);
$idpadre=intval($_POST['TxtNroEntidad']);//proceso
//where
$wheregral="update procesosop_e1 set IdPadre=$idpadre,Fecha='$fecha',Hora='$hora',Obs='$obs',Rto='$rto',Mot='$mot',Temp=$temp,Olf=$olf";


//update propio
if($tipo==1){
	$per=intval($_POST['CbPersonal']);
	$uni=intval($_POST['CbUnidad']);
	$uni2=intval($_POST['CbUnidad2']);
	$km=intval($_POST['TxtKm']); 
	$ret=intval($_POST['ChkRE']);
	//
	$query="$wheregral,IdChofer=$per,IdUnidad=$uni,IdSemi=$uni2,Km=$km,Retorno=$ret Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

}
//update terceros
if($tipo==2){
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
	//
	$query="$wheregral,Chofer='$cho',DNI='$doc',IdMarca=$mar,IdCateg=$cat,Modelo='$mod',Dominio='$dom',IdMarca2=$mar2,IdCateg2=$cat2,Modelo2='$mod2',Dominio2='$dom2',IdProv=$prov,IdCli=$cli,Chk1=$chk1,Chk2=$chk2,ChkU1=$chku1,ChkU2=$chku2,ChkU3=$chku3,ChkS1=$chks1,ChkS2=$chks2,ChkS3=$chks3,ChkC1=$chkc1,ChkC2=$chkc2,FU1='$fu1',FU2='$fu2',FU3='$fu3',FS1='$fs1',FS2='$fs2',FS3='$fs3',FC1='$fc1',FC2='$fc2',Sedro='$sedro' Where Id=$id";
	$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
}

?>