<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}











if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtObs']) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

		GLO_feedback(3);header("Location:AltaD.php?Id=".intval($_POST['TxtNroEntidad']));

	}else{ 

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);//insp

		$id=intval($_POST['TxtNumero']);//det

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		$pers=intval($_POST['CbPersonal']);

		$est=intval($_POST['CbEstado']);

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}

		//generoid 

		$query="SELECT Max(Id) as UltimoId FROM inspecciones_det";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}	mysql_free_result($rs);

		//inserto  

		$query="INSERT INTO inspecciones_det (Id,IdInsp,Fecha,Obs,IdPersonal,IdEstado,Fecha2) VALUES ($nroId,$ident,'$fechaa','$obs',$pers,$est,'$fechab')";

		$rs=mysql_query($query,$conn);		

		mysql_close($conn); 	

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

	}

}







if ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}



?>





