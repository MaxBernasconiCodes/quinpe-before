<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ((intval($_POST['CbItem'])==0) or (empty($_POST['TxtCantidad'])) or ($_POST['TxtCantidad']==0)){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaI.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$idorden=intval($_POST['TxtIdOrden']);
		$art=intval($_POST['CbItem']);
		$cant=floatval($_POST['TxtCantidad']);if($cant==''){$cant=0;}		
		$psi=intval($_POST['TxtPSI']);
		$mim=intval($_POST['TxtMIM']);	 
		if (empty($_POST['TxtFechaP'])){$fpsi="0000-00-00";}else{$fpsi=FechaMySql($_POST['TxtFechaP']);}	
		if (empty($_POST['TxtFechaM'])){$fmim="0000-00-00";}else{$fmim=FechaMySql($_POST['TxtFechaM']);}	 	
		//inserto
		$nroId=GLO_generoID('pedidosrepreq_ins',$conn);
		$query="INSERT INTO pedidosrepreq_ins (Id,IdPRR,IdArti,Cant,PSI,FechaPSI,MIM,FechaMIM) VALUES ($nroId,$ident,$art,$cant,$psi,'$fpsi',$mim,'$fmim')";$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;REP_updateestadoaccion($conn,$ident,$idorden,0);}
		else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaI.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}

if (isset($_POST['CmdExBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:AltaI.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=False");
}


elseif (  isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

