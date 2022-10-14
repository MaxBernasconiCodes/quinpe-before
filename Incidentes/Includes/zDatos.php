<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$fa=GLO_FechaMySql($_POST['TxtFechaA']);	
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}

//estado  (id0=pdte)
$est=0;if($_POST['CbEstado']==2){$est=1;}

		
$sec=intval($_POST['CbSector']);
$yac=intval($_POST['CbYac']);

$per=intval($_POST['CbPersonal']);

$c1=intval($_POST['ChkC1']);
$c2=intval($_POST['ChkC2']);
$c3=intval($_POST['ChkC3']);
$c4=intval($_POST['ChkC4']);
$c5=intval($_POST['ChkC5']);

$t1=intval($_POST['Chk1']);
$t2=intval($_POST['Chk2']);

$obs=mysql_real_escape_string($_POST['TxtObs']);
$obs1=mysql_real_escape_string($_POST['TxtObs1']);
$obs2=mysql_real_escape_string($_POST['TxtObs2']);
$obs3=mysql_real_escape_string($_POST['TxtObs3']);
$obs4=mysql_real_escape_string($_POST['TxtObs4']);

$id=intval($_POST['TxtNumero']);

?>