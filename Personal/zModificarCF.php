<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){
	if (!(empty($_POST['TxtCUIT']))){
		$cuit_rearmado="";$cuit_validado=cuitValido($_POST['TxtCUIT'],$cuit_rearmado);$_POST['TxtCUIT']=$cuit_rearmado;
	}else {$cuit_validado=1;}
	if ($cuit_validado==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(4);header("Location:ModificarCF.php?id=".intval($_POST['TxtNumero']));
	}else{
		if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtApellido'])) or (empty($_POST['TxtFechaA']))){
			foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
			GLO_feedback(3);header("Location:ModificarCF.php?id=".intval($_POST['TxtNumero']));
		}else{
			//grabar los datos en la tabla
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$ident=intval($_POST['TxtNroEntidad']);
			$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
			$ap=mysql_real_escape_string(ltrim($_POST['TxtApellido']));			
			$cuit=mysql_real_escape_string($_POST['TxtCUIT']);
			if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
			if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}	
			$gan=intval($_POST['ChkGan']);	
			$tipo=intval($_POST['CbTipo']);	
			//actualizo
			$query="UPDATE personal_cargas set Apellido='$ap',Nombre='$nom',CUIL='$cuit',FechaD='$fechaa',FechaH='$fechab',IIGG=$gan,IdTipo=$tipo Where Id=".intval($_POST['TxtNumero']);
			$rs=mysql_query($query,$conn);
			mysql_close($conn); 	
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
		}
	}
}






elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
}


?>


