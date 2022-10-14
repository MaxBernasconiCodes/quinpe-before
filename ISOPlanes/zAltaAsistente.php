<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtNombre']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}	
		GLO_feedback(3);	
		header("Location:AltaAsistente.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$nom=mysql_real_escape_string($_POST['TxtNombre']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		//inserto
		$nroId=GLO_generoID("plan_part",$conn);
		$query="INSERT INTO plan_part (Id,IdP,Nombre,Empresa) VALUES ($nroId,$ident,'$nom','$obs')";$rs=mysql_query($query,$conn);
		if($rs){PL_Auditoria(2,$ident,$conn);}
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

