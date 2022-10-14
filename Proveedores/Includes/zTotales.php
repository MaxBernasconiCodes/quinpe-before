<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//totales
$t1= $row['E1']+$row['E2']+$row['E3']+$row['E4']+$row['E5']+$row['E6']+$row['E7']+$row['E8'];
$t2=$row['E9']+$row['E10']+$row['E11']+$row['E12'];
$t3=$t1+$t2;
?>