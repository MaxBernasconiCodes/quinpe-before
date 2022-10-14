<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios y terceros persona

//generales
$id=intval($_POST['TxtNumero']);//id procesosop_e2
$fecha=GLO_FechaMySql($_POST['TxtFechaA']);
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
$tipo=intval($_POST['CbTipo']);//1:propio, 2:terceros
$obs=mysql_real_escape_string($_POST['TxtObs']);
$temp=floatval($_POST['TxtTemp']);
$olf=intval($_POST['CbOlf']);
$idpadre=intval($_POST['TxtNroEntidad']);//proceso
//where
$wheregral="update procesosop_e2 set IdPadre=$idpadre,Tipo=$tipo,Fecha='$fecha',Hora='$hora',Obs='$obs',Temp=$temp,Olf=$olf";


//update propio
if($tipo==1){
	$per=intval($_POST['CbPersonal']);
	//
	$query="$wheregral,IdChofer=$per Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

}
//update terceros
if($tipo==2){
	$prov=intval($_POST['CbProv']); 
	$cli=intval($_POST['CbCliente']);
	$cho=mysql_real_escape_string($_POST['TxtChofer']);
	$doc=mysql_real_escape_string($_POST['TxtDoc']);
	//
	$query="$wheregral,Chofer='$cho',DNI='$doc',IdProv=$prov,IdCli=$cli Where Id=$id";
	$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
}

?>