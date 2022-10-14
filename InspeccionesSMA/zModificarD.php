<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}











if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtObs']) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

		GLO_feedback(3);header("Location:ModificarD.php?id=".intval($_POST['TxtNumero']));

	}else{ 

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);//insp

		$id=intval($_POST['TxtNumero']);//det

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		$pers=intval($_POST['CbPersonal']);

		$est=intval($_POST['CbEstado']);

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}

		//update		

		$query="UPDATE inspecciones_det set Fecha='$fechaa',Obs='$obs',IdPersonal=$pers,IdEstado=$est,Fecha2='$fechab' Where Id=$id";

		$rs=mysql_query($query,$conn);				

		//desconecto

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





