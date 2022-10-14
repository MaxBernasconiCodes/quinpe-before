<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$smtp=mysql_real_escape_string($_POST['TxtSMTP']);
	$pop=mysql_real_escape_string($_POST['TxtPOP']);
	$user=mysql_real_escape_string(ltrim($_POST['TxtUsuario']));
	$pass=mysql_real_escape_string($_POST['TxtPass']);
	$mailf=mysql_real_escape_string($_POST['TxtMailF']);
	$mailt=mysql_real_escape_string($_POST['TxtMailT']);
	//update	
	$query="UPDATE parametros set ServerSMTP='$smtp', ServerPOP='$pop', Usuario='$user', Password='$pass', MailFrom='$mailf', MailToAlertas='$mailt'  Where Id=1"; $rs=mysql_query($query,$conn);
	mysql_close($conn); 	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	header("Location:../MiEmpresa.php?Flag1=True");
}




elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../Inicio.php");
}


?>