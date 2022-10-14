<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
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
	//pedidos que no estan en ninguna OC 
	$_SESSION['TxtQCOITEMS']="SELECT np.*,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,e.Nombre as Estado, a.Id as IdArticuloItem,a.Nombre as Articulo,um.Abr,p.Apellido as Prov,p1.Nombre as NomS,p1.Apellido as ApeS,npi.Obs as ObsIT,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,proveedores p,personal p1,items il,unidadesmedida u2 Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdProv=p.Id and np.IdPerSoli=p1.Id and npi.IdEstado=8 and npi.IdItem=il.Id and il.IdUnidad=u2.Id and (npi.NroOC='0' or npi.NroOC='') $where and npi.Id Order by np.Id,a.Nombre";	
	header("Location:ConsultaItems.php");
}


?>