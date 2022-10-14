<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or empty($_POST['CbInstrumento']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}
	else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$tipocambio=2;//update
		include ("Includes/zDatos.php"); 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}



//foto
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//busco path
	$archivo=mysql_real_escape_string($_POST['TxtFoto']);
	//elimino
	$query="UPDATE accesorios set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);unlink('../Archivos/Accesorios/'.$archivo);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("accesorios",intval($_POST['TxtNumero']),"Accesorios/","Foto");
}
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}


//asignaciones
elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaAsignacion.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaI'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From accesorios_asig Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdAddCE'])){
	header("Location:AltaCE.php?Id=".intval($_POST['TxtNumero']));//pasa el nro de accesorios
}

elseif (isset($_POST['CmdBorrarFilaCE'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From accesorios_prog Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}




?>


