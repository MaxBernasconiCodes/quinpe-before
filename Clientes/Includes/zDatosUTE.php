<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$ident=intval($_POST['TxtNroEntidad']);
$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
//
$cuit=mysql_real_escape_string($_POST['TxtCUIT']);
$iva=intval($_POST['CbIva']);
//
$dir=mysql_real_escape_string($_POST['TxtDir']);
$loc=intval($_POST['CbLocalidad']);
?>