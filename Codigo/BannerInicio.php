<? include("Seguridad.php");?>

<!--banner-->
<table  height="100%" width="100%"  cellpadding="0"  cellspacing="0" border="0" align="center" class="fondo">
<tr> <td height="1px" style="width:30%"> </td><td style="width:70%;"></td></tr>
<tr  class="bannerIMG2"> <td class="bannerintra banner"></td><td class="banner"> 
	
<? 
include("Config.php");
$_SESSION["GLO_IdSistema"]=0;
$idpers=intval($_SESSION["GLO_IdPersLog"]);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


//pendientes
//personal logueado (no aplica a proveedores)	
if($idpers!=0){
	$tienetareas=0;

	//pedidos compra autorizar/preautorizar
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		$query="Select distinct np.Id,np.Fecha,np.Titulo From co_npedido np,co_npedido_it npi Where np.Id<>0  and np.Id=npi.IdNP and ((np.IdPerPAuto=$idpers and npi.IdEstado=1) or (np.IdPerAuto=$idpers and (npi.IdEstado=2 or npi.IdEstado=1))) LIMIT 1";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienetareas=1;}mysql_free_result($rs);		
	}

	//iso
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		//minutas
		if( $tienetareas==0 ){
			$query="Select Id From iso_minutas_pd Where Id<>0 and IdPersonal=$idpers and Estado=0 LIMIT 1";
			$rs=mysql_query($query,$conn);
			$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienetareas=1;}mysql_free_result($rs);	
		}	

		//documentos controlar
		if( $tienetareas==0 and ($_SESSION["GLO_IdPersCON"]==$idpers) ){
			$query="Select Id From iso_doc Where Id<>0 and (IdEstado=1 or IdEstado=5) LIMIT 1";$rs=mysql_query($query,$conn);
			$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienetareas=1;}mysql_free_result($rs);		
		}	

		//documentos aprobar
		if( $tienetareas==0 and ($_SESSION["GLO_IdPersAPR"]==$idpers) ){	
			$query="Select Id From iso_doc Where Id<>0 and IdEstado=2 LIMIT 1";$rs=mysql_query($query,$conn);
			$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienetareas=1;}mysql_free_result($rs);		
		}
	}


	//muestra tareas
	if($tienetareas==1){
		echo '<a href="'.$_SESSION["NivelArbol"].'NotificacionesT.php"><i class="fa fa-thumbtack iconvsmall TRed"></i> Pendientes </a>';
		echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	}
}







//notificaciones
//si se logueo personal o admin sistema
if($idpers!=0 or intval($_SESSION['IdPerfilUser'])==1 ){
	$tienenotif=0; 
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));	
	//unidades
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		$query1="SELECT p.Id From unidades p,unidadesvtos v,unidadesvtos_tipos t where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and v.Inactivo=0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.Fecha)>0) LIMIT 1";
		//Poliza Seg.Automotor
		$query2="SELECT p.Id From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSA and p.IdPSA<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0) LIMIT 1";
		//Poliza Seg.Tecnico
		$query3="SELECT p.Id From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPST and p.IdPST<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0) LIMIT 1";
		//Poliza Seg.RCC
		$query4="SELECT p.Id From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSRCC and p.IdPSRCC<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0) LIMIT 1";
		//todo	
		$query="$query1 UNION $query2 UNION $query3 UNION $query4";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
	}
	//personal
	if($tienenotif==0){
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==11){
			$query="SELECT p.Id From personal p,personalvtos v,personalvtos_tipos t  where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and  v.Inactivo=0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.Fecha)>0) LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	//articulos
	if($tienenotif==0){
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			$query="SELECT p.Id From epparticulos p where p.Id<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',p.FechaV)>0) LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	//accesorios asignaciones
	if($tienenotif==0){//sin devolver, con fecha pactada de devolucion vencida o dentro de 14 dias
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			$query="SELECT p.Id From accesorios_asig p where p.Id<>0 and p.FechaH='0000-00-00' and p.FechaE<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaE)>0 LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	//instrumentos asignaciones
	if($tienenotif==0){//sin devolver, con fecha pactada de devolucion vencida o dentro de 14 dias
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			$query="SELECT p.Id From instrumentosasig p where p.Id<>0 and p.FechaH='0000-00-00' and p.FechaE<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaE)>0 LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	/*
	//accesorios certificaciones
	if($tienenotif==0){//con vto, con fecha vto vencida o dentro de 14 dias
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			$query="SELECT p.Id From accesorios_prog p where p.Id<>0 and p.FechaReal<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaReal)>0 LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	//instrumentos certificaciones
	if($tienenotif==0){//con vto, con fecha vto vencida o dentro de 14 dias
		if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			$query="SELECT p.Id From instrumentosprog p where p.Id<>0 and p.FechaReal<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaReal)>0 LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $tienenotif=1;}mysql_free_result($rs);
		}
	}
	*/



	//muestra bell
	if($tienenotif==1){
		echo '<a href="'.$_SESSION["NivelArbol"].'Notificaciones.php"><i class="fa fa-bell iconvsmall TRed"></i> Notificaciones </a>';
		echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	}
}



//salir
echo '<a href="'.$_SESSION["NivelArbol"].'Codigo/Logout.php"><i class="fa fa-sign-out-alt iconvsmall"></i> Salir </a>&nbsp;';
//desconecto
mysql_close($conn);
?>


</td></tr>
<!--cuerpo-->
<tr> <td colspan="2" width="100%"  height="100%"  align="center" valign="top">     
<table  width="100%"  height="100%" cellpadding="0" cellspacing="0" border="0" align="center"  >
<tr><td align="center" valign="top" colspan="2">