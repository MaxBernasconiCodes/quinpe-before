<? include("Seguridad.php") ;

if (file_exists($_GET['id'])){
	header('Content-Type: application/octet-stream');
	readfile($_GET['id']);
}else{$_SESSION["NivelArbol"]="../";header("Location:Logout.php");}
?>