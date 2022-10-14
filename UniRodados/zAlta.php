<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



GLO_cambiotablabasica('alta','unidadesrodados','UniRodados',$_POST['TxtNombre'],0);





?>



