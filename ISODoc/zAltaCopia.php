<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");



//perfiles
GLO_PerfilAcceso(14);

//si no tiene cargados responsables

if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}









if (isset($_POST['CmdAceptar'])){

	if ( (empty($_POST['TxtCant'])) or ($_POST['TxtCant']==0) or (empty($_POST['TxtFechaA']))){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		

	    GLO_feedback(3);header("Location:AltaCopia.php?Id=".intval($_POST['TxtNumero']));

	}

	else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$iddoc=intval($_POST['TxtNumero']);

		$cant=intval($_POST['TxtCant']);if($cant==''){$cant=0;}

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}

		$obs=mysql_real_escape_string($_POST['TxtObs']);		

		//inserto

		$nroId=GLO_generoID('iso_doc_copias',$conn);

		$query="INSERT INTO iso_doc_copias(Id,IdDoc,Cantidad,FechaA,FechaB,Obs) VALUES ($nroId,$iddoc,$cant,'$fechaa','$fechab','$obs')";

		$rs=mysql_query($query,$conn);	

		if($rs)	{ISODOC_grabaauditoria($iddoc,12,$conn);	}

		//cierro conx

		mysql_close($conn); 		

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:Modificar.php?id=".$iddoc."&Flag1=True");

	}

}









if ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");

}



?>



