<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php"); $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	//valido
	$requerido=1;
	if ((empty($_POST['TxtClave'])) or (empty($_POST['TxtConfirmar']))){$requerido=2;GLO_feedback(3);}
	if ($_POST['TxtClave']!=$_POST['TxtConfirmar']){$requerido=2;GLO_feedback(6);}
	if (strlen($_POST['TxtClave'])<8){$requerido=2;GLO_feedback(7);}
	if (!preg_match('`[0-9]`',$_POST['TxtClave'])){$requerido=2;GLO_feedback(8);}
	if ((!preg_match('`[a-z]`',$_POST['TxtClave'])) and (!preg_match('`[A-Z]`',$_POST['TxtClave']))){$requerido=2;GLO_feedback(9);}
	//grabo o vuelvo
	if (($requerido!=1)) { 	
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		header("Location:CambioClave.php?id=".intval($_POST['TxtNumero']));
	}else{ 
		//grabar los datos en la tabla
		$clave=crypt(trim($_POST['TxtClave']), 'otro@letra8'); 	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
		$query="UPDATE clientes_usr set Password='".$clave."' Where  Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:../UsuariosC.php");
	}		
}

elseif (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../UsuariosC.php");
}










?>