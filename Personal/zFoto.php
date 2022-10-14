<?php

include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";

//perfiles
include("../Perfiles/Permisos/p1.php");



//abro conn

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



//variables

$idpersonal=intval($_SESSION['TxtNroEntFoto']);



//genero nombre	 archivo	

$foto='P'.$idpersonal.'.jpg';

$filename = '../Archivos/Fotos/'.$foto;

$result = file_put_contents( $filename, file_get_contents('php://input') );

if (!$result) {

	print "ERROR: No se pudo grabar el archivo\n";

	exit();

}



//grabo archivo

$query="UPDATE personal set Foto='$foto' Where Id=$idpersonal"; $rs=mysql_query($query,$conn);



//cierro conn

mysql_close($conn);





$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;

print "$url\n"; 



?>

