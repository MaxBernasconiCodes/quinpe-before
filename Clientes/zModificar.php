<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	//valida cuit
	if (!(empty($_POST['TxtCUIT']))){
		$cuit_rearmado="";$cuit_validado=cuitValido($_POST['TxtCUIT'],$cuit_rearmado);$_POST['TxtCUIT']=$cuit_rearmado;
	}else {$cuit_validado=1;}
	if ($cuit_validado==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(4);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		//verifica campos requeridos
		if (empty($_POST['TxtNombre'])){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
		}else{ 
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include ("Includes/zDatosU.php");
			//update
			$query="UPDATE clientes set FechaBaja='$fechab',Identificacion='$cuit',Nombre='$nom',Apellido='$ap',Direccion='$dir',IdLocalidad=$idloc,Provincia='$pcia',CP='$cp',EMail='$mail',IdActividad=$act,Obs='$obs',IdIva=$iva,IdCta=$cco,IdCV=$cve,IdGrupo=$gru,IdLista=$lis,Cod=$cod,Vendedor='$vend' Where Id=$id";$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}
			else{GLO_feedback(2);$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Razon Social y CUIT no esten repetidos';}  
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}
	}
}


elseif (isset($_POST['CmdAddT'])){
	header("Location:AltaTelefono.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaT'])){
	$query="Delete From clitelefonos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdLinkRow1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarTelefono.php?id=".intval($_POST['TxtId'])."&Flag1=True&identidad=".intval($_POST['TxtNumero']));
}


//cc
elseif (isset($_POST['CmdAddCC'])){
	header("Location:AltaCC.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaCC'])){
	$query="Delete From clicentroscosto Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

//ute
elseif (isset($_POST['CmdAddUTE'])){
	header("Location:AltaUTE.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaUTE'])){
	$query="Delete From cli_utes Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//add y refresh
elseif (isset($_POST['CmdAddLoc'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Localidades/Agregar.php");
}
elseif (isset($_POST['CmdRefreshLoc'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdAddAct'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Actividades/Agregar.php");
}
elseif (isset($_POST['CmdRefreshLAct'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}


//???
elseif (isset($_POST['CmdAddCON'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../Comprobantes/AltaContrato.php?idcli=".intval($_POST['TxtNumero']));//idcli: para saber si vuelvo a clientes o  comprobantes
}


elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../Clientes.php");
}



else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}

?>