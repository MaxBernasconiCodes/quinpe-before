<? 
//seguridad includes

//valida seguridad
include("Seguridad.php");


//valida que no acceda via url
if ( empty($_SESSION["GLO_SeguridadIncludes"]) ) {
	header('Location:'.'http://' . $_SERVER['HTTP_HOST'] . '/Intranet/Index.php');   
	session_destroy(); // destruyo la sesion
	exit();//ademas salgo de este script   
}

?>
