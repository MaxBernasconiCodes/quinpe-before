<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (isset($_POST[CmdAceptar])){

	if ((empty($_POST['CbCliente'])) or (empty($_POST['TxtFechaA'])) ){

		//obtener datos del form anterior

		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		

		GLO_feedback(3);header("Location:ModificarCliente.php?id=".intval($_POST['TxtNumero']));

	}else{

		//grabar los datos en la tabla

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);

		$cli=intval($_POST['CbCliente']);

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}

		//actualizo

		$query="UPDATE unidadesclientes set IdCliente=$cli,FechaA='$fechaa',FechaB='$fechab',Obs='$obs' Where Id=".intval($_POST['TxtNumero']);

		$rs=mysql_query($query,$conn);

		mysql_close($conn); 	

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

	}

}





elseif (isset($_POST['CmdCancelar'])){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}

elseif (isset($_POST['CmdSalir'])){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}





?>





