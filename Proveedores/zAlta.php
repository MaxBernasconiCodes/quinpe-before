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
		GLO_feedback(4);header("Location:Alta.php");
	}else{
		//verifica campos requeridos
		if (empty($_POST['TxtApellido'])){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include ("Includes/zDatosU.php");
			//query
			$nroId=GLO_generoID('proveedores',$conn);
			$query="INSERT INTO proveedores (Id,FechaAlta,FechaBaja,TipoIdentificacion,Identificacion,Nombre,Apellido,Direccion,IdLocalidad,Provincia,CP,EMail,IdActividad,Observaciones,Tipo,IdIva,Critico,Evaluar,PW,PC,PCC) VALUES ($nroId,'$fechaa','$fechab','$tcuit','$cuit','$nom','$ap','$dir',$idloc,'$pcia','$cp','$mail',$act,'$obs',$tipo,$iva,$cri,$eva,'$pw','$pc','$pcc')"; 
			$rs=mysql_query($query,$conn);
			if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; }
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Razon Social y CUIT no esten repetidos';
				header("Location:Alta.php");
			}			
		}		
	}
}







//add y refresh
elseif (isset($_POST['CmdAddLoc'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Localidades/Agregar.php");
}
elseif (isset($_POST['CmdRefreshLoc'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Alta.php");
}
elseif (isset($_POST['CmdAddAct'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../Actividades/Agregar.php");
}
elseif (isset($_POST['CmdRefreshLAct'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Alta.php");
}



else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:".$_SERVER['HTTP_REFERER']);
}
?>