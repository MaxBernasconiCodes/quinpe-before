<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$idprov=intval($_POST['TxtNroEntidad']);
$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
$p1=intval($_POST['CbPersonal1']);
$p2=intval($_POST['CbPersonal2']);

$e1=floatval($_POST['CbEP1']);
$e2=floatval($_POST['CbEP2']);	
$e3=floatval($_POST['CbEP3']);	
$e4=floatval($_POST['CbEP4']);	
$e5=floatval($_POST['CbEP5']);	
$e6=floatval($_POST['CbEP6']);
$e7=floatval($_POST['CbEP7']);
$e8=floatval($_POST['CbEP8']);	
$e9=floatval($_POST['CbEP9']);	
$e10=floatval($_POST['CbEP10']);	
$e11=floatval($_POST['CbEP11']);	
$e12=floatval($_POST['CbEP12']);	


$i1=mysql_real_escape_string($_POST['TxtI1']);
$i2=mysql_real_escape_string($_POST['TxtI2']);
$i3=mysql_real_escape_string($_POST['TxtI3']);
$i4=mysql_real_escape_string($_POST['TxtI4']);
$i5=mysql_real_escape_string($_POST['TxtI5']);
$i6=mysql_real_escape_string($_POST['TxtI6']);
$i7=mysql_real_escape_string($_POST['TxtI7']);
$i8=mysql_real_escape_string($_POST['TxtI8']);
$i9=mysql_real_escape_string($_POST['TxtI9']);
$i10=mysql_real_escape_string($_POST['TxtI10']);
$i11=mysql_real_escape_string($_POST['TxtI11']);
$i12=mysql_real_escape_string($_POST['TxtI12']);
?>