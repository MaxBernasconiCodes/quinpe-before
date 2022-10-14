<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or empty($_POST['CbTipo']) or  empty($_POST['CbUnidad'])  ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatos.php");
		//update
		$query="UPDATE epparticulos set Nombre='$nombre',IdRubro=$rubro,IdMarca=$marca,IdUnidad=$unidad,Obs='$obs',Modelo='$modelo',Frecuencia=$frec,EPP=$epp,FechaBaja='$fechab',Stock=$stock ,NSE='$nse',FechaV='$fechav',TAG='$tag',Rango1='$ran1',Rango2='$ran2',UnidadM=$unm,TipoC=$verif Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(18);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}		
	
}



//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From epparticulos_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From epparticulos_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Articulos/'.$archivo) ;}
	mysql_close($conn); 	
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("epparticulos_adj",intval($_POST['TxtId']),"Articulos/","Ruta");
}

//foto
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//busco path
	$archivo=mysql_real_escape_string($_POST['TxtFoto']);
	//elimino
	$query="UPDATE epparticulos set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);unlink('../Archivos/Articulos/Fotos/'.$archivo) ;}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("epparticulos",intval($_POST['TxtNumero']),"Articulos/Fotos/","Foto");
}
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Foto.php?Id=".intval($_POST['TxtNumero']));
}


//asignaciones
elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaAsignacion.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaI'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From instrumentosasig Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


//certificaciones
elseif (isset($_POST['CmdAddCE'])){
	header("Location:AltaCE.php?Id=".intval($_POST['TxtNumero']));//pasa el nro de instrumento
}
elseif (isset($_POST['CmdBorrarFilaCE'])){	
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	//busco si tiene Foto
	$query="SELECT Ruta From instrumentosprog Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	if($archivo==''){
		$query="Delete From instrumentosprog Where Ruta='' and Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(31);} 
	}else{GLO_feedback(31);}
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

//add y refresh
elseif (isset($_POST['CmdAddMar'])){
	header("Location:../Marcas/Agregar.php");
}
elseif (isset($_POST['CmdRefreshMar'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}








?>

