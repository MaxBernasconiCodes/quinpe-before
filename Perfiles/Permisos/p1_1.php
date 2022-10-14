<? 

// personal
//solo rrhh(3) puede dar de alta y ver legajo
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
?>