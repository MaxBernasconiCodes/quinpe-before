<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtNro']))  or (empty($_POST['CbNorma'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;		}		
	    GLO_feedback(3);header("Location:Alta.php");
	}
	else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$nror=mysql_real_escape_string($_POST['TxtNro']);
		$norma=intval($_POST['CbNorma']);
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
	  	//generoid
		$query="SELECT Max(Id) as UltimoId FROM iso_nc_req";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//inserto
		$query="INSERT INTO iso_nc_req (Id,Nombre,Nro,IdNorma,FechaBaja) VALUES ($nroId,'$nombre','$nror',$norma,'$fechab')";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		header("Location:../ISO_Requisitos.php");
	}		
}



?>

