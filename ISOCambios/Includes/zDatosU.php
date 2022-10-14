<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}
if (empty($_POST['TxtFechaE'])){$fechae="0000-00-00";}else{$fechae=FechaMySql($_POST['TxtFechaE']);}
if (empty($_POST['TxtFechaR'])){$fechar="0000-00-00";}else{$fechar=FechaMySql($_POST['TxtFechaR']);}

$nom=mysql_real_escape_string($_POST['TxtNombre']);	
$raz=mysql_real_escape_string($_POST['TxtRazon']);	
$req=mysql_real_escape_string($_POST['TxtReq']);	
$obs=mysql_real_escape_string($_POST['TxtObs']);	
$obs2=mysql_real_escape_string($_POST['TxtObs2']);	

$per=intval($_POST['CbPersonal']);
$res=intval($_POST['CbRes']);
$est=intval($_POST['CbEstado']);
$prio=intval($_POST['CbPrio']);

$id=intval($_POST['TxtNumero']);
?>