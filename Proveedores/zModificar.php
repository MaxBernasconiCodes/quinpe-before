<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


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
		if (empty($_POST['TxtApellido'])){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
		}else{ 
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include ("Includes/zDatosU.php");
			//update
			$query="UPDATE proveedores set FechaBaja='$fechab',Identificacion='$cuit',Nombre='$nom',Apellido='$ap',Direccion='$dir',IdLocalidad=$idloc,Provincia='$pcia',CP='$cp',EMail='$mail',IdActividad=$act,Observaciones='$obs',Tipo=$tipo,IdIva=$iva,Critico=$cri,Evaluar=$eva,PW='$pw',PC='$pc',PCC='$pcc' Where Id=$id";
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}
			else{GLO_feedback(2);$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Razon Social y CUIT no esten repetidos';}  
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}
	}
}


//telefonos
elseif (isset($_POST['CmdAddT'])){
	header("Location:AltaTelefono.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaT'])){
	$query="Delete From provtelefonos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdLinkRow1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarTelefono.php?id=".intval($_POST['TxtId'])."&Flag1=True&identidad=".intval($_POST['TxtNumero']));
}



//desempeo
elseif (isset($_POST['CmdLinkRow2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarDes.php?gidf=1&gid=".intval($_POST['TxtId']));
}
elseif (isset($_POST['CmdAddDes'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaDes.php?gid=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaDes'])){
	$query="Delete From proveedores_des Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}



//adjuntos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From proveedores_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From proveedores_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Prov/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("proveedores_adj",intval($_POST['TxtId']),"Prov/","Ruta");
}




//otras actividades
elseif (isset($_POST['CmdAddOACT'])){
	header("Location:AltaOACT.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaOACT'])){
	$query="Delete From proveedores_act Where Id=".intval($_POST['TxtId']);
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


else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}

?>