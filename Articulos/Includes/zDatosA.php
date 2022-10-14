<? //perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$ident=intval($_POST['TxtNroEntidad']);//instrumento (id epparticulos)
$idinstr=intval($_POST['CbInstrumento']);//instrumento (id epparticulos)
//
$id=intval($_POST['TxtNumero']);//asignacion
$pers=intval($_POST['CbPersonal']);
$uni=intval($_POST['CbUnidad']);
$sec=intval($_POST['CbSector']);
//
$obs=mysql_real_escape_string($_POST['TxtObs']);
$ti=intval($_POST['ChkReq']);//tiempo indefinido

//fecha desde, si es vacio le asigno hoy
$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
$fechae=GLO_FechaMySql($_POST['TxtFechaE']);

//valido fechas
$fechasok=1;
?>