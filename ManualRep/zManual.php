<?php include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";



if (isset($_POST[CmdInicio])){
$_SESSION["TxtIdManual"]=0;
header("Location:ManualSistema.php");
}


if (isset($_POST[CmdCircuito])){
$_SESSION["TxtIdManual"]=2;
header("Location:ManualSistema.php");
}

if (isset($_POST[CmdSolicitudes])){
$_SESSION["TxtIdManual"]=3;
header("Location:ManualSistema.php");
}

if (isset($_POST[CmdOrdenes])){
$_SESSION["TxtIdManual"]=4;
header("Location:ManualSistema.php");
}

if (isset($_POST[CmdPlanilla])){
$_SESSION["TxtIdManual"]=5;
header("Location:ManualSistema.php");
}

if (isset($_POST[CmdAcciones])){
$_SESSION["TxtIdManual"]=6;
header("Location:ManualSistema.php");
}


if (isset($_POST[CmdTareas])){
$_SESSION["TxtIdManual"]=8;
header("Location:ManualSistema.php");
}

if (isset($_POST[CmdInsumos])){
$_SESSION["TxtIdManual"]=9;
header("Location:ManualSistema.php");
}



?>

