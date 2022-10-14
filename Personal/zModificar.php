<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);

if (isset($_POST['CmdAceptar'])){
	//valida cuit
	if (!(empty($_POST['TxtCUIT']))){
		$cuit_rearmado="";$cuit_validado=cuitValido($_POST['TxtCUIT'],$cuit_rearmado);$_POST['TxtCUIT']=$cuit_rearmado;
	}else {$cuit_validado=1;}
	if ($cuit_validado==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(4);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		//verifica campos requeridos
		if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtApellido'])) or (empty($_POST['TxtLegajo']))  or (empty($_POST['TxtDoc'])) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{ 
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			//grabar los datos en la tabla
			$legajo=intval($_POST['TxtLegajo']); 
			$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);	
			$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
			$fechafc=GLO_FechaMySql($_POST['TxtFechaF']);
			$tcuit=mysql_real_escape_string($_POST['CbCUIT']);
			$cuit=mysql_real_escape_string($_POST['TxtCUIT']);
			$tdoc=mysql_real_escape_string($_POST['CbDocumento']);
			$doc=mysql_real_escape_string($_POST['TxtDoc']);
			$ext=intval($_POST['ChkExtranjero']);
			$dnitr=mysql_real_escape_string($_POST['TxtDNITramite']);
			$nac=mysql_real_escape_string($_POST['TxtNacionalidad']);
			$gen=mysql_real_escape_string($_POST['OptTipoG']);			
			$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
			$ap=mysql_real_escape_string(ltrim($_POST['TxtApellido']));			
			if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);};	
			$lnac=mysql_real_escape_string($_POST['TxtLN']);	
			$ec=mysql_real_escape_string($_POST['CbEC']);
			$carga=intval($_POST['TxtCarga']); 
			$dir=mysql_real_escape_string($_POST['TxtDireccion']); 
			$idloc=intval($_POST['CbLocalidad']); 
			$pcia=mysql_real_escape_string($_POST['TxtProvincia']); 
			$cp=mysql_real_escape_string($_POST['TxtCP']); 
			$dirl=mysql_real_escape_string($_POST['TxtDireccionL']); 
			$idlocl=intval($_POST['CbLocalidadL']); 
			$pcial=mysql_real_escape_string($_POST['TxtProvinciaL']); 
			$cpl=mysql_real_escape_string($_POST['TxtCPL']); 
			$mail=mysql_real_escape_string(ltrim($_POST['TxtEMail']));
			$obrasoc=mysql_real_escape_string($_POST['TxtOSocial']);
			$catos=mysql_real_escape_string($_POST['TxtCatOS']);
			$conv=mysql_real_escape_string($_POST['TxtConv']);
			$turno=intval($_POST['TxtTurno']);
			$sector=intval($_POST['CbSector']);
			$funcion=intval($_POST['TxtFuncion']);
			$catf=intval($_POST['CbCateg']);
			$rsoc=intval($_POST['CbRS']);
			$art=intval($_POST['CbART']);
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$estu=intval($_POST['CbEstudios']);
			$cont=intval($_POST['CbContrato']);
			$id=intval($_POST['TxtNumero']);
			//
			$query="UPDATE personal set Legajo=$legajo,FechaAlta='$fechaa',FechaBaja='$fechab',TipoIdentificacion='$tcuit',Identificacion='$cuit',TipoDocumento='$tdoc',Documento='$doc',DNITramite='$dnitr',Extranjero=$ext,Nacionalidad='$nac',Sexo='$gen',Nombre='$nom',Apellido='$ap',FechaNacimiento='$fecha',LugarNacimiento='$lnac',EstadoCivil='$ec',CargaFamiliar=$carga,Direccion='$dir',IdLocalidad=$idloc,Provincia='$pcia',CP='$cp',EMail='$mail',ObraSocial='$obrasoc',CategoriaOS='$catos',Convenio='$conv',IdTurno=$turno,IdSector=$sector,IdFuncion=$funcion,Observaciones='$obs',IdART=$art,DireccionL='$dirl',IdLocalidadL=$idlocl,ProvinciaL='$pcial',CPL='$cpl',IdRS=$rsoc,IdEstudios=$estu,IdCateg=$catf,IdContrato=$cont,FinContrato='$fechafc' Where Id=$id";$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}
			else{GLO_feedback(2);$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Legajo no este repetido';} 
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}		
	}
}


//foto
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="UPDATE personal set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("personal",intval($_POST['TxtNumero']),"Fotos/","Foto");
}





elseif (isset($_POST['CmdRankVial'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:RankingVial.php?id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdCap'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Capacitaciones.php?Id=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdAddAcad'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaAcad.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaAcad'])){
	$query="Delete From personal_acad Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A9');	
}



elseif (isset($_POST['CmdAddLic'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaLic.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaLic'])){
	$query="Delete From personal_lic Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A4');	
}




elseif (isset($_POST['CmdAddEI'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaEI.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaEI'])){
	$query="Delete From personal_expi Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A7');	
}






elseif (isset($_POST['CmdAddAntec'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaAntec.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaAntec'])){
	$query="Delete From personal_antec Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A8');	
}



elseif (isset($_POST['CmdAddCF'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaCF.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaCF'])){
	$query="Delete From personal_cargas Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A5');	
}



elseif (isset($_POST['CmdAddDes'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaDes.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaDes'])){
	$query="Delete From personal_des Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A6');	
}




elseif (isset($_POST['CmdAddT'])){
	header("Location:AltaTelefono.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaT'])){
	$query="Delete From personaltelefonos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A12');	
}



elseif (isset($_POST['CmdAddC'])){
	header("Location:AltaComentario.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaC'])){
	$query="Delete From personalcomentarios Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A10');	
}




elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoPersonal.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From personalarchivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From personalarchivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A11');	
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("personalarchivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}








elseif (isset($_POST['CmdAddVto'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaVto.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaVto'])){
	$query="Delete From personalvtos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A2');	
}



elseif (isset($_POST['CmdAddTalle'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaTalle.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaTalle'])){
	$query="Delete From personaltalles Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}





/*
elseif (isset($_POST[CmdFoto])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:Foto.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST[CmdVerFoto])){
	GLO_OpenFile("personal",intval($_POST['TxtNumero']),"Fotos/","Foto");
}
*/





elseif (isset($_POST['CmdAddLoc'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Localidades/Agregar.php");
}

elseif (isset($_POST['CmdRefreshLoc'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdAddART'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../ART/Agregar.php");
}

elseif (isset($_POST['CmdRefreshART'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
}





else{ //Click en combo localidad:muestra la provincia y el cp
	$Provincia="";$CP="";$valor=intval($_POST['CbLocalidad']);
	$Provincial="";$CPl="";$valorl=intval($_POST['CbLocalidadL']);
	//consulto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT p.*,l.CP  From provincias p, localidades l Where l.IdPcia=p.Id and l.Id= $valor";$rs=mysql_query($query,$conn);	
	$row=mysql_fetch_array($rs);$Provincia=$row['Nombre'];$CP=$row['CP'];mysql_free_result($rs);
	$query="SELECT p.*,l.CP  From provincias p, localidades l Where l.IdPcia=p.Id and l.Id= $valorl";$rs=mysql_query($query,$conn);	
	$row=mysql_fetch_array($rs);$Provincial=$row['Nombre'];$CPl=$row['CP'];	mysql_free_result($rs);
	mysql_close($conn); 
	//obtener datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtProvincia']=$Provincia;$_SESSION['TxtCP']=$CP;$_SESSION['TxtProvinciaL']=$Provincial;$_SESSION['TxtCPL']=$CPl;
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
}

?>


