<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

$ident=intval($_POST['TxtNroEntidad']);
$id=intval($_POST['TxtNumero']);

$fechaa=GLO_FechaMySql($_POST['TxtFecha']);	

$per=intval($_POST['CbPersonal']);
$km1=intval($_POST['TxtKm1']);
$cant=intval($_POST['TxtCant']);
$marca=intval($_POST['CbMarca']);
$ali=intval($_POST['ChkI1']);
$bal=intval($_POST['ChkI2']);
$km2=intval($_POST['TxtKm2']);

$med=mysql_real_escape_string($_POST['TxtMed']);
$ubir=mysql_real_escape_string($_POST['TxtUbic']);
$obs=mysql_real_escape_string($_POST['TxtObs']);


?>