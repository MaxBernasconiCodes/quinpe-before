<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST['CmdAceptar'])){

	if ( !(empty($_POST['CbItem'])) ){

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);//itemscliente_serv

		$iditem=intval($_POST['CbItem']);

		$cod=mysql_real_escape_string($_POST['TxtNombre']);	

		//inserto item cliente

		$nroId=GLO_generoID("itemscliente_serv_b",$conn);

		$query="INSERT INTO itemscliente_serv_b (Id,IdPadre,IdLB,Cod) VALUES ($nroId,$ident,$iditem,'$cod')";

		$rs=mysql_query($query,$conn);

		if ($rs){}else{GLO_feedback(2);} 

		mysql_close($conn); 

	}

	//volver

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:ModificarItem.php?Flag1=True&itemcliente=".intval($_POST['TxtNroEntidad']));	

}







elseif ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:ModificarItem.php?Flag1=True&itemcliente=".intval($_POST['TxtNroEntidad']));	

}



?>