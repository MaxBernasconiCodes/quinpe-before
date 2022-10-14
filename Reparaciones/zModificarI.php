<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((intval($_POST['CbItem'])==0) or (empty($_POST['TxtCantidad'])) or ($_POST['TxtCantidad']==0)){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarI.php?id=".intval($_POST['TxtNumero']));
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
		//actualizo
		$query="UPDATE pedidosrepreq_ins set IdArti=$art,Cant=$cant,PSI=$psi,FechaPSI='$fpsi',MIM=$mim,FechaMIM='$fmim' Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){REP_updateestadoaccion($conn,$ident,$idorden,0);}
		else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}

if (isset($_POST['CmdExBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:ModificarI.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
}



elseif ( isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


?>


