<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or empty($_POST['TxtFecha1']) or empty($_POST['TxtObs'])){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}
		GLO_feedback(3);header("Location:ModificarTarea.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$nom=mysql_real_escape_string($_POST['TxtNombre']);
		$yac=intval($_POST['CbYac']);
		$prio=intval($_POST['OptTipo']);
		$est=intval($_POST['CbEstado']);
		$f1=GLO_FechaMySql($_POST['TxtFecha1']);
		$f2=GLO_FechaMySql($_POST['TxtFecha2']);
		$f3=GLO_FechaMySql($_POST['TxtFecha3']);
		$f4=GLO_FechaMySql($_POST['TxtFecha4']);
		//actualizo
		$query="UPDATE plan_t set Nombre='$nom',IdYac=$yac,Prio=$prio,F1='$f1',F2='$f2',F3='$f3',F4='$f4',IdEstado=$est,Obs='$obs' Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);PL_Auditoria(2,$ident,$conn);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarTarea.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}

elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaR.php?Id=".intval($_POST['TxtNumero'])."&Id2=".intval($_POST['TxtNroEntidad']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$query="Delete From plan_tresp Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);PL_Auditoria(2,intval($_POST['TxtNroEntidad']),$conn);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:ModificarTarea.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Tareas.php?Id=".intval($_POST['TxtNroEntidad']));
}


?>


