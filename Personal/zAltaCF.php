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
		GLO_feedback(4);header("Location:AltaCF.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtApellido'])) or (empty($_POST['TxtFechaA']))){
			foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
			GLO_feedback(3);header("Location:AltaCF.php?Id=".intval($_POST['TxtNroEntidad']));
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
			//generoid
			$query="SELECT Max(Id) as UltimoId FROM personal_cargas";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//inserto
			$query="INSERT INTO personal_cargas (Id,IdEntidad,Apellido,Nombre,CUIL,FechaD,FechaH,IIGG,IdTipo) VALUES ($nroId,$ident,'$ap','$nom','$cuit','$fechaa','$fechab',$gan,$tipo)";$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 	
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:AltaCF.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:AltaCF.php?Id=".intval($_POST['TxtNroEntidad']));
			}			
		}
	}
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
}

?>
