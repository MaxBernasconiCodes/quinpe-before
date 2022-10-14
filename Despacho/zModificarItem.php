<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbItem']) or empty($_POST['TxtRes']) or empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarItem.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//despacho
		$item=intval($_POST['CbItem']);//item 
		$uni=intval($_POST['CbUnidad']);//unidad medida
		$res=floatval($_POST['TxtRes']);//cant
		$env=intval($_POST['CbEnv']);//envase
		$val=mysql_real_escape_string($_POST['TxtVal']);//lote
		$bul=intval($_POST['TxtBultos']);//bultos
		$obs=mysql_real_escape_string($_POST['TxtObs']);//destino
		//actualizo
		$query="UPDATE despacho_it set IdIC=$item,IdU=$uni,Cant=$res,IdEnv=$env,Lote='$val',Bultos=$bul,Destino='$obs' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		//veo a donde regresa
		if( intval($_POST['TxtLocPage'])==1 ){
			header("Location:../Planta/ModificarP.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A2');
		}else{header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A2');}
		
	}
}


elseif ( isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		//veo a donde regresa
		if( intval($_POST['TxtLocPage'])==1 ){
			header("Location:../Planta/ModificarP.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A2');
		}else{header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A2');}
}
	

?>


