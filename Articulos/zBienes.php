<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	$wbuscar='';
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbRubro']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdRubro=$vbuscar";}

	//nombre
	if (!(empty($_POST['TxtBusqueda']))){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wbuscar=$wbuscar." and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";
		mysql_close($conn); 
	}	
	//
	$activo=intval($_POST['ChkActivo']);
	if($activo!=0){
		$wbuscar=$wbuscar." and (a.FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',a.FechaBaja)<0)";
	}
	//estado
	$disponibles=intval($_POST['ChkReq']);
	$asignados=intval($_POST['ChkF1']);
	//query asignados sin devolver
	$queryasignados="SELECT a.Id,a.Nombre,a.NSE,a.Modelo,a.FechaBaja, m.Nombre as Marca, r.Nombre as Rubro,aa.IdPersonal,aa.IdUnidad,aa.IdSectorM,p.Nombre as Nom,p.Apellido as Ape,u.Dominio,u.Nombre as Uni,s.Nombre as Sector From epparticulos a,marcas m, rubros r,instrumentosasig aa ,personal p,unidades u, sectorm s where a.Id<>0 and a.IdMarca=m.Id and a.IdRubro=r.Id and aa.IdInstrumento=a.Id and aa.IdPersonal=p.Id and aa.IdUnidad=u.Id and aa.IdSectorM=s.Id and a.EPP=2 $wbuscar and  aa.FechaH='0000-00-00'";
	//query disponibles, no estan asignados actualmente
	$querysinasignar="SELECT a.Id,a.Nombre,a.NSE,a.Modelo,a.FechaBaja, m.Nombre as Marca, r.Nombre as Rubro,'' as IdPersonal,'' as IdUnidad,'' as IdSectorM,'' as Nom, '' as Ape,'' as Dominio,'' as Uni,'' as Sector From epparticulos a,marcas m, rubros r where a.Id<>0 and a.IdMarca=m.Id and a.IdRubro=r.Id and a.EPP=2 $wbuscar and a.Id NOT IN(SELECT IdInstrumento From instrumentosasig where Id<>0 and FechaH='0000-00-00')";
	//
	if($disponibles==$asignados){$_SESSION['TxtQArtBI']="$queryasignados UNION $querysinasignar Order by FechaBaja,Nombre";}
	if($disponibles==1 and $asignados==0){$_SESSION['TxtQArtBI']="$querysinasignar Order by FechaBaja,Nombre";}
	if($disponibles==0 and $asignados==1){$_SESSION['TxtQArtBI']="$queryasignados Order by FechaBaja,Nombre";}
	header("Location:Bienes.php");
}





?>