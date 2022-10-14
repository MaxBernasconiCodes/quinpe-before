<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//where 
	$wbuscar="";
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(ra.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(ra.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	//no asignadas
	$wbuscar=$wbuscar." and ra.IdPersonal=0 and ra.IdPersonal1=0 and ra.IdPersonal2=0 and ra.IdPersonal3=0";
	//query
	$_SESSION['TxtQREPORDT']="SELECT ra.Id, rr.IdPR as IdOrden,u.Dominio,u.Nombre as Uni,ra.Fecha as FechaT,ra.Obs as ObsT,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrepord r,pedidosrepreq rr,pedidosrepreq_act ra,unidades u,sectorm sm,epparticulos ins where r.Id<>0 and rr.IdPR=r.Id  and ra.IdPRR=rr.Id and r.IdUnidad=u.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by ra.Fecha,r.Id";
	header("Location:OrdenesT.php");
}


elseif (isset($_POST['CmdGuardar'])){	 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	if ( empty($_POST['CbPersonal']) and empty($_POST['CbPersonal1']) and empty($_POST['CbPersonal2']) and empty($_POST['CbPersonal3']) ){
		$_SESSION['GLO_msgE']='Por favor seleccione Responsable';
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$cont=0;
		$pers=intval($_POST['CbPersonal']);
		$pers1=intval($_POST['CbPersonal1']);
		$pers2=intval($_POST['CbPersonal2']);
		$pers3=intval($_POST['CbPersonal3']);
		$aLista=array_keys($_POST['campos']);//id tareas (pedidosrepreq_act)
		foreach($aLista as $iId) {	
			//actualizo
			$query="UPDATE pedidosrepreq_act set IdPersonal=$pers,IdPersonal1=$pers1,IdPersonal2=$pers2,IdPersonal3=$pers3 Where Id=".intval($iId);$rs=mysql_query($query,$conn);
			if ($rs){$cont++;}
		}
		mysql_close($conn); 
		$_SESSION['GLO_msgC']='Se actualizaron '.$cont.' registros';
	}
	header("Location:OrdenesT.php");
}








?>


