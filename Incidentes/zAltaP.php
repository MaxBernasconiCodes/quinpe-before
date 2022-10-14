<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtNombre']) and empty($_POST['CbPersonal']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}	
		GLO_feedback(3);	
		header("Location:AltaP.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$nom=mysql_real_escape_string($_POST['TxtNombre']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$pers=intval($_POST['CbPersonal']);
		//inserto
		$nroId=GLO_generoID("incidentes_per",$conn);
		$query="INSERT INTO incidentes_per (Id,IdP,Nombre,IdPersonal,Obs) VALUES ($nroId,$ident,'$nom',$pers,'$obs')";
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


elseif (  isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

