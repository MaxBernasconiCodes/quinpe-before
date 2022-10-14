<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['TxtFecha']) ){

		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		

		GLO_feedback(3);header("Location:ModificarEPR.php?id=".intval($_POST['TxtNumero']));

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}	

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		$id=intval($_POST['TxtNumero']);

		//actualizo

		$query="UPDATE pedidosrep_hist set Fecha='$fecha',Obs='$obs' Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);

		if (!($rs)){GLO_feedback(2);} 

		mysql_close($conn); 	

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:ModificarOrden.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

	}

}













elseif ( isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:ModificarOrden.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}





?>





