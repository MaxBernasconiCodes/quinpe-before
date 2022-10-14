<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ((empty($_POST['TxtNombre']))){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaUTE.php?Id=".intval($_POST['TxtNroEntidad'])."&identidad=".intval($_POST['TxtNroEntidad']));
	}
	else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosUTE.php");
		//inserto
		$nroId=GLO_generoID('cli_utes',$conn);
		$query="INSERT INTO cli_utes (Id,IdCliente,Nombre,Identificacion,IdIva,Dir,IdLoc) VALUES ($nroId,$ident,'$nom','$cuit',$iva,'$dir',$loc)";
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


elseif ( isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}




else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:".$_SERVER['HTTP_REFERER']);
}

?>

