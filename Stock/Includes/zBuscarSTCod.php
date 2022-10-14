<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
$wbuscar='';
if (!(empty($_POST['TxtFechaDST']))){$wbuscar=$wbuscar." and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaDST'])."')>=0";}
if (!(empty($_POST['TxtFechaHST']))){$wbuscar=$wbuscar." and DATEDIFF(s.Fecha,'".FechaMySql($_POST['TxtFechaHST'])."')<=0";}
$vbuscar=intval($_POST['CbTipoMS']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdTipoMov=$vbuscar";}
$vbuscar=intval($_POST['CbDeposito']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdDeposito=$vbuscar";}	
$vbuscar=intval($_POST['TxtNro']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.Nro=$vbuscar";}
$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.Id=$vbuscar";}
$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdCliente=$vbuscar";}

//compras
if($origen==0){
    $vbuscar=intval($_POST['CbProv']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdProveedor=$vbuscar";}
}

//planta
if($origen==1){
    $wbuscar=$wbuscar." and d.Tipo=1";//depositos tipo planta
    $vbuscar=intval($_POST['TxtIdCAM']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdCAM=$vbuscar";}
    $vbuscar=intval($_POST['TxtNroPedido']);if($vbuscar!=0){$wbuscar=$wbuscar." and s.IdPedido=$vbuscar";}
}


//query
$query="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,c.Nombre as Cliente,o.Nombre as Ori,p.Apellido as Proveedor From stockmov s,depositos d,stock_tipomov t,clientes c,stockmov_origen o,proveedores p  where s.IdDeposito=d.Id and s.IdTipoMov=t.Id and s.IdCliente=c.Id and s.IdOrigen=o.Id and s.IdProveedor=p.Id $wbuscar Order by s.Fecha,s.Id";

?>