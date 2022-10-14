<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbTipoCertif'])) or (empty($_POST['CbInstrumento'])) or (empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarCE.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		if($fechab=="0000-00-00"){$estado=1;}else{$estado=2;}	
		$ins=intval($_POST['CbInstrumento']); 
		$cer=intval($_POST['CbTipoCertif']); 
		$certif=mysql_real_escape_string($_POST['TxtCertif']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$inac=intval($_POST['ChkInactivo']);
		$id=intval($_POST['TxtNumero']);
		$query="UPDATE accesorios_prog set IdTipoCertif=$cer,FechaProg='$fechaa',FechaReal='$fechab',IdEstado=$estado,Certificado='$certif',Obs='$obs',Inactivo=$inac Where Id=$id";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarCE.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}


//foto
elseif (isset($_POST['CmdBorrarArchivoH'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//busco path
	$archivo=mysql_real_escape_string($_POST['TxtArchivo']);
	//elimino
	$query="UPDATE accesorios_prog set Ruta='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);unlink('../Archivos/Accesorios/'.$archivo) ;}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarCE.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdArchivoH'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:ArchivoHCE.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerFile2'])){
	GLO_OpenFile("accesorios_prog",intval($_POST['TxtNumero']),"Accesorios/","Ruta");
}




//archivos adjuntos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoAdjuntoCE.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From accesorios_prog_a Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From accesorios_prog_a Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Accesorios/'.$archivo) ;} 
	mysql_close($conn); 	
	header("Location:ModificarCE.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("accesorios_prog_a",intval($_POST['TxtId']),"Accesorios/","Ruta");
}



elseif ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	//vuelvo
	if(intval($_SESSION['TxtOriACCCertif'])==0){header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}
	else{header("Location:Certificaciones.php");}
}





?>


