<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//tipo: 
if (isset($_POST['CmdBuscar'])){ 
	$consulta="";
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtQ1']='';$_SESSION['TxtQ2']='';$_SESSION['TxtQ3']='';$_SESSION['TxtQ4']='';$_SESSION['TxtQ5']='';$_SESSION['TxtQ6']='';$_SESSION['TxtQ7']='';
	if ((intval($_POST['TxtNroInterno'])!=0) and (!(empty($_POST['CbComp'])))){	
		$nrocompr=intval($_POST['TxtNroInterno']);
		$tipoc=intval($_POST['CbComp']);
		switch ($tipoc) {
		case 1://PIN
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_npedido_est e Where np.IdProv=p.Id and np.IdEstado=e.Id and np.Id=$nrocompr Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_it pci,co_pcotiz_est e Where pc.IdProv=p.Id and pc.IdEstado=e.Id and pci.IdPCotiz=pc.id and pci.IdNPedido=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_it ocoi,co_ocompra_est e Where oco.IdProv=p.Id and oco.IdEstado=e.Id and ocoi.IdOCompra=oco.id and ocoi.IdNPedido=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,co_facturas_it fi,proveedores p,co_facturas_est e,co_ocompra_it ocoi Where f.IdProv=p.Id and f.IdEstado=e.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id and ocoi.IdNPedido=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_facturas f,co_facturas_it fi,proveedores p,co_ocompra_it ocoi,co_nc nc Where nc.IdProv=p.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id and nc.IdFC=f.Id and ocoi.IdNPedido=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,stockmov_items si,co_ocompra_it ocoi Where s.IdProveedor=p.Id and s.IdTipoMov=3 and si.IdMov=s.Id and si.IdItemOC=ocoi.Id and ocoi.IdNPedido=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc,co_facturas f,co_facturas_it fi,co_ocompra_it ocoi Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.IdFC=f.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id  and ocoi.IdNPedido=$nrocompr Order by s.Id";
			break;
		case 2://COT
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_pcotiz_it pci,co_npedido_est e Where np.IdProv=p.Id and np.IdEstado=e.Id and pci.IdNPedido=np.id and pci.IdPCotiz=$nrocompr Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_est e Where pc.IdProv=p.Id and pc.IdEstado=e.Id  and pc.Id=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_it ocoi,co_pcotiz_it pci,co_ocompra_est e Where oco.IdProv=p.Id and oco.IdEstado=e.Id and ocoi.IdOCompra=oco.id and ocoi.IdNPedido=pci.IdNPedido and pci.IdPCotiz=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,co_facturas_it fi,proveedores p,co_facturas_est e,co_ocompra_it ocoi,co_pcotiz_it pci Where f.IdProv=p.Id and f.IdEstado=e.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id and ocoi.IdNPedido=pci.IdNPedido and pci.IdPCotiz=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_facturas f,co_facturas_it fi,proveedores p,co_ocompra_it ocoi,co_pcotiz_it pci,co_nc nc Where nc.IdProv=p.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id and ocoi.IdNPedido=pci.IdNPedido and nc.IdFC=f.Id and pci.IdPCotiz=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,stockmov_items si,co_ocompra_it ocoi,co_pcotiz_it pci Where s.IdProveedor=p.Id and s.IdTipoMov=3 and si.IdMov=s.Id and si.IdItemOC=ocoi.Id and ocoi.IdNPedido=pci.IdNPedido and pci.IdPCotiz=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc,co_facturas f,co_facturas_it fi,co_ocompra_it ocoi,co_pcotiz_it pci Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.IdFC=f.Id and f.Id=fi.IdFactura and fi.IdItemOC=ocoi.Id and ocoi.IdNPedido=pci.IdNPedido and pci.IdPCotiz=$nrocompr Order by s.Id";
			break;
			
		
		case 3://OCO
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_ocompra_it ocoi,co_npedido_est e Where np.IdProv=p.Id and np.IdEstado=e.Id and ocoi.IdNPedido=np.Id and ocoi.IdOCompra=$nrocompr Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_it pci,co_ocompra_it ocoi,co_pcotiz_est e Where pc.IdProv=p.Id and pc.IdEstado=e.Id and pci.IdPCotiz=pc.Id and ocoi.IdNPedido=pci.IdNPedido and ocoi.IdOCompra=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_est e Where oco.IdProv=p.Id and oco.IdEstado=e.Id and oco.Id=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,co_facturas_it fi,proveedores p,co_facturas_est e Where f.IdProv=p.Id and f.IdEstado=e.Id and f.Id=fi.IdFactura and fi.IdOC=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_facturas f,co_facturas_it fi,proveedores p,co_nc nc Where nc.IdProv=p.Id and f.Id=fi.IdFactura and nc.IdFC=f.Id and fi.IdOC=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,stockmov_items si Where s.IdProveedor=p.Id and s.IdTipoMov=3 and si.IdMov=s.Id and si.IdOC=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc,co_facturas f,co_facturas_it fi Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.IdFC=f.Id and f.Id=fi.IdFactura and fi.IdOC=$nrocompr Order by s.Id";
			break;
		case 4://FAC
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_ocompra_it ocoi,co_npedido_est e,co_facturas_it fi Where np.IdProv=p.Id and np.IdEstado=e.Id and ocoi.IdNPedido=np.Id and fi.IdOC=ocoi.IdOCompra and fi.IdFactura=$nrocompr  Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_it pci,co_ocompra_it ocoi,co_pcotiz_est e,co_facturas_it fi Where pc.IdProv=p.Id and pc.IdEstado=e.Id and pci.IdPCotiz=pc.Id and ocoi.IdNPedido=pci.IdNPedido and fi.IdOC=ocoi.IdOCompra and fi.IdFactura=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_est e,co_facturas_it fi Where oco.IdProv=p.Id and oco.IdEstado=e.Id and fi.IdOC=oco.Id and fi.IdFactura=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,proveedores p,co_facturas_est e Where f.IdProv=p.Id and f.IdEstado=e.Id and f.Id=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_facturas f,proveedores p,co_nc nc Where nc.IdProv=p.Id and nc.IdFC=f.Id and f.Id=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,stockmov_items si,co_facturas_it fi Where s.IdProveedor=p.Id and s.IdTipoMov=3 and si.IdMov=s.Id and fi.IdOC=si.IdOC and fi.IdFactura=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc,co_facturas f Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.IdFC=f.Id and f.Id=$nrocompr Order by s.Id";
			break;
		case 5://NC
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_ocompra_it ocoi,co_npedido_est e,co_facturas_it fi,co_nc nc Where np.IdProv=p.Id and np.IdEstado=e.Id and ocoi.IdNPedido=np.Id and fi.IdOC=ocoi.IdOCompra and nc.IdFC=fi.IdFactura and nc.Id=$nrocompr  Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_it pci,co_ocompra_it ocoi,co_pcotiz_est e,co_facturas_it fi,co_nc nc Where pc.IdProv=p.Id and pc.IdEstado=e.Id and pci.IdPCotiz=pc.Id and ocoi.IdNPedido=pci.IdNPedido and fi.IdOC=ocoi.IdOCompra and nc.IdFC=fi.IdFactura and nc.Id=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_est e,co_facturas_it fi,co_nc nc Where oco.IdProv=p.Id and oco.IdEstado=e.Id and fi.IdOC=oco.Id and nc.IdFC=fi.IdFactura and nc.Id=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,proveedores p,co_facturas_est e,co_nc nc Where f.IdProv=p.Id and f.IdEstado=e.Id and nc.IdFC=f.Id and nc.Id=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_nc nc,proveedores p Where nc.IdProv=p.Id and nc.Id=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,stockmov_items si,co_facturas_it fi,co_nc nc Where s.IdProveedor=p.Id and s.IdTipoMov=3 and si.IdMov=s.Id and fi.IdOC=si.IdOC and nc.IdFC=fi.IdFactura and nc.Id=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.Id=$nrocompr Order by s.Id";
			break;
		case 6://RI
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_npedido_est e,stockmov_items si,co_ocompra_it ocoi Where np.IdProv=p.Id and np.IdEstado=e.Id and si.IdOC=ocoi.IdOCompra and ocoi.IdNPedido=np.Id and si.IdMov=$nrocompr Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_est e,stockmov_items si,co_pcotiz_it pci,co_ocompra_it ocoi Where pc.IdProv=p.Id and pc.IdEstado=e.Id and si.IdOC=ocoi.IdOCompra and pci.IdPCotiz=pc.Id and ocoi.IdNPedido=pci.IdNPedido and si.IdMov=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_est e,stockmov_items si Where oco.IdProv=p.Id and oco.IdEstado=e.Id and si.IdOC=oco.Id and si.IdMov=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,proveedores p,co_facturas_est e,co_facturas_it fi,stockmov_items si Where f.IdProv=p.Id and f.IdEstado=e.Id and fi.IdFactura=f.Id and fi.IdOC=si.IdOC and si.IdMov=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_nc nc,proveedores p,co_facturas_it fi,stockmov_items si Where nc.IdProv=p.Id and nc.IdFC=fi.IdFactura and fi.IdOC=si.IdOC and si.IdMov=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p Where s.IdProveedor=p.Id and s.IdTipoMov=3 and s.Id=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p,co_nc nc,co_facturas f,co_facturas_it fi  Where s.IdProveedor=p.Id and s.IdTipoMov=4 and nc.IdRE=s.Id and nc.IdFC=f.Id and f.Id=fi.IdFactura and s.Id=$nrocompr Order by s.Id";
			break;
		case 7://RE
			$_SESSION['TxtQ1']="Select distinct np.*,p.Apellido as Prov,e.Nombre as Estado From co_npedido np,proveedores p,co_npedido_est e,co_ocompra_it ocoi,co_facturas_it fi,co_nc nc Where np.IdProv=p.Id and np.IdEstado=e.Id and ocoi.IdNPedido=np.Id and fi.IdOC=ocoi.IdOCompra and nc.IdFC=fi.IdFactura and nc.IdRE=$nrocompr Order by np.Id";
			$_SESSION['TxtQ2']="Select distinct pc.*,p.Apellido as Prov,e.Nombre as Estado  From co_pcotiz pc,proveedores p,co_pcotiz_est e,co_pcotiz_it pci,co_ocompra_it ocoi,co_facturas_it fi,co_nc nc Where pc.IdProv=p.Id and pc.IdEstado=e.Id and pci.IdPCotiz=pc.Id and ocoi.IdNPedido=pci.IdNPedido and fi.IdOC=ocoi.IdOCompra and nc.IdFC=fi.IdFactura and nc.IdRE=$nrocompr Order by pc.Id";
			$_SESSION['TxtQ3']="Select distinct oco.*,p.Apellido as Prov,e.Nombre as Estado  From co_ocompra oco,proveedores p,co_ocompra_est e,co_facturas_it fi,co_nc nc Where oco.IdProv=p.Id and oco.IdEstado=e.Id and fi.IdOC=oco.Id and nc.IdFC=fi.IdFactura and nc.IdRE=$nrocompr Order by oco.Id";
			$_SESSION['TxtQ4']="Select distinct f.*,p.Apellido as Prov,e.Nombre as Estado From co_facturas f,proveedores p,co_facturas_est e,co_nc nc Where f.IdProv=p.Id and f.IdEstado=e.Id and nc.IdFC=f.Id and nc.IdRE=$nrocompr Order by f.Id";
			$_SESSION['TxtQ5']="Select distinct nc.*,p.Apellido as Prov From co_nc nc,proveedores p Where nc.IdProv=p.Id and nc.IdRE=$nrocompr Order by nc.Id";
			$_SESSION['TxtQ6']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p Where s.IdProveedor=p.Id and s.IdTipoMov=3 and s.Id=$nrocompr Order by s.Id";
			$_SESSION['TxtQ7']="Select distinct s.*,p.Apellido as Prov From stockmov s,proveedores p Where s.IdProveedor=p.Id and s.IdTipoMov=4 and s.Id=$nrocompr Order by s.Id";
			break;
			
		}
	
	}else{GLO_feedback(3); }	
	header("Location:Trazabilidad.php");
}



elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:NotasPedidoD.php");
}




?> 

