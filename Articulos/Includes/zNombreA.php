<? //perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//se asigno a personal, unidad o sector?
$nomasignado='';
if($row['IdPersonal']!=0){$nomasignado=$row['Ape'].' '.$row['Nom'];}
if($row['IdUnidad']!=0){$nomasignado=$row['Uni'].' '.$row['Dominio'];}
if($row['IdSectorM']!=0){$nomasignado=$row['Sector'];}

?>