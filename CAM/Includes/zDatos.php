<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

$fa=GLO_FechaMySql($_POST['TxtFechaA']);
$fv=GLO_FechaMySql($_POST['TxtFechaV']);
$fvl=GLO_FechaMySql($_POST['TxtFechaC']);
$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro

			
$prod=intval($_POST['CbProducto']);
$cli=intval($_POST['CbCliente']);
$est=intval($_POST['CbEstado']);

$lote=mysql_real_escape_string($_POST['TxtLote']);
$rto=mysql_real_escape_string($_POST['TxtRto']);
$oc=mysql_real_escape_string($_POST['TxtNroOC']);

$per=intval($_POST['CbPersonal']);
$obs1=mysql_real_escape_string($_POST['TxtObs1']);
$obs2=mysql_real_escape_string($_POST['TxtObs2']);

$id=intval($_POST['TxtNumero']);

?>