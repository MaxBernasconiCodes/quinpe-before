<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$fechaa=FechaMySql(date("d-m-Y"));
if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}


$tcuit="CUIT";
$cuit=mysql_real_escape_string($_POST['TxtCUIT']);
$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
$ap=mysql_real_escape_string(ltrim($_POST['TxtApellido']));			
$dir=mysql_real_escape_string($_POST['TxtDireccion']); 
$pcia=mysql_real_escape_string($_POST['TxtProvincia']); 
$cp=mysql_real_escape_string($_POST['TxtCP']); 
$mail=mysql_real_escape_string(ltrim($_POST['TxtEMail']));
$obs=mysql_real_escape_string($_POST['TxtObs']);
$pw=mysql_real_escape_string($_POST['TxtPagina']);
$pc=mysql_real_escape_string($_POST['TxtContacto']);
$pcc=mysql_real_escape_string($_POST['TxtCargo']);

$idloc=intval($_POST['CbLocalidad']); 
$act=intval($_POST['CbActividad']);
$iva=intval($_POST['CbIva']);
$tipo=intval($_POST['OptTipo']); 
$cri=intval($_POST['ChkC1']); 
$eva=intval($_POST['ChkC2']); 

$id=intval($_POST['TxtNumero']);
?>