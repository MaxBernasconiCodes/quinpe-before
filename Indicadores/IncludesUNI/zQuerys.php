<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=9){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//totales cantidad
$queryac="Select count(a.Id) as valor, $groupcol as grupo From unidades a $grouptable Where a.Id<>0 $groupjoin $wsec $wafe $wherecomun  Group by $groupcol";



?>