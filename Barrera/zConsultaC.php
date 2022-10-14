<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("../Procesos/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	//fecha
	if (!(empty($_POST['TxtFDBARC']))){$fecha=GLO_FechaMySql($_POST['TxtFDBARC']);}else{$fecha=GLO_FechaMySql(date("d-m-Y"));}
	$wbuscar=$wbuscar." and DATEDIFF(a2.Fecha,'".$fecha."')=0";
	//persona
	$vbuscar=intval($_POST['TxtDoc']);if($vbuscar!=0){$wbuscar=$wbuscar." and (a2.DNI='$vbuscar' or p.Documento='$vbuscar') ";}$vbuscar=intval($_POST['CbPersonal']);if($vbuscar!=0){$wbuscar=$wbuscar." and a2.IdChofer=$vbuscar";}	
	//
	$wbuscar=$wbuscar." and a2.Etapa=0";//ingreso
	//ingreso personas
	$querypersonas="SELECT a2.Id,a2.Chofer,a2.DNI,a2.Hora,a2.Tipo,a2.IdChofer,p.Nombre as NCH,p.Apellido as ACH,p.Documento,'PERSONA' as TipoB From procesosop_e2 a2,personal p Where a2.Id<>0 and a2.IdChofer=p.Id $wbuscar";
	//ingreso vehiculos
	$querycamiones="SELECT a2.Id,a2.Chofer,a2.DNI,a2.Hora,a2.Tipo,a2.IdChofer,p.Nombre as NCH,p.Apellido as ACH,p.Documento,'VEH&Iacute;CULO' as TipoB  From procesosop_e1 a2,personal p Where a2.Id<>0 and a2.IdChofer=p.Id $wbuscar";
	//
	$_SESSION['TxtQPROCBARC']="SELECT x.* From ($querypersonas UNION ALL $querycamiones)x Order by x.Hora,x.Id";
	//vuelve
	header("Location:ConsultaC.php");
}




?>