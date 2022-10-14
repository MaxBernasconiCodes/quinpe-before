<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");



///ESTADO DEL PROCESO
function PROC_BuscarEstado($idetapa,$idpadre,$conn){//$idpadre estado del proceso procesosop
	//busco cantidad items ingreso
	$cantitemsi=0;
	$query="SELECT count(pi.Id) as CantIt FROM procesosop_e1 p,procesosop_e1_it pi Where p.Id=pi.IdPadre and p.Etapa=0 and p.IdPadre=$idpadre";
	$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)!=0){$cantitemsi=$row10['CantIt'];}mysql_free_result($rs10);
	//trae estado etapa
	$estado=99;	
	//estado etapa (el 8 se unifico con el 4)
	switch ($idetapa) {
		case 1:	 PROC_1Barrera($idpadre,$estado,$cantitemsi);break;//barrera
		case 2:	 PROC_2Laboratorio($idpadre,$estado,$cantitemsi,$conn);break;//laboratorio
		case 3:	 PROC_3Planta($idpadre,$estado,$cantitemsi,$conn);break;//planta
		case 4:	 PROC_4Despacho($idpadre,$estado,$cantitemsi,$conn);break;//logistica
		case 6:	 PROC_6Laboratorio($idpadre,$estado,$cantitemsi,$conn);break;//laboratorio
		case 10: PROC_10Barrera($idpadre,$estado,$cantitemsi,$conn);break;//barrera
	}
	return $estado;
}


function PROC_ColorEstado($idetapa,$idpadre,$conn){//$idpadre estado del proceso procesosop
	//trae estado etapa
	$estado=PROC_BuscarEstado($idetapa,$idpadre,$conn);
	//variables
	$icon='';$res='';
	//valido estado
	switch ($estado) {
	case 0:	$icon='TLRed';break;//pendiente
	case 1:	$icon='TLOrange';break;//en proceso
	case 2:	$icon='TLGreen';break;//finalizado
	}
	//
	if($icon!=''){$res='<i class="fa fa-circle '.$icon.'" style="font-size: 1.1rem;"></i>';}
	return $res;
}

///////////

function PROC_4Despacho($idpadre,&$estado,$cantitemsi,$conn){//$idpadre estado del proceso procesosop, almac/formulado/carga
	$query="SELECT p.Id FROM despacho p Where p.IdPadre=$idpadre LIMIT 1";$rs10=mysql_query($query,$conn);
	if(mysql_num_rows($rs10)!=0){$estado=2;}mysql_free_result($rs10);
}

function PROC_1Barrera($idpadre,&$estado,$cantitemsi){//$idpadre estado del proceso procesosop
	if($cantitemsi!=0){$estado=2;}
}

function PROC_2Laboratorio($idpadre,&$estado,$cantitemsi,$conn){//$idpadre estado del proceso procesosop
	if($cantitemsi!=0){
		$cantgreen=0;$cantyellow=0;
		$query="SELECT c.IdE FROM cam c,procesosop_e1 p,procesosop_e1_it pi Where c.IdPE1IT=pi.Id and p.Etapa=0 and p.Id=pi.IdPadre and p.IdPadre=$idpadre";$rs10=mysql_query($query,$conn);
		while($row10=mysql_fetch_array($rs10)){
			if($row10['IdE']==2 or $row10['IdE']==4){$cantgreen++;}	//aceptado o no lleva	
			else{$cantyellow++;}	
		}mysql_free_result($rs10);	
		//valido estado 1 en proceso, 2finalizado
		if($cantitemsi==$cantgreen){$estado=2;}else{if($cantgreen!=0 or $cantyellow!=0){$estado=1;}}
	}	
}

