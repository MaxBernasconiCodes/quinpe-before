<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=13 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) or (empty($_POST['CbPcia'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$cp=mysql_real_escape_string($_POST['TxtCP']);
		$pcia=intval($_POST['CbPcia']); 		
		$query="UPDATE localidades set Nombre='".$nombre."' ,CP='".$cp."' ,IdPcia=".$pcia."  Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); //cierro la conexion con la db
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = "";	}
		header("Location:../Localidades.php");
	}		
	
}

//add y refresh
elseif (isset($_POST['CmdAddProv'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Provincias/Agregar.php");
}
elseif (isset($_POST['CmdRefreshProv'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}



?>

