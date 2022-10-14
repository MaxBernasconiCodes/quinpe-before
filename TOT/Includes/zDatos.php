<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$fa=GLO_FechaMySql($_POST['TxtFechaA']);

			

$sec=intval($_POST['CbSector']);

$ctro=intval($_POST['CbCentro']);

$per=intval($_POST['CbPersonal']);

$per2=intval($_POST['CbPersonal2']);

$cli=intval($_POST['CbCliente']);

$cat=intval($_POST['CbCateg']);//Cat





$o1=intval($_POST['Opt1']);//si:1,no:0

$o2=intval($_POST['Opt2']);//si:1,no:0

$o3=intval($_POST['Opt3']);//estado abierto:0,cerrado:1



$obs3=mysql_real_escape_string($_POST['TxtObs3']);//AccionR

$obs4=mysql_real_escape_string($_POST['TxtObs4']);//Cons

$obs5=mysql_real_escape_string($_POST['TxtObs5']);//AccionCP



$id=intval($_POST['TxtNumero']);



?>