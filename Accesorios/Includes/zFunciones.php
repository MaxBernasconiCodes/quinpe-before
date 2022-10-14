<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



function ASIG_validarquien($equi,$uni){
	if($equi!=0){
		$error=0;$total=0;
		if ($uni!=0){$uni=1;}
		$total=$uni;
		//
		if($total==0){$error=1;$_SESSION['GLO_msgE']="Por favor seleccione Unidad";}
		if($total>1){$error=1;$_SESSION['GLO_msgE']="Por favor seleccione Unidad";}
	}else{
		$error=1;$_SESSION['GLO_msgE']="Por favor seleccione Equipo";
	}
	return $error;
}





function ASIG_validarfecha($id,$idinstr,&$fechasok,$fechaa,$fechae,$fechab,$conn){
	//where insert/update ($id=0 es insert)
	if($id==0){$whereupd="";}else{$whereupd="and Id<>$id";}
	//devolucion pactada: valido que hasta sea mayor o igual que desde
	if($fechae!='0000-00-00' and  CompararFechas($fechaa,$fechae)==1){//entrega > devolucion pactada
		$fechasok=0;
		$_SESSION['GLO_msgE']='La fecha de devolucion pactada debe ser mayor o igual que la de entrega';
	}
	//devolucion real: valido que hasta sea mayor o igual que desde (solo update)
	if($id!=0 and $fechasok==1 and $fechab!='0000-00-00' and  CompararFechas($fechaa,$fechab)==1){
		$fechasok=0;
		$_SESSION['GLO_msgE']='La fecha de devolucion debe ser mayor o igual que la de entrega';
	}
	//verifica que no este asignado actualmente o posteriormente
	if($fechasok==1){
		$asignado=0;
		$query="SELECT Id FROM accesorios_asig Where IdInstrumento=$idinstr and ( FechaH='0000-00-00' or (DATEDIFF(FechaD,'".$fechaa."')>0) )  $whereupd";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)!=0){$asignado=$row['Id'];}mysql_free_result($rs);
		if($asignado!=0){$fechasok=0;$_SESSION['GLO_msgE']='El Equipo tiene asignaciones posteriores';}
	}

	//verifica que la fecha de asignacion sea posterior a la ultima
	if($fechasok==1 and $id==0){//solo insert
		$asignado=0;
		$query="SELECT Id FROM accesorios_asig Where IdInstrumento=$idinstr and FechaH<>'0000-00-00' and DATEDIFF(FechaH,'".$fechaa."')>0";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$asignado=$row['Id'];}mysql_free_result($rs);
		if($asignado!=0){$fechasok=0;$_SESSION['GLO_msgE']='El Equipo tiene asignaciones posteriores';}	
	}
}
		

	  
?>
