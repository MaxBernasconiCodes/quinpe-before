<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//destino

$destino='';

if($row['IdUnidad']!=0){$destino=$row['Unidad'].' '.$row['Dominio'];}

if($row['IdPersonal']!=0){$destino=$row['ApeD'].' '.$row['NomD'];}

if($row['IdInstr']!=0){$destino=$row['Equipo'];}

if($row['IdSectorM']!=0){$destino=$row['SectorM'];}

?>