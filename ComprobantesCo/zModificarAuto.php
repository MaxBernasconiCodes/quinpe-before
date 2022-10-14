<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");   $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar']))
{
	if ( (empty($_POST['CbSector'])) or (empty($_POST['TxtFechaA'])) or (empty($_POST['OptTipo']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarAuto.php?id=".intval($_POST['TxtNumero']));
	}
	else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$sec=intval($_POST['CbSector']);	
		$tipo=intval($_POST['OptTipo']);	
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		//update
		$query="UPDATE co_autorizantes set IdSector=$sec,FechaA='$fechaa',FechaB='$fechab',Tipo=$tipo Where Id=".intval($_POST['TxtNumero']);	$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);} 	
		mysql_close($conn); 	
		//vuelvo
		foreach($_POST as $key => $value){$_SESSION[$key] = "";	}
		header("Location:Autorizantes.php");
	}		
	
}


elseif (isset($_POST['CmdArchivoH'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:ArchivoH.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerArchivoH'])){
	GLO_OpenFile("co_autorizantes",intval($_POST['TxtNumero']),"Comprobantes/","Ruta");
}
elseif (isset($_POST['CmdBorrarArchivoH'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="UPDATE co_autorizantes set Ruta='' Where Id=".intval($_POST['TxtNumero']);	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarAuto.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Autorizantes.php");
}





?>

