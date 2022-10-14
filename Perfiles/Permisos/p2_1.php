<? 


// iso matriz legal
//sgi externo limitado(15) solo ve matriz legal
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=10 and $_SESSION["IdPerfilUser"]!=11 and  $_SESSION["IdPerfilUser"]!=14 and  $_SESSION["IdPerfilUser"]!=15){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
?>