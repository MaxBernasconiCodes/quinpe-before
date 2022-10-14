<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdAceptar'])){ 
	if (empty($_POST['TxtNombre'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$id=intval($_POST['TxtNumero']);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$ori=mysql_real_escape_string(ltrim($_POST['CbOrigen']));
		$sec=intval($_POST['CbSector']);
		$query="UPDATE iso_anexos set Nombre='$nom', Origen='$ori',IdSector=$sec Where Id=$id"; $rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 			
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}		
	
}


elseif (isset($_POST['CmdVerFile'])){ 
	GLO_OpenFile("iso_anexos",intval($_POST['TxtNumero']),"SGIDoc/Anexos/","Ruta");
}


elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}




?>


