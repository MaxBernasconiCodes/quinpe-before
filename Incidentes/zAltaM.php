<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtNombre']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaM.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$obs=mysql_real_escape_string($_POST['TxtNombre']);
		$pers=intval($_POST['CbPersonal']);
		$pers2=intval($_POST['CbPersonal2']);
		$est=intval($_POST['OptE']);
		$f1=GLO_FechaMySql($_POST['TxtFecha1']);
		$f2=GLO_FechaMySql($_POST['TxtFecha2']);
		//inserto
		$nroId=GLO_generoID("incidentes_med",$conn);
		$query="INSERT INTO incidentes_med (Id,IdP,Obs,IdPersonal,IdPersonal2,Estado,Fecha1,Fecha2) VALUES ($nroId,$ident,'$obs',$pers,$pers2,$est,'$f1','$f2')";$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


elseif ( isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

