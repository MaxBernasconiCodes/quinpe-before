<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);





if (isset($_POST['CmdAceptar'])){
	if (!(empty($_POST['CbProceso']))){
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$form=intval($_POST['CbProceso']);
		//inserto
		$nroId=GLO_generoID("iso_audi_procesos",$conn);
		$query="INSERT INTO iso_audi_procesos(Id,IdAudiProg,IdProceso) VALUES ($nroId,$ident,$form)";$rs=mysql_query($query,$conn);
		mysql_close($conn); 
	}	
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

?>