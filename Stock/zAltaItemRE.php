<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//trae maximo x registros debido a error por max_post_size

if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	include("Includes/zFiltrosItemsCod.php");
	mysql_close($conn);	
	//ITEMS DE OC  que no esten asociados a ningun remito egreso ni ajuste egreso
	$_SESSION['TxtQSTREIT']="SELECT np.IdUnidad,np.IdPersonal,np.IdInstr,np.IdSectorM,np.Fecha,npi.NroOC,np.Id as IdNP,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem, a.Id as IdArticuloItem, a.Nombre as Articulo,a.Stock as FS,um.Abr,p.Apellido as Prov,u.Nombre as Unidad,u.Dominio,p3.Nombre as NomD,p3.Apellido as ApeD,sm.Nombre as SectorM,itr.Nombre as Equipo,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,epparticulos a,unidadesmedida um,proveedores p,unidades u,personal p3,sectorm sm,epparticulos itr,items il,unidadesmedida u2  Where np.Id=npi.IdNP and npi.IdArticulo=a.Id and npi.IdItem=il.Id and a.IdUnidad=um.Id and np.IdUnidad=u.Id and npi.IdProv=p.Id and np.IdPersonal=p3.Id and np.IdSectorM=sm.Id and np.IdInstr=itr.Id and il.IdUnidad=u2.Id and npi.NroOC<>'0' and npi.NroOC<>'' $where and npi.Id NOT IN(Select i.IdItemNP From stockmov_items i,stockmov sm  Where i.IdMov=sm.Id and (sm.IdTipoMov=2 or sm.IdTipoMov=4)) LIMIT 2000"; 	
	header("Location:AltaItemRE.php?Id=".intval($_POST['TxtNroEntidad']));
}



elseif (isset($_POST['CmdGuardar'])){	 
	$idcompr=intval($_POST['TxtNroEntidad']);
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro
		//datos remito
		$query="SELECT * From stockmov where Id=$idcompr";$rs=mysql_query($query,$conn);
		while($row=mysql_fetch_array($rs)){
			$iddep=$row['IdDeposito'];$idtipo=$row['IdTipoMov'];$idcliprop=$row['IdCliente'];
		}mysql_free_result($rs);
		//datos item
		$aListaid=array_keys($_POST['campos']);
		$aListacant=$_POST['TxtCant'];
		$idcam=0;$etapaproc=0;
		foreach($aListaid as $iId) {
			list($iIdNP,$iIdItemNP,$iditem,$iditem2)=explode("|",$iId);
			$iIdNP=intval($iIdNP);$iIdItemNP=intval($iIdItemNP);$iditem=intval($iditem);$iditem2=intval($iditem2);	
			$cant=$aListacant[$iIdItemNP];if($cant==''){$cant=0;}	
			if($idtipo==1 or $idtipo==3){$cantcs=$cant;}else{$cantcs=-$cant;}	
			//inserto item
			$nroId=GLO_generoID("stockmov_items",$conn);
			$query="INSERT INTO stockmov_items (Id,IdMov,IdArticulo,Cantidad,CantidadCS,IdNP,IdItemNP,IdUser,IdItem,IdCAM,IdPedido,IdUniIT,IdEnvIT,LoteIT,Etapa,CantSinFactor) VALUES ($nroId,$idcompr,$iditem,$cant,$cantcs,$iIdNP,$iIdItemNP,0,0,$paudi,$iditem2,$idcam,0,0,0,'',0,0)";	$rs=mysql_query($query,$conn);
			if($rs){include("Includes/zAltaMovStock.php");}		
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQSTREIT']=$_POST['TxtQSTREIT'];
	header("Location:AltaItemRE.php?Id=".intval($_POST['TxtNroEntidad']));
}

?>