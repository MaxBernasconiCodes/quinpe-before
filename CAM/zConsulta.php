<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//filtros
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbProducto']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdProducto=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdE=$vbuscar";}
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['TxtNro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Rto Like '%".$vbuscar."%'";}
	$vbuscar=mysql_real_escape_string($_POST['TxtLote']);if($vbuscar!=''){$wbuscar=$wbuscar." and a.Lote Like '%".$vbuscar."%'";}
	//
	$_SESSION['TxtQCAM']="Select a.*,cli.Nombre as Cliente,p.Nombre as Producto,e.Nombre as Est From cam a,clientes cli,items p,cam_est e Where a.Id<>0 and  a.IdCliente=cli.Id and a.IdProducto=p.Id and a.IdE=e.Id $wbuscar Order by a.Fecha,cli.Nombre,p.Nombre";
	//
	mysql_close($conn); 
	header("Location:../CAM.php");
}



if (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$idcam=intval($_POST['TxtId']);
	$query="Delete From cam Where Id=$idcam";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}
	else{
		//obtengo origen cam
		$formulado=0;
		$query="SELECT IdPE2IT FROM cam Where Id=$idcam";$rs10=mysql_query($query,$conn);
		$row10=mysql_fetch_array($rs10);if(mysql_num_rows($rs10)!=0){
			if($row10['IdPE2IT']!=0){$formulado=1;}
		}mysql_free_result($rs10);
		//valido si es formulado, libero item stock
		if($formulado==1){
			$query="UPDATE stockmov_items set IdCAM=0 Where IdCAM=$idcam";$rs=mysql_query($query,$conn);
			//borro nuevamente
			if ($rs){
				$query="Delete From cam Where Id=$idcam";$rs=mysql_query($query,$conn);
				if ($rs){GLO_feedback(1);}else{GLO_feedback(31);}
			}
		}else{GLO_feedback(31);}	
	} 
	mysql_close($conn); 
	header("Location:../CAM.php"); 	
}




if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQCAM']=$_POST['TxtQCAM'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}





?>