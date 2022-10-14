<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbTipoC']))  or (empty($_POST['CbCliente'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$int=mysql_real_escape_string($_POST['OptTipoI']);	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);};
		$tipoc=intval($_POST['CbTipoContrato']); 
		//update
		$query="UPDATE servicios set Interno='$int',FechaBaja='$fechab',IdTipoContrato=$tipoc Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); //cierro la conexion con la db
	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = "";	}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
	
}


elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaI'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From itemscliente_serv Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{$_SESSION['GLO_msgE']="Verifique si el item tiene datos asociados";} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}






//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From servicios_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From servicios_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("servicios_adj",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}






?>

