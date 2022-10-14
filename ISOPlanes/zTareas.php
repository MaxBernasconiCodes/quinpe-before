<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaTarea.php?Id=".intval($_POST['TxtNroEntidad']));
}

elseif (isset($_POST['CmdBorrarFilaA'])){
	$query="Delete From plan_t Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);PL_Auditoria(2,intval($_POST['TxtNroEntidad']),$conn);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Tareas.php?Id=".intval($_POST['TxtNroEntidad']));	
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

