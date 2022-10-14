<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbItem']) or empty($_POST['TxtRes']) or empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarItem.php?id=".intval($_POST['TxtNumero']));
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
		//actualizo
		$query="UPDATE procesosop_e1_it set IdIC=$item,IdU=$uni,Cant=$res,Lote='$val',IdEnv=$env,Bultos=$bul,Destino='$obs' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True").'#A1';
	}
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	if(intval($_SESSION['TxtOriProcIt'])==0){
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A1');	
	}else{header("Location:Items.php");}
}


?>


