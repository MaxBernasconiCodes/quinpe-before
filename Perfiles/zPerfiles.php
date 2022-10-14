<?php include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['Cmd0'])){
$_SESSION["TxtIdManual"]=0;$_SESSION["TxtIdManualT"]='Administracion';
header("Location:Perfiles.php");
}


if (isset($_POST['Cmd1'])){
$_SESSION["TxtIdManual"]=1;$_SESSION["TxtIdManualT"]='Coordinador';
header("Location:Perfiles.php");
}

if (isset($_POST['Cmd2'])){
$_SESSION["TxtIdManual"]=2;$_SESSION["TxtIdManualT"]='General';
header("Location:Perfiles.php");
}

if (isset($_POST['Cmd3'])){
$_SESSION["TxtIdManual"]=3;$_SESSION["TxtIdManualT"]='Mantenimiento';
header("Location:Perfiles.php");
}

if (isset($_POST['Cmd4'])){
$_SESSION["TxtIdManual"]=4;$_SESSION["TxtIdManualT"]='RRHH';
header("Location:Perfiles.php");
}

if (isset($_POST['Cmd5'])){
$_SESSION["TxtIdManual"]=5;$_SESSION["TxtIdManualT"]='SGI Externo';
header("Location:Perfiles.php");
}
if (isset($_POST['Cmd6'])){
    $_SESSION["TxtIdManual"]=6;$_SESSION["TxtIdManualT"]='HSE';
    header("Location:Perfiles.php");
}
if (isset($_POST['Cmd7'])){
    $_SESSION["TxtIdManual"]=7;$_SESSION["TxtIdManualT"]='SGI Externo Limitado';
    header("Location:Perfiles.php");
}
if (isset($_POST['Cmd8'])){
    $_SESSION["TxtIdManual"]=8;$_SESSION["TxtIdManualT"]='Barrera';
    header("Location:Perfiles.php");
}

?>