function PROC_3Planta($idpadre,&$estado,$cantitemsi,$conn){//$idpadre estado del proceso procesosop
	//me fijo si es un despacho formulado/carga
	$query="SELECT p.Id FROM despacho p Where p.IdPadre=$idpadre and p.IdEstadoP>2 LIMIT 1";$rs10=mysql_query($query,$conn);
	if(mysql_num_rows($rs10)!=0){$estado=2;}mysql_free_result($rs10);
	//valida almacenamiento
	if($estado!=2){
		if($cantitemsi!=0){ 
			$canttotal=0;$cantingresada=0;
			//asigna finalizado si no tiene cantidades pendientes
			$query="SELECT i.Cant,i.CantI FROM procesosop_e1 p,procesosop_e1_it i Where i.IdPadre=p.Id and p.Etapa=0 and p.IdPadre=$idpadre";$rs10=mysql_query($query,$conn);
			while($row10=mysql_fetch_array($rs10)){
				$encuentra=1;
				$canttotal=$canttotal+$row10['Cant'];$cantingresada=$cantingresada+$row10['CantI'];
			}mysql_free_result($rs10);
			//valido estado 1 en proceso, 2finalizado
			if($canttotal>$cantingresada and $canttotal!=0 and $cantingresada!=0){$estado=1;}//en proceso
			if($canttotal==$cantingresada and $canttotal!=0){$estado=2;}//finalizado
		}
	}
}

function PROC_6Laboratorio($idpadre,&$estado,$cantitemsi,$conn){//$idpadre estado del proceso procesosop
	$canttotal=0;$cantfin=0;
	//rto ingreso formulado sin cam
	$query="SELECT c.IdE,a2.IdCAM FROM cam c,stockmov a1,stockmov_items a2,despacho p Where a2.IdCAM=c.Id and a2.IdMov=a1.Id and a1.IdPedido=p.Id and a1.IdOrigen=3 and a1.IdTipoMov=3 and p.IdPadre=$idpadre";$rs10=mysql_query($query,$conn);
	while($row10=mysql_fetch_array($rs10)){
		if($row10['IdCAM']!=0){
			if($row10['IdE']==2 or $row10['IdE']==4){$cantfin++;}//aceptado o no lleva	
			$canttotal++;
		}
	}mysql_free_result($rs10);
	//valido estado
	if($canttotal>0){$estado=1;}//en proceso
	if($canttotal==$cantfin and $canttotal!=0){$estado=2;}//finalizado
}

function PROC_10Barrera($idpadre,&$estado,$cantitemsi,$conn){//$idpadre estado del proceso procesosop
	//egreso
	$cantitemse=0;
	$query="SELECT count(p.Id) as CantIt FROM procesosop_e1 p Where p.Etapa=1 and p.IdPadre=$idpadre";
	$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)!=0){$cantitemse=$row10['CantIt'];}mysql_free_result($rs10);
	if($cantitemse!=0){$estado=2;}
}

///////////

function PROC_CbEstadoProceso($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."ABIERTO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ABIERTO"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."CERRADO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."CERRADO"."</option>\n";}
	echo $combo;
}

///////

function PROC_solicitudplanta($idcam,$idpedido,$idorigen,$conn){//busco la solicitud del 
	$idpadre="";
	//viene de ingreso barrera
	if($idcam!=0 and $idorigen==5){
		$query="SELECT p.IdPadre FROM cam c,procesosop_e1 p,procesosop_e1_it pi Where c.IdPE1IT=pi.Id and p.Id=pi.IdPadre and c.Id=$idcam";$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
		if(mysql_num_rows($rs10)!=0){$idpadre=str_pad($row10['IdPadre'], 6, "0", STR_PAD_LEFT);}
		mysql_free_result($rs10);
	}
	//viene de formulado
	if($idpedido!=0 and ($idorigen==3 or $idorigen==4)){
		$query="SELECT p.IdPadre FROM despacho p Where p.Id=$idpedido";$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
		if(mysql_num_rows($rs10)!=0){$idpadre=str_pad($row10['IdPadre'], 6, "0", STR_PAD_LEFT);}
		mysql_free_result($rs10);
	}
	return $idpadre;
}





?>