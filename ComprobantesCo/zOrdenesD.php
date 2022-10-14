<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST[CmdBuscar])){ 	
	//conecto
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//limpio variables
	$wfechad="";$wfechah="";$wnro="";$wsoli="";$wsec="";$west="";$wnom="";$wauto="";$wctro="";
	$wpped="";$wprov="";
	//criterios
	if (!(empty($_POST['TxtFechaDORD']))){$wfechad="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaDORD'])."')>=0";}
	if (!(empty($_POST['TxtFechaHORD']))){$wfechah="and DATEDIFF(co.Fecha,'".FechaMySql($_POST['TxtFechaHORD'])."')<=0";}
	$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and co.Id=$nro";}
	$nrooc=intval($_POST['TxtNroOC']);if($nrooc!=0){$wnrooc="and co.Nro=$nrooc";}else{$wnrooc="";}
	$nropi=intval($_POST['TxtNroPI']);if($nropi!=0){$wnropi="and np.Nro=$nropi";}else{$wnropi="";}
	$soli=intval($_POST['CbSoli']);if($soli!=0){$wsoli="and np.IdPerSoli=$soli";}
	$auto=intval($_POST['CbAuto']);if($auto!=0){$wauto="and (np.IdPerPAuto=$auto or np.IdPerAuto=$auto)";}
	$sec=intval($_POST['CbSector']);if($sec!=0){$wsec="and np.IdSector=$sec";}
	$ctro=intval($_POST['CbCentro']);if($ctro!=0){$wctro="and np.IdCentro=$ctro";}
	$uni=intval($_POST['CbUnidad']);if($uni!=0){$wuni="and np.IdUnidad=$uni";}
	$pped=intval($_POST['CbPPED']);if($pped!=0){$wpped="and np.IdPuntoP=$pped";}
	$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and co.IdProv=$prov";}
	$est=intval($_POST['CbEstado']);if($est!=0){$west="and co.IdEstado=$est";}
	if (!(empty($_POST['TxtBusqueda']))){$wnom="and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	$chkpe=intval($_POST['ChkPE']);$chkre=intval($_POST['ChkRE']);$chkpa=intval($_POST['ChkRA']);
	//query
	$query="Select co.*,np.Id as IdNP,np.Nro as NroNP,npi.CantAuto as CantAutoItem,np.Prioridad,np.Obs as ObsNP,p1.Nombre as NomS,p1.Apellido as ApeS,p2.Nombre as NomA,p2.Apellido as ApeA,p3.Nombre as NomPA,p3.Apellido as ApePA,s.Nombre as Sector,a.Id as IdArticuloItem, a.Nombre as Articulo,a.Modelo, m.Nombre as Marca,um.Abr,p.Apellido as Prov,e.Nombre as Estado,pp.Nombre as PPED,u.Nombre as Unidad,i.Id as IdItemOC From co_ocompra as co,co_ocompra_it i,co_npedido np,co_npedido_it npi, personal p1,personal p2,personal p3,sector s,epparticulos a,unidadesmedida um,proveedores p,co_ocompra_est e,puntospedido pp,unidades u,marcas m Where co.Id=i.IdOCompra and npi.Id=i.IdItemNP and np.Id=npi.IdNP and np.IdPerSoli=p1.Id and np.IdPerAuto=p2.Id and np.IdPerPAuto=p3.Id and np.IdSector=s.Id and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and  np.IdUnidad=u.Id and co.IdProv=p.Id and np.IdPuntoP=pp.Id and co.IdEstado=e.Id and a.IdMarca=m.Id $wfechad $wfechah $wnro $wnropi $wsoli $wsec $west $wnom $wauto $wctro $wuni $wpped $wprov $wnrooc Order by np.Id";	
	//vuelvo
	mysql_close($conn);
	$_SESSION['TxtQuery19']=$query;
	header("Location:OrdenesD.php");
}









?> 

