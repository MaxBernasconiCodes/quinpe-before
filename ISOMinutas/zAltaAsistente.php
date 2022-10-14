<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);





if (isset($_POST['CmdAceptar'])){ 

	if ( empty($_POST['TxtNombre']) and empty($_POST['CbPersonal']) ){

		//obtener datos del form anterior

		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}	

		GLO_feedback(3);	

		header("Location:AltaAsistente.php?Id=".intval($_POST['TxtNroEntidad']));

	}else{

		//grabar los datos en la tabla

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);

		$sec=intval($_POST['CbSector']);

		$obs=mysql_real_escape_string($_POST['TxtNombre']);

		$pers=intval($_POST['CbPersonal']);

		//inserto

		$nroId=GLO_generoID("iso_minutas_as",$conn);

		$query="INSERT INTO iso_minutas_as (Id,IdMin,Nombre,IdSector,IdPersonal) VALUES ($nroId,$ident,'$obs',$sec,$pers)";$rs=mysql_query($query,$conn);

		mysql_close($conn); 	

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

	}

}





elseif ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir'])){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}







?>



