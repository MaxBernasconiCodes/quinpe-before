<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";



//perfiles
GLO_PerfilAcceso(14);



GLO_cambiotablabasica('alta','iso_doc_tipo','ISO_TipoDoc',$_POST['TxtNombre'],0);





?>



