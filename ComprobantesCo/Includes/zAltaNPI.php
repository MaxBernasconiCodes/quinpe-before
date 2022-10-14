<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//inserta item nota pedido
$nroId=GLO_generoID("co_npedido_it",$conn);
$query="INSERT INTO co_npedido_it (Id,IdNP,IdArticulo,IdItem,Cant,CantAuto,IdProv,IdEstado,Obs,FechaAuto,FechaPAuto,FechaComprar,INC,NroOC) VALUES ($nroId,$ident,$iditem,$iditem2,$cant,$canta,$prov,$est,'$obs','$fa','$fpa','$fcom',$finc,'')";
$rs=mysql_query($query,$conn);



?>