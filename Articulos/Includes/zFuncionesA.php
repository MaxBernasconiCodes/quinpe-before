<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


function ASIG_validarquien($equi,$per,$uni,$sec){
	if($equi!=0){
		$error=0;$total=0;
		if ($per!=0){$per=1;}if ($uni!=0){$uni=1;}if ($sec!=0){$sec=1;}
		$total=$per+$uni+$sec;
		//
		if($total==0){$error=1;$_SESSION['GLO_msgE']="Por favor seleccione Personal, Unidad o Sector";}
		if($total>1){$error=1;$_SESSION['GLO_msgE']="Por favor seleccione Personal, Unidad o Sector, solo uno";}
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
		$query="SELECT Id FROM instrumentosasig Where IdInstrumento=$idinstr and ( FechaH='0000-00-00' or (DATEDIFF(FechaD,'".$fechaa."')>0) )  $whereupd";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)!=0){$asignado=$row['Id'];}mysql_free_result($rs);
		if($asignado!=0){$fechasok=0;$_SESSION['GLO_msgE']='El Equipo tiene asignaciones posteriores';}
	}

	//verifica que la fecha de asignacion sea posterior a la ultima
	if($fechasok==1 and $id==0){//solo insert
		$asignado=0;
		$query="SELECT Id FROM instrumentosasig Where IdInstrumento=$idinstr and FechaH<>'0000-00-00' and DATEDIFF(FechaH,'".$fechaa."')>0";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$asignado=$row['Id'];}mysql_free_result($rs);
		if($asignado!=0){$fechasok=0;$_SESSION['GLO_msgE']='El Equipo tiene asignaciones posteriores';}	
	}

}
		
	


function ASIG_MostrarAsignadosPersonal($idpadre,$conn){//idpadre es id personal (sin devolver)
	$query="SELECT ia.*,i.Nombre From instrumentosasig ia,epparticulos i where ia.Id<>0 and i.Id=ia.IdInstrumento and ia.IdPersonal=$idpadre and FechaH='0000-00-00' Order by ia.FechaD";$rs=mysql_query($query,$conn);
	//tabla
	$tablaclientes='';
	$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."480"." class="."TableShowT"."> Instrumento</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>"; 
	$tablaclientes .="<td "."width="."170"." class="."TableShowT".">Observaciones</td>";  
	$tablaclientes .='<td width="40" class="TableShowT TAR"></td>'; 
	$tablaclientes .='</tr>';        
	$recuento=0; $estilo="";$link="";
	while($row=mysql_fetch_array($rs)){ 
		if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".str_pad($row['IdInstrumento'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,50)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$ti."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR"></td>';  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}


function ASIG_MostrarAsignadosUnidad($idpadre,$conn){//idpadre es id unidad (sin devolver)
	$query="SELECT ia.*,i.Nombre From instrumentosasig ia,epparticulos i where ia.Id<>0 and i.Id=ia.IdInstrumento and ia.IdUnidad=$idpadre and FechaH='0000-00-00' Order by ia.FechaD";$rs=mysql_query($query,$conn);
	//tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."460"." class="."TableShowT"."> Instrumento</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>"; 
	$tablaclientes .="<td "."width="."170"." class="."TableShowT".">Observaciones</td>";  
	$tablaclientes .='<td width="40" class="TableShowT TAR"></td>'; 
	$tablaclientes .='</tr>';        
	$recuento=0; $estilo="";$link="";
	while($row=mysql_fetch_array($rs)){ 
		if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".str_pad($row['IdInstrumento'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,50)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$ti."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR"></td>';  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}


?>