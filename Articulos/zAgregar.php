<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php") ; 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or empty($_POST['CbTipo']) or  empty($_POST['CbUnidad'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Agregar.php?");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatos.php");
		//inserto
		$nroId=GLO_generoID('epparticulos',$conn);
		$query="INSERT INTO epparticulos (Id,Nombre,IdRubro,IdMarca,IdUnidad,Obs,Modelo,Frecuencia,EPP,FechaBaja,Stock,NSE,FechaV) VALUES ($nroId,'$nombre',$rubro,$marca,$unidad,'$obs','$modelo',$frec,$epp,'$fechab',$stock,'$nse','$fechav')";
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 
		foreach($_POST as $key => $value){	$_SESSION[$key] = "";}		
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	}		
	
}


//add y refresh
elseif (isset($_POST['CmdAddMar'])){
	header("Location:../Marcas/Agregar.php");
}
elseif (isset($_POST['CmdRefreshMar'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Agregar.php");
}


?>