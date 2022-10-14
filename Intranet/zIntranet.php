<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");

if (isset($_POST['CmdBorrarAgenda'])){
	$query="Delete From agenda Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} mysql_close($conn);
	header("Location:../InicioIntranet.php");
}

elseif (isset($_POST['CmdSisAdmin'])){//ADMINISTRACION
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=1;header("Location:../Inicio.php");
}

elseif (isset($_POST['CmdSisInd'])){//INDICADORES
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION["GLO_IdSistema"]=10;header("Location:../Inicio.php");
}
	

elseif (isset($_POST['CmdSisMante'])){//MANTENIMIENTO
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=3;header("Location:../Inicio.php");
}


elseif (isset($_POST['CmdSisOpe'])){//OPERACIONES
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=4;header("Location:../Inicio.php");
}


elseif (isset($_POST['CmdSisRRHH'])){//RRHH
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=5;header("Location:../Inicio.php");
}

elseif (isset($_POST['CmdSisSHT'])){//SMA
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=6;header("Location:../Inicio.php");
}

elseif (isset($_POST['CmdSisCertif'])){//SGI
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
$_SESSION["GLO_IdSistema"]=7;header("Location:../Inicio.php");
}


?>