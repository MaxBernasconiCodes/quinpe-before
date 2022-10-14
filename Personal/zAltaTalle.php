<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


if (isset($_POST['CmdAceptar'])){ 
	if ((empty($_POST['CbTipo'])) or (empty($_POST['TxtTalle'])) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaTalle.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$tipo=intval($_POST['CbTipo']);
		$talle=mysql_real_escape_string($_POST['TxtTalle']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
	  	//generoid
		$query="SELECT Max(Id) as UltimoId FROM personaltalles";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//inserto
		$query="INSERT INTO personaltalles (Id,IdEntidad,IdElem,Talle,Obs) VALUES ($nroId,$ident,$tipo,'$talle','$obs')";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:AltaTalle.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaTalle.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}



elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A1');
}



?>

