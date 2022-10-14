<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
$wbuscar='';
if (!(empty($_POST['TxtFechaDST']))){$wbuscar=$wbuscar." and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaDST'])."')>=0";}
if (!(empty($_POST['TxtFechaHST']))){$wbuscar=$wbuscar." and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaHST'])."')<=0";}	
$vbuscar=intval($_POST['CbTipoMS']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdTipoMov=$vbuscar";}
$vbuscar=intval($_POST['CbDeposito']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdDeposito=$vbuscar";}	
$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdCliente=$vbuscar";}
$vbuscar=intval($_POST['CbOrigen']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdOrigen=$vbuscar";}
//buscar articulo/item
if ( !(empty($_POST['TxtBusqueda'])) ){	
    $wbuscar=$wbuscar." and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
}	

//compras
if($origen==0){
    $vbuscar=intval($_POST['CbRubro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdRubro=$vbuscar";}
    $vbuscar=mysql_real_escape_string($_POST['TxtNroOC']);if($vbuscar!='0' and $vbuscar!=''){$wbuscar=$wbuscar." and npi.NroOC='$vbuscar'";}
    //tipo item
    $vbuscar=intval($_POST['CbTipo']);
    if($vbuscar==1){$wbuscar=$wbuscar." and i.IdItem=0";}//articulo
    if($vbuscar==2){$wbuscar=$wbuscar." and i.IdArticulo=0";}//producto
}

//planta
if($origen==1){
    $wbuscar=$wbuscar." and d.Tipo=1";//depositos tipo planta
    $vbuscar=intval($_POST['TxtIdCAM']);if($vbuscar!=0){$wbuscar=$wbuscar." and (s.IdCAM=$vbuscar or i.IdCAM=$vbuscar)";}
    $vbuscar=intval($_POST['TxtNroPedido']);if($vbuscar!=0){$wbuscar=$wbuscar." and (s.IdPedido=$vbuscar or i.IdPedido=$vbuscar)";}
    $vbuscar=intval($_POST['ChkTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdOrigen=3 and s.IdTipoMov=3 and i.IdCAM=0";}
}
//
mysql_close($conn); 
//query
$query="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,p.Apellido as Proveedor,a.Nombre as Articulo,i.Cantidad,i.IdArticulo,u.Abr,np.Id as IdNP,npi.NroOC,i.Id as IdIST,i.IdCAM as IdCAMi,per.Nombre as NAudi,per.Apellido as AAudi,il.Nombre as Prod,il.Id as IdProd,c.Nombre as Cliente,u2.Abr as Abr2 From stockmov s,depositos d,stock_tipomov t,proveedores p,stockmov_items i,epparticulos a,unidadesmedida u,co_npedido np,co_npedido_it npi,personal per,items il,clientes c,unidadesmedida u2 where i.IdItemNP=npi.Id   and np.Id=npi.IdNP and s.IdDeposito=d.Id and s.IdTipoMov=t.Id and s.IdProveedor=p.Id and i.IdMov=s.Id and i.IdArticulo=a.Id and i.IdItem=il.Id and a.IdUnidad=u.Id and per.Id=i.IdUser and s.IdCliente=c.Id and il.IdUnidad=u2.Id $wbuscar Order by s.Fecha,s.Id,np.Id";

?>