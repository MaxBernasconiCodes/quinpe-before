<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$_SESSION['TxtNumero']= "";


if (isset($_POST['CmdAceptar'])){ 
	//verifica campos requeridos
	if ( empty($_POST['TxtNombre']) or empty($_POST['CbSoli']) or empty($_POST['TxtFechaA']) or empty($_POST['CbAuto'])  or empty($_POST['CbPAuto']) or empty($_POST['CbSector'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:AltaNotaPedido.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);		
		if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}
		$prio=intval($_POST['OptTipoP']);
		$soli=intval($_POST['CbSoli']); 
		$pauto=intval($_POST['CbPAuto']); 
		$auto=intval($_POST['CbAuto']); 
		$sec=intval($_POST['CbSector']); 		
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$pped=intval($_POST['CbPPED']); 
		$ctro=intval($_POST['CbCentro']); 		
		$uni=intval($_POST['CbUnidad']); 	
		$p1=intval($_POST['CbPersonal']); 
		$eq=intval($_POST['CbInstrumento']); 
		$secm=intval($_POST['CbSector2']); 
		$audiper=intval($_SESSION["GLO_IdPersLog"]);//usuario 
		$est=1;//abierto
		//query
		$nroId=GLO_generoID("co_npedido",$conn);
		$query="INSERT INTO co_npedido (Id,Fecha,Obs,IdPerSoli,IdPerPAuto,IdPerAuto,IdSector,Prioridad,IdPuntoP,IdCentro,IdEstado,IdUnidad,IdPersonal,IdUsr,Titulo,IdInstr,IdSectorM) VALUES ($nroId,'$fa','$obs',$soli,$pauto,$auto,$sec,$prio,$pped,$ctro,$est,$uni,$p1,$audiper,'$nom',$eq,$secm)";
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			$_SESSION['GLO_IdLocationCONP']=2;	
			header("Location:ModificarNotaPedido.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaNotaPedido.php");
		}			
	}		

}






else{ //Click en combo
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:AltaNotaPedido.php");
}


?>

