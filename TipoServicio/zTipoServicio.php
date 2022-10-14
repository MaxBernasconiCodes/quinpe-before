<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST[CmdAgregar])){	

	foreach($_POST as $key => $value){$_SESSION[$key] = '';}

	header("Location:Alta.php");

}



if (isset($_POST['CmdBorrarFila'])){	

	//no eliminar flushby(19) ni TRAT FLOW BACK(33) ni  FILTRADO BOMBEO POZO SUMIDERO(32)

	$query="Delete From serviciostipo Where Id<>19 and Id<>32 and Id<>33 and Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	if(intval($_POST['TxtId'])==19 or intval($_POST['TxtId'])==32 or intval($_POST['TxtId'])==33){$_SESSION['GLO_msgE']="No es posible eliminar este Tipo de Servicio";}

	foreach($_POST as $key => $value){$_SESSION[$key] = '';}

	header("Location:../TipoServicio.php"); 	

}



if (isset($_POST[CmdSalir])){

	foreach($_POST as $key => $value){$_SESSION[$key] = '';}

	header("Location:../Servicios.php");

}



?>