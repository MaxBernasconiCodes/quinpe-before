<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


//criterios
$idcompr=intval($_POST['TxtNroEntidad']);
if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}
if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}
$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Id=$nroped";}else{$wnroped="";}
$nro=mysql_real_escape_string($_POST['TxtNroInterno']);if($nro!='0' and $nro!=''){$wnro="and npi.NroOC='$nro'";}else{$wnro="";}
$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and npi.IdProv=$prov";}else{$wprov="";}

//buscar articulo/item
$wnom="";
if ( !(empty($_POST['TxtBusqueda'])) ){	
	$wnom="and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
}

$where=$wfechad.' '.$wfechah.' '.$wnro.' '.$wnom.' '.$wprov.' '.$wnroped;
?>