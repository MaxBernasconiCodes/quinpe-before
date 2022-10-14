<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("../Procesos/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['TxtNro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.Rto Like '%".$vbuscar."%'";}
	$vbuscar=intval($_POST['CbEtapa']);
	if($vbuscar==1){$wbuscar=$wbuscar." and a2.Etapa=0";}
	if($vbuscar==2){$wbuscar=$wbuscar." and a2.Etapa=1";}
	//
	$_SESSION['TxtQPROCBARIT']="Select a2.Id,a2.IdPadre,a2.Fecha,a2.Hora,a2.Retorno,cli.Nombre as Cliente,m.Id as IdIte1 ,i.Nombre as Item,a2.Etapa From procesosop a,clientes cli,procesosop_e1 a2,procesosop_e1_it m,items i  Where a.Id<>0 and a.IdCliente=cli.Id and a2.IdPadre=a.Id and m.IdPadre=a2.Id and m.IdIC=i.Id and m.Id<>0 $wbuscar Order by a2.Fecha,a2.Hora,a2.Id";
	header("Location:Items.php");
}



elseif (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQPROCBARIT']=$_POST['TxtQPROCBARIT'];
	header("Location:ModificarItem.php?id=".intval($_POST['TxtId'])."&Flag1=True");	
}





?>