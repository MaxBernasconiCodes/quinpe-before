<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	//valido
	$requerido=1;
	if ((empty($_POST['CbPuesto'])) or (empty($_POST['CbNombre'])) or  (empty($_POST['CbPerfil'])) or (empty($_POST['TxtUsuario'])) or (empty($_POST['TxtClave'])) or (empty($_POST['TxtConfirmar']))){$requerido=2;GLO_feedback(3);}
	if ($_POST['TxtClave']!=$_POST['TxtConfirmar']){$requerido=2;GLO_feedback(6);}
	if (strlen($_POST['TxtClave'])<8){$requerido=2;GLO_feedback(7);}
	if (!preg_match('`[0-9]`',$_POST['TxtClave'])){$requerido=2;GLO_feedback(8);}
	if ((!preg_match('`[a-z]`',$_POST['TxtClave'])) and (!preg_match('`[A-Z]`',$_POST['TxtClave']))){$requerido=2;GLO_feedback(9);}
	//grabo o vuelvo
	if (($requerido!=1)) { 	
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		header("Location:Alta.php");	
	}else{
		//grabar 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$usuario=mysql_real_escape_string(ltrim($_POST['TxtUsuario'])); 
		$clave=crypt(trim($_POST['TxtClave']), 'otro@letra8'); 
		$pto=mysql_real_escape_string($_POST['CbPuesto']); 
		$perf=intval($_POST['CbPerfil']); 
		$ent=intval($_POST['CbNombre']); 
		$prov=0;$pers=$ent;$cli=0;		
		$query="INSERT INTO usuarios (Usuario,Puesto,Password,IdPerfil,Tipo,IdPersonal,IdProveedor,IdCliente,FechaBaja) VALUES ('$usuario','$pto','$clave',$perf,'$pto',$pers,$prov,$cli,'0000-00-00')";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		header("Location:../Usuarios.php");
	}
	
}




?>

