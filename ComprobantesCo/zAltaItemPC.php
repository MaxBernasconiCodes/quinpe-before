<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$idcompr=intval($_POST['TxtNroEntidad']);
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}
	$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Id=$nroped";}else{$wnroped="";}
	$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and npi.IdProv=$prov";}else{$wprov="";}
	$soli=intval($_POST['CbSoli']);if($soli!=0){$wsoli="and np.IdPerSoli=$soli";}else{$wsoli="";}
	//buscar articulo/item
	$wnom="";
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$wnom="and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
	}
	mysql_close($conn);	
	$where=$wfechad.' '.$wfechah.' '.$wnom.' '.$wprov.' '.$wsoli.' '.$wnroped;
	//query 
	$_SESSION['TxtQCOPCIT']="SELECT np.*,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,npi.INC,e.Nombre as Estado, a.Id as IdArticuloItem,a.Nombre as Articulo,um.Abr,p.Apellido as Prov,u.Nombre as Unidad,u.Dominio,p1.Nombre as NomS,p1.Apellido as ApeS,p3.Nombre as NomD,p3.Apellido as ApeD,sm.Nombre as SectorM,itr.Nombre as Equipo,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,proveedores p,unidades u,personal p1,personal p3,sectorm sm,epparticulos itr,items il,unidadesmedida u2 Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and np.IdUnidad=u.Id and npi.IdProv=p.Id and np.IdPerSoli=p1.Id and np.IdPersonal=p3.Id and np.IdSectorM=sm.Id and np.IdInstr=itr.Id and npi.IdEstado=8 and npi.IdItem=il.Id and il.IdUnidad=u2.Id and (npi.NroOC='0' or npi.NroOC='') $where and npi.Id NOT IN(Select IdItemNP From co_pcotiz_it Where IdPCotiz=$idcompr)  Order by u.Nombre,p3.Apellido,np.Id LIMIT 2000";	
	header("Location:AltaItemPC.php?Id=".intval($_POST['TxtNroEntidad']));
}





elseif (isset($_POST['CmdGuardar'])){	 
	$idcompr=intval($_POST['TxtNroEntidad']);
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);
		foreach($aListaid as $iId) {
			list($iIdNP,$iIdItemNP)=explode("|",$iId);$iIdNP=intval($iIdNP);$iIdItemNP=intval($iIdItemNP);	
			//generoid
			$query="SELECT Max(Id) as UltimoId FROM co_pcotiz_it";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//inserto item certificado
			$query="INSERT INTO co_pcotiz_it (Id,IdPCotiz,IdNPedido,IdItemNP) VALUES ($nroId,$idcompr,$iIdNP,$iIdItemNP)";
			$rs=mysql_query($query,$conn);
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:AltaItemPC.php?Id=".intval($_POST['TxtNroEntidad']));
}



?>