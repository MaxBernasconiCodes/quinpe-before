<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['CbItem']) or empty($_POST['TxtRes']) or empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaItem.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//procesosop_e1
		$item=intval($_POST['CbItem']);//item 
		$uni=intval($_POST['CbUnidad']);//unidad medida
		$res=floatval($_POST['TxtRes']);//cant
		$val=mysql_real_escape_string($_POST['TxtVal']);//lote
		$env=intval($_POST['CbEnv']);//envase
		$bul=intval($_POST['TxtBultos']);//bultos
		$obs=mysql_real_escape_string($_POST['TxtObs']);//destino
		//inserto		
		$nroId=GLO_generoID("procesosop_e1_it",$conn);
		$query="INSERT INTO procesosop_e1_it (Id,IdPadre,IdIC,IdU,Cant,Lote,IdEnv,CantI,Bultos,Destino) VALUES ($nroId,$ident,$item,$uni,$res,'$val',$env,0,$bul,'$obs')";	$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A1');
	}
}


elseif ( isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A1');
}



?>

