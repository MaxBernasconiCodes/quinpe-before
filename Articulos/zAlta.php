<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or empty($_POST['CbTipo']) or  empty($_POST['CbUnidad'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatos.php");
		//inserto
		$nroId=GLO_generoID('epparticulos',$conn);
		$query="INSERT INTO epparticulos (Id,Nombre,IdRubro,IdMarca,IdUnidad,Obs,Modelo,Frecuencia,EPP,FechaBaja,Stock,NSE,FechaV,Foto,TAG,Rango1,Rango2,UnidadM,TipoC) VALUES ($nroId,'$nombre',$rubro,$marca,$unidad,'$obs','$modelo',$frec,$epp,'$fechab',$stock,'$nse','$fechav','','$tag','$ran1','$ran2',$unm,$verif)";
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(18);$grabook=0; } 
		mysql_close($conn); 
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:Alta.php");
		}			

	}		
	
}


//add y refresh
elseif (isset($_POST['CmdAddMar'])){
	header("Location:../Marcas/Agregar.php");
}
elseif (isset($_POST['CmdRefreshMar'])){
	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}
	header("Location:Alta.php");
}






?>