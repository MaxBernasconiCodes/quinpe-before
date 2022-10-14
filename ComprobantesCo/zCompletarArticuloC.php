<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:AltaItemOC.php");
}


//articulos o productos
elseif (isset($_POST['CmdExBuscar']) or isset($_POST['CmdExBuscar2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:CompletarArticuloC.php?IdItem=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdAceptar'])){
	if(intval($_POST['CbItem'])!=0 and intval($_POST['CbItem2'])!=0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		$_SESSION['GLO_msgE']='Seleccione Art&iacute;culo o Producto, no ambos';
		header("Location:CompletarArticuloC.php?IdItem=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$iditem=intval($_POST['CbItem']);
		$iditem2=intval($_POST['CbItem2']);
		//solo creadas incompletas (cambio solicitado por liliana medina)
		$query="UPDATE co_npedido_it set IdArticulo=$iditem,IdItem=$iditem2 Where  Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:AltaItemOC.php");
	}
}


elseif (isset($_POST['CmdAddArt'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:../Articulos/Agregar.php");
}

?>