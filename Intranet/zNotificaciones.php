<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdLinkRow1'])){//unidades
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=3;//mant
	header("Location:../Unidades/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdLinkRow2'])){//personal
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=5;//rrhh
	header("Location:../Personal/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdLinkRow3'])){//articulos vtos
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=1;//adm
	header("Location:../Articulos/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}


elseif (isset($_POST['CmdLinkRow4'])){//accesorios asignaciones
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=3;//mant
	header("Location:../Accesorios/ModificarAsignacion.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdLinkRow5'])){//instrumentos  asignaciones
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=1;//adm
	header("Location:../Articulos/ModificarAsignacion.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdLinkRow7'])){//accesorios certificaciones
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=3;//mant
	header("Location:../Accesorios/ModificarCE.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdLinkRow8'])){//instrumentos  certificaciones
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
    $_SESSION["GLO_IdSistema"]=1;//adm
	header("Location:../Instrumentos/ModificarCE.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}
?>

