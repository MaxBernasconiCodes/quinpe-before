<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);




if (isset($_POST['CmdAceptar'])){
	if ( !(empty($_POST['CbPersonal'])) or  !(empty($_POST['TxtNombre'])) ){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$form=intval($_POST['CbPersonal']);
		$obs=mysql_real_escape_string($_POST['TxtNombre']);
		//inserto
		$nroId=GLO_generoID("iso_audi_auditores",$conn);
		$query="INSERT INTO iso_audi_auditores(Id,IdAudiProg,IdPersonal,Nombre) VALUES ($nroId,$ident,$form,'$obs')";$rs=mysql_query($query,$conn);
		mysql_close($conn); 
	}	
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>