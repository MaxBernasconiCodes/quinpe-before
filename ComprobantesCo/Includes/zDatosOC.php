<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}

$prov=intval($_POST['CbProv']);		

$obs=mysql_real_escape_string($_POST['TxtObs']);

$eje=intval($_POST['CbEje']);	

$auto=intval($_POST['CbAuto']);	

$efe=intval($_POST['ChkEfe']);	

$che=intval($_POST['ChkChe']);	

$cc=intval($_POST['ChkCC']);

$tran=intval($_POST['ChkTran']);	

$trand=intval($_POST['ChkTranD']);		

$f1=intval($_POST['ChkF1']);	

$rem=intval($_POST['ChkRem']);	

$tefe=mysql_real_escape_string($_POST['TxtEfe']);

$tche=mysql_real_escape_string($_POST['TxtChe']);

$tf1=mysql_real_escape_string($_POST['TxtF1']);

$trem=mysql_real_escape_string($_POST['TxtRem']);	

$nrooc=intval($_POST['TxtNro']);

$id=intval($_POST['TxtNumero']);





?>