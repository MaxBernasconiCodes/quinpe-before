<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

//obtengo file
$extension= $_FILES['archivo']['name'];$extension = explode(".",$extension);
$num = count($extension)-1;$extension2=$extension[$num];

?>