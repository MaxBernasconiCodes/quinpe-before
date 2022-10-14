<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


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
	//tipo planta
	$wbuscar=$wbuscar." and a.IdTipo IN(1,2,4,5,6) ";//almacenamiento(7) va por inbox.php
	//estado planta(etapa)
	$vbuscar=intval($_POST['CbEstado']);//fin planta es 3 
	if($vbuscar==1){$wbuscar=$wbuscar." and a.IdEstadoP<3";}
	if($vbuscar==2){$wbuscar=$wbuscar." and a.IdEstadoP>2";}
	
	//pedidos con items
	$_SESSION['TxtQPLAIBPM']="SELECT distinct a.Id,a.Fecha,a.Hora,a.IdPadre,a.IdEstadoP,a.Rto ,cli.Nombre as Cliente,t.Abr as Tipo From despacho a,clientes cli,despacho_it a1,despacho_tipo t where a.Id<>0 and a1.Id<>0 and a.IdCliente=cli.Id and t.Id=a.IdTipo and a1.IdPadre=a.Id $wbuscar Order by a.Fecha,cli.Nombre,a.Id";
	header("Location:InboxP.php");
}






?>