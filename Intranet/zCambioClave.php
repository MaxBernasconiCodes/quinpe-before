<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php"); $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");


if (isset($_POST['CmdAceptar'])){
	//valido
	$requerido=1;
	if ( empty($_POST['TxtClave']) or empty($_POST['TxtClaveActual']) or empty($_POST['TxtConfirmar']) )
	{$requerido=2;GLO_feedback(3);}
	if ($_POST['TxtClave']!=$_POST['TxtConfirmar']){$requerido=2;GLO_feedback(6);}
	if (strlen($_POST['TxtClave'])<8){$requerido=2;GLO_feedback(7);}
	if (!preg_match('`[0-9]`',$_POST['TxtClave'])){$requerido=2;GLO_feedback(8);}
	if ((!preg_match('`[a-z]`',$_POST['TxtClave'])) and (!preg_match('`[A-Z]`',$_POST['TxtClave']))){$requerido=2;GLO_feedback(9);}
	//verifico clave actual
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$login = $_SESSION["login"];
	$pass = mysql_real_escape_string(trim($_POST['TxtClaveActual']));
	$query="SELECT Usuario FROM usuarios WHERE Usuario <> '' and Password <> '' and Usuario='$login' and Password='".crypt($pass , 'otro@letra8')."'" ;$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){$requerido=2;GLO_feedback(5);}mysql_free_result($rs);
	mysql_close($conn);		
	//grabo o vuelvo
	if ($requerido!=1) { 		
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		header("Location:../CambioClave.php");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$clave=crypt(trim($_POST['TxtClave']), 'otro@letra8'); 		
		$query="UPDATE usuarios set Password='".$clave."' Where Usuario='".mysql_real_escape_string($_SESSION["login"])."'";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:../CambioClave.php");	
	}	
}



?>
