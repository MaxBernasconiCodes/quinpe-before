<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$titulo=mysql_real_escape_string($_POST['TxtTitulo']);
	$stitulo=mysql_real_escape_string($_POST['TxtSTitulo']);
	$texto=mysql_real_escape_string($_POST['TxtTexto']);  
	$urg=intval($_POST['ChkUrg']);	    
	$query="UPDATE noticias set Titulo='$titulo', Subtitulo='$stitulo', Texto='$texto',Urgente=$urg Where Id=1"; 
	$rs=mysql_query($query,$conn);mysql_close($conn); 		
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 	
	header("Location:../Noticias.php");
}		


//foto 
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("noticias",intval($_POST['TxtNumero']),"Fotos/","Ruta");
}
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//busco path
	$archivo=mysql_real_escape_string($_POST['TxtFoto']);
	//elimino
	$query="UPDATE noticias set Ruta='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){
		GLO_feedback(1);
		if (file_exists('../Archivos/Fotos/'.$archivo)){unlink('../Archivos/Fotos/'.$archivo);}
	}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:../Noticias.php");
}

?>


