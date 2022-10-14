<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$nro=intval($_POST['TxtNro']); 

$uni=intval($_POST['CbUnidad']); 

$ubi=intval($_POST['TxtUbic']);

$prod=intval($_POST['CbProd']); 

$cap=floatval($_POST['TxtCap']); 

$op1=mysql_real_escape_string($_POST['OptA1']);

$op2=mysql_real_escape_string($_POST['OptA2']);

$op3=mysql_real_escape_string($_POST['OptA3']);

$op4=mysql_real_escape_string($_POST['OptA4']);

$op5=mysql_real_escape_string($_POST['OptA5']);

if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	

if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}	

$obs=mysql_real_escape_string($_POST['TxtObs']);

$baja=intval($_POST['ChkBaja']); 

$id=intval($_POST['TxtNumero']);

?>