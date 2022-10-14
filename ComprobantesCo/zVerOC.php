<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}
	//
	$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Id=$nroped";}else{$wnroped="";}
	$nrooc=mysql_real_escape_string($_POST['TxtNroOC2']);if($nrooc!='0' and $nrooc!=''){$wnrooc="and npi.NroOC='$nrooc'";}
	//buscar articulo/item
	$wnom="";
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$wnom="and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
	}
	mysql_close($conn);	
	//tiene que tener OC
	$where=$wfechad.' '.$wfechah.' '.$wnom.' '.$wnroped.' '.$wnrooc." and npi.NroOC<>'0' and npi.NroOC<>''";
	//query aca filtra oc=0 con $wnrooc
	$_SESSION['TxtQCOOCITV']="SELECT np.*,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,npi.INC,npi.NroOC,e.Nombre as Estado, a.Id as IdArticuloItem, a.Nombre as Articulo,um.Abr,p1.Nombre as NomS,p1.Apellido as ApeS,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,personal p1,items il,unidadesmedida u2 Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and  np.IdPerSoli=p1.Id and npi.IdEstado=8 and npi.IdItem=il.Id and il.IdUnidad=u2.Id $where and npi.Id NOT IN(Select distinct IdItemNP from stockmov_items) Order by np.Id,a.Nombre LIMIT 2000";	
	header("Location:VerOC.php");
}





elseif (isset($_POST['CmdGuardar'])){	 
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);
		$aListanrooc=$_POST['TxtNroOC'];//array valor nrooc
		foreach($aListaid as $iId) {
			list($iIdNP,$iIdItemNP)=explode("|",$iId);$iIdNP=intval($iIdNP);$iIdItemNP=intval($iIdItemNP);	
			$nrooc=mysql_real_escape_string($aListanrooc[$iIdItemNP]);
			$query="update co_npedido_it set NroOC='$nrooc' where Id=$iIdItemNP";	$rs=mysql_query($query,$conn);
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:VerOC.php");
}


?>