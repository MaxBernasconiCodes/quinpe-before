<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//trae maximo x registros debido a error por max_post_size

if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//criterios
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}
	$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Id=$nroped";}else{$wnroped="";}
	//buscar articulo/item
	$wnom="";
	if ( !(empty($_POST['TxtBusqueda'])) ){	
		$wnom="and ( (a.Id<>0 and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or a.Id=".intval($_POST['TxtBusqueda'])."))  or (il.Id<>0 and (il.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or il.Id=".intval($_POST['TxtBusqueda']).")) )";
	}
	$where=$wfechad.' '.$wfechah.' '.$wnom.' '.$wnroped;
	mysql_close($conn);	
	//ITEMS DE NP  que no esten asociados a ningun remito egreso ni ajuste egreso y que esten autorizados(3)
	$_SESSION['TxtQSTCOMPRAR']="SELECT np.IdUnidad,np.IdPersonal,np.IdInstr,np.IdSectorM,np.Fecha,npi.IdNP,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,npi.INC,e.Nombre as Estado, a.Id as IdArticuloItem, a.Nombre as Articulo,a.Stock as FS,um.Abr,u.Nombre as Unidad,u.Dominio,p3.Nombre as NomD,p3.Apellido as ApeD,sm.Nombre as SectorM,itr.Nombre as Equipo,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,unidades u,personal p3,sectorm sm,epparticulos itr,items il,unidadesmedida u2  Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and np.IdUnidad=u.Id and np.IdPersonal=p3.Id and np.IdSectorM=sm.Id and np.IdInstr=itr.Id and npi.IdEstado=3 and npi.IdItem=il.Id and il.IdUnidad=u2.Id $where and npi.Id NOT IN(Select i.IdItemNP From stockmov_items i,stockmov sm  Where i.IdMov=sm.Id and (sm.IdTipoMov=2 or sm.IdTipoMov=4))  Order by np.Id,a.Nombre,il.Nombre LIMIT 2000"; 	
	header("Location:Comprar.php");
}





elseif (isset($_POST['CmdComprar'])){	 
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//datos item
		$aListaid=array_keys($_POST['campos']);
		$fecha=FechaMySql(date("d-m-Y"));
		foreach($aListaid as $iId) {
			$iIdItemNP=intval($iId);
			$query="UPDATE co_npedido_it set IdEstado=8,FechaComprar='$fecha' Where Id=$iIdItemNP";$rs=mysql_query($query,$conn);	
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQSTCOMPRAR']=$_POST['TxtQSTCOMPRAR'];
	header("Location:Comprar.php");
}

elseif (isset($_POST['CmdCompletar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQSTCOMPRAR']=$_POST['TxtQSTCOMPRAR'];
	header("Location:CompletarArticuloC.php?IdItem=".intval($_POST['TxtId']));
}


elseif (isset($_POST['CmdDividir'])){
	$iditemnp=intval($_POST['TxtId']);
	$aListacant1=$_POST['TxtCant1'];//array valor cant item 1
	$aListacant2=$_POST['TxtCant2'];//array valor cant item 2
	$aListacant3=$_POST['TxtCant3'];//array valor cant total item 
	$cant1=floatval($aListacant1[$iditemnp]);$cant2=floatval($aListacant2[$iditemnp]);$cant3=floatval($aListacant3[$iditemnp]);
	//valida que divida ok
	if( (($cant1+$cant2)!= $cant3) or $cant1==0 or $cant2==0){
		$_SESSION['GLO_msgE']='Las cantidades no coinciden, por favor verifique';
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//busco original
		$query="SELECT * From co_npedido_it where Id=$iditemnp";$rs=mysql_query($query,$conn);
		while($row=mysql_fetch_array($rs)){
			$iditem=$row['IdArticulo'];$iditem2=$row['IdItem'];
			$ident=$row['IdNP'];$cant=$row['Cant'];$canta=$cant2;$prov=$row['IdProv'];$est=$row['IdEstado'];
			$obs=$row['Obs'];$fa=$row['FechaAuto'];$fpa=$row['FechaPAuto'];$fcom=$row['FechaComprar'];$finc=$row['INC'];
		}mysql_free_result($rs);
		//inserto  copiado	
		include("../ComprobantesCo/Includes/zAltaNPI.php");
		if ($rs){
			GLO_feedback(1);
			//actualizo original
			$query="Update co_npedido_it set CantAuto=$cant1 where Id=$iditemnp";$rs=mysql_query($query,$conn);		
		}else{GLO_feedback(2);} 
		mysql_close($conn);	
	}
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQSTCOMPRAR']=$_POST['TxtQSTCOMPRAR'];
	header("Location:Comprar.php");
}


?>