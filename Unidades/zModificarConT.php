<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$ident=intval($_POST['TxtNroEntidad']);//contrato
	$imp=GLO_GrabarImporte($_POST['TxtImporte']);
	$mon=intval($_POST['CbMoneda']);
	$obs=mysql_real_escape_string($_POST['TxtObs']);
	$query="UPDATE unidades_cont set Importe=$imp,Moneda=$mon,Obs='$obs' Where Id=$id";
	$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 				
	//vuelvo	
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

elseif (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}
elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

?> 
