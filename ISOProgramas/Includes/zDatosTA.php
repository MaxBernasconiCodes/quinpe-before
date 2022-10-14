<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

$ident=intval($_POST['TxtNroEntidad']);

$obs=mysql_real_escape_string($_POST['TxtObs']);
$obs2=mysql_real_escape_string($_POST['TxtObs2']);
$obs3=mysql_real_escape_string($_POST['TxtObs3']);
$nom=mysql_real_escape_string($_POST['TxtNombre']);

$cli=intval($_POST['CbCliente']);
$uni=intval($_POST['CbUnidad']);
$per=intval($_POST['CbPersonal']);
$serv=intval($_POST['CbServicio']);

//insert name
$wqi1='';
for ($i=1; $i < 13; $i= $i +1) {$wqi1=$wqi1.",M".$i."P";}
for ($i=1; $i < 13; $i= $i +1) {$wqi1=$wqi1.",M".$i."R";}
for ($i=1; $i < 13; $i= $i +1) {$wqi1=$wqi1.",M".$i."Q";}

//insert value
$wqi2='';
for ($i=1; $i < 25; $i= $i +1) {$wqi2=$wqi2.",0";}
for ($i=1; $i < 13; $i= $i +1) {$wqi2=$wqi2.",''";}
?>