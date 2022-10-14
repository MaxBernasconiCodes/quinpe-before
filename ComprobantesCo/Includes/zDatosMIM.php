<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}

$ctro=intval($_POST['CbCentro']); 	

$obs=mysql_real_escape_string($_POST['TxtObs']);

$id=intval($_POST['TxtNumero']);

$c1=intval($_POST['ChkI1']);

$c2=intval($_POST['ChkI2']);

$c3=intval($_POST['ChkI3']);

$c4=intval($_POST['ChkI4']);



?>