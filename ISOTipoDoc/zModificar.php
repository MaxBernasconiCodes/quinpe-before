<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);





GLO_cambiotablabasica('modificar','iso_doc_tipo','ISO_TipoDoc',$_POST['TxtNombre'],intval($_POST['TxtNumero']));







?>



