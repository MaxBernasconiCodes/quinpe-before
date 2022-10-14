<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));

$tipo=intval($_POST['CbTipo']);

$frec=intval($_POST['CbFrec']);

$resp=intval($_POST['CbResp']);		

$id=intval($_POST['TxtNumero']);



?>



