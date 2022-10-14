<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ //prov o sugerido deben estar registrados, pero solo uno
	if ( empty($_POST['TxtFechaA']) or (empty($_POST['CbProv']) and empty($_POST['TxtObs2'])) or (!(empty($_POST['CbProv'])) and !(empty($_POST['TxtObs2'])))  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);
		if(empty($_POST['CbProv']) and empty($_POST['TxtObs2'])){$_SESSION['GLO_msgE']='Por favor registre Proveedor existente o sugerido';}
		if(!(empty($_POST['CbProv'])) and !(empty($_POST['TxtObs2']))){$_SESSION['GLO_msgE']='Por favor registre un solo Proveedor';}
		header("Location:AltaCotizacion.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);		
		if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}
		$prov=intval($_POST['CbProv']);		
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$obs2=mysql_real_escape_string($_POST['TxtObs2']);//prov sugerido
		$est=intval($_POST['CbEstado']);		
		//query
		$nroId=GLO_generoID("co_pcotiz",$conn);
		$query="INSERT INTO co_pcotiz (Id,Fecha,IdProv,IdEstado,Obs,Obs2) VALUES ($nroId,'$fa',$prov,$est,'$obs','$obs2')";
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarCotizacion.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaCotizacion.php");
		}			
	}		

}

elseif (isset($_POST['CmdItems'])){
header("Location:ConsultaItems.php");
}


elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Cotizaciones.php");
}



?>

