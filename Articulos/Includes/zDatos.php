<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
$fechav=GLO_FechaMySql($_POST['TxtFechaV']);

$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
$obs=mysql_real_escape_string($_POST['TxtObs']);
$modelo=mysql_real_escape_string($_POST['TxtModelo']);
$nse=mysql_real_escape_string(ltrim($_POST['TxtNSE']));

$marca=intval($_POST['CbMarca']);
$rubro=intval($_POST['CbRubro']);
$unidad=intval($_POST['CbUnidad']);
$frec=intval($_POST['TxtFrec']);
$epp=intval($_POST['CbTipo']);
$stock=intval($_POST['ChkReq']);
//
$tag=mysql_real_escape_string($_POST['TxtTAG']);
$unm=intval($_POST['CbUnM']); 
$verif=intval($_POST['CbTipoC']);
$ran1=mysql_real_escape_string($_POST['TxtRango1']);
$ran2=mysql_real_escape_string($_POST['TxtRango2']);
?>