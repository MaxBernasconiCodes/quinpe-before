<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);

if (isset($_POST['CmdAceptar'])){ 
	//valida cuit
	if (!(empty($_POST['TxtCUIT']))){
		$cuit_rearmado="";$cuit_validado=cuitValido($_POST['TxtCUIT'],$cuit_rearmado);$_POST['TxtCUIT']=$cuit_rearmado;
	}else {$cuit_validado=1;}
	if ($cuit_validado==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(4);header("Location:Alta.php");
	}else{
		//verifica campos requeridos
		if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtApellido'])) or (empty($_POST['TxtLegajo'])) or (empty($_POST['TxtDoc'])) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
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
			$grupos='';$alerg='';$foto="";
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$estu=intval($_POST['CbEstudios']);
			$cont=intval($_POST['CbContrato']);
			//query
			$nroId=GLO_generoID('personal',$conn);
			$query="INSERT INTO personal (Id,Legajo,FechaAlta,FechaBaja,TipoIdentificacion,Identificacion,TipoDocumento,Documento,DNITramite,Extranjero,Nacionalidad,Sexo,Nombre,Apellido,FechaNacimiento,LugarNacimiento,EstadoCivil,CargaFamiliar,Direccion,IdLocalidad,Provincia,CP,EMail,ObraSocial,CategoriaOS,Convenio,IdTurno,IdSector,IdFuncion,GrupoSangre,Alergico,Observaciones,Foto,IdART,DireccionL,IdLocalidadL,ProvinciaL,CPL,IdRS,IdEstudios,IdCateg,IdContrato,FinContrato) VALUES ($nroId,$legajo,'$fechaa','$fechab','$tcuit','$cuit','$tdoc','$doc','$dnitr',$ext,'$nac','$gen','$nom','$ap','$fecha','$lnac','$ec',$carga,'$dir',$idloc,'$pcia','$cp','$mail','$obrasoc','$catos','$conv',$turno,$sector,$funcion,'$grupos','$alerg','$obs','$foto',$art,'$dirl',$idlocl,'$pcial','$cpl',$rsoc,$estu,$catf,$cont,'$fechafc')"; 	
			$rs=mysql_query($query,$conn);
			if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Legajo no este repetido';
				header("Location:Alta.php");
			}			
		}		
	}
}


elseif (isset($_POST['CmdAddLoc'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Localidades/Agregar.php");
}

elseif (isset($_POST['CmdRefreshLoc'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Alta.php");
}


elseif (isset($_POST['CmdAddART'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../ART/Agregar.php");
}

elseif (isset($_POST['CmdRefreshART'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Alta.php");
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
	header("Location:".$_SERVER['HTTP_REFERER']);
}

?>

