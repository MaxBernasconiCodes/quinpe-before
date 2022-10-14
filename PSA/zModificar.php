<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	//verifica campos requeridos
	if (empty($_POST['TxtNro']) or empty($_POST['CbTipo']) or empty($_POST['CbAseg']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		$nro=intval($_POST['TxtNro']); 
		$tipo=intval($_POST['CbTipo']);
		$aseg=intval($_POST['CbAseg']);		
		$id=intval($_POST['TxtNumero']);
		$query="UPDATE polizassegauto set Nro=$nro,IdTipo=$tipo,IdAseg=$aseg,FechaI='$fechaa',FechaF='$fechab' Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}


elseif (isset($_POST['CmdAddC'])){
	header("Location:AltaComentario.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaC'])){
	$query="Delete From polizas_com Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From polizas_arch Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From polizas_arch Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("polizas_arch",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}





elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSA.php");
}



?>


