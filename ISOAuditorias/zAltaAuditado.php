<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);





if (isset($_POST['CmdAceptar'])){
	if (!(empty($_POST['CbPersonal']))){
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$form=intval($_POST['CbPersonal']);
	  	//generoid
		$query="SELECT Max(Id) as UltimoId FROM iso_audi_auditados";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//inserto
		$query="INSERT INTO iso_audi_auditados(Id,IdAudiProg,IdPersonal) VALUES ($nroId,$ident,$form)";$rs=mysql_query($query,$conn);
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