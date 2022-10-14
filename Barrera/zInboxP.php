<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdTipo=$vbuscar";}
	$vbuscar=intval($_POST['TxtRto']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Rto=$vbuscar";}
	//tipo salida
	$wbuscar=$wbuscar." and a.IdTipo IN(3,5,6,7) ";
	//estado
	$vbuscar=intval($_POST['CbEstado']);
	$fromestado='';$whereestado='';
	if($vbuscar!=0){
		if($vbuscar==1){//pendiente(solicitud abierta) que no paso x barrera ni planta
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=0 and pp.Id NOT IN(SELECT IdPadre FROM procesosop_e1) and a.Id NOT IN(SELECT IdPedido FROM stockmov)';
		}
		if($vbuscar==2){//en proceso (solicitud abierta) que paso x barrera o planta
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=0 and ( pp.Id IN(SELECT IdPadre FROM procesosop_e1) OR a.Id IN(SELECT IdPedido FROM stockmov) )';

		}
		if($vbuscar==3){//finalizado(solicitud cerrada)
			$fromestado=',procesosop pp';$whereestado='and a.IdPadre=pp.Id and pp.Estado=1';

		}
	}
	//
	$_SESSION['TxtQBARIP']="SELECT distinct a.Id,a.Fecha,a.Hora,a.IdTipo,a.IdPadre,a.Rto,cli.Nombre as Cliente,t.Abr as Tipo From despacho a,clientes cli,despacho_it a1,despacho_tipo t $fromestado where a.Id<>0 and a1.Id<>0 and a.IdCliente=cli.Id and a1.IdPadre=a.Id and t.Id=a.IdTipo $whereestado $wbuscar Order by a.Fecha,cli.Nombre,a.Id";
	header("Location:InboxP.php");
}






?>