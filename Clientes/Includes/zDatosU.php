<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


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
$vend=mysql_real_escape_string($_POST['TxtObs2']);//vendedor

$idloc=intval($_POST['CbLocalidad']); 
$act=intval($_POST['CbActividad']);
$iva=intval($_POST['CbIva']);
$cve=intval($_POST['CbCV']);//cond vta
$cco=intval($_POST['CbCC']);//cuenta
$gru=intval($_POST['CbGrupo']);//grupo
$lis=intval($_POST['CbLista']);//lista
$cod=intval($_POST['TxtCodigo']);//codigo

$id=intval($_POST['TxtNumero']);
?>