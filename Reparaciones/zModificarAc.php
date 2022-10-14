<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtFecha'])) or (empty($_POST['TxtHora1'])) or (empty($_POST['TxtObs'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarAc.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$idorden=intval($_POST['TxtIdOrden']);
		$fecha=GLO_FechaMySql($_POST['TxtFecha']);	
		$h1=$_POST['TxtHora1'];if($h1==''){$h1='00:00';}
		$h2=$_POST['TxtHora2'];if($h2==''){$h2='00:00';}
		$pers=intval($_POST['CbPersonal']);
		$pers1=intval($_POST['CbPersonal1']);
		$pers2=intval($_POST['CbPersonal2']);
		$pers3=intval($_POST['CbPersonal3']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$ise=intval($_POST['ChkISE']);
		//actualizo
		$query="UPDATE pedidosrepreq_act set Fecha='$fecha',Hora1='$h1',Hora2='$h2',IdPersonal=$pers,IdPersonal1=$pers1,IdPersonal2=$pers2,IdPersonal3=$pers3,Obs='$obs',IngresoSE=$ise Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){REP_updateestadoaccion($conn,$ident,$idorden,0);}
		else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}






elseif (  isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarReq.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


?>


