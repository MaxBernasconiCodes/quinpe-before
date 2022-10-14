<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


$tipoie=intval($_POST['OptTipo']); 
$tipo=intval($_POST['CbTipo']);
$sec=intval($_POST['CbSector']);
$yac=intval($_POST['CbYac']);
$inst=0;
$ctro=0;
$anul=intval($_POST['ChkAnul']);

if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}
else{
	$fecha=$_POST['TxtFechaA']; list($d,$m,$a)=explode("-",$fecha);$primerdiames="01-".$m."-".$a;
	$fecha=date("d-m-Y", strtotime("$primerdiames +1 month"));$fecha=date("d-m-Y", strtotime("$fecha -1 day"));
	$fechaa=FechaMySql($fecha);
}	


if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
if (empty($_POST['TxtFechaRP'])){$fecharp="0000-00-00";}else{$fecharp=FechaMySql($_POST['TxtFechaRP']);}
if (empty($_POST['TxtHora'])){$hora="00:00:00";}else{$hora=$_POST['TxtHora'];}
if (empty($_POST['TxtHoraD'])){$horad="00:00:00";}else{$horad=$_POST['TxtHoraD'];}
if($fechab=="0000-00-00"){$estado=1;}else{$estado=2;}	


$nom=mysql_real_escape_string($_POST['TxtNombre']);
$alc=mysql_real_escape_string($_POST['TxtAlc']);
$met=mysql_real_escape_string($_POST['TxtMet']);
$res=mysql_real_escape_string($_POST['TxtRes']);
$cri=mysql_real_escape_string($_POST['TxtCri']);
$obs=mysql_real_escape_string($_POST['TxtObs']);

$diri=mysql_real_escape_string($_POST['TxtDir']);
$obj=mysql_real_escape_string($_POST['TxtObj']);			
$op='';
$ap='';
$nc='';
					

$id=intval($_POST['TxtNumero']);
?>