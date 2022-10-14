<? 

// barrera
//perfil barrera(16) solo ve barrera
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=16){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
?>