<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



function BAR_datos_persona($doc,$id,$conn){//persona
	$res='';
	$id=intval($id);
	$doc=trim($doc);
	if($doc!=''){
		//traigo el ultimo registro de ese dni
		$query="SELECT Chofer FROM procesosop_e2 Where DNI='$doc' and DNI<>'' and Id<>$id Order by Id desc LIMIT 1";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)!=0){
			$res= $row['Chofer'];
		}mysql_free_result($rs);
	}
	return $res;
}	










function BAR_ingresos($conn){
	$res=0;$ingresos=0;$egresos=0;
	//querys base
	$querypersonas="SELECT Id,Etapa FROM procesosop_e2 WHERE DATEDIFF(Fecha,'".date("Y-m-d")."')=0";
	$querycamiones="SELECT Id,Etapa FROM procesosop_e1 WHERE DATEDIFF(Fecha,'".date("Y-m-d")."')=0";	
	//traigo ingresos hoy
	$query="SELECT count(x.Id) as Cant FROM ($querypersonas UNION ALL $querycamiones)x WHERE x.Etapa=0";
	$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)!=0){$ingresos=$row10['Cant'];}mysql_free_result($rs10);
	//traigo egresos hoy
	$query="SELECT count(x.Id) as Cant FROM ($querypersonas UNION ALL $querycamiones)x WHERE x.Etapa=1";
	$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
	if(mysql_num_rows($rs10)!=0){$egresos=$row10['Cant'];}mysql_free_result($rs10);
	//resultado
	$res=$ingresos-$egresos;
	return $res;
}



//construye el combo con strpad
function GLO_CbProcesos($campo,$idcli,$conn){
	if($idcli==0){$where="";}else{$where="and p.IdCliente=$idcli";}
	//procesos abiertos
	$query="SELECT p.Id,p.Fecha,c.Nombre FROM procesosop p,clientes c where p.Id<>0 and p.IdCliente=c.Id and p.Estado=0 $where Order by Id";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$texto=str_pad($row['Id'], 5, "0", STR_PAD_LEFT).'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']).'&nbsp;&nbsp;'.substr($row['Nombre'],0,30);
		//
		if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";  }else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;mysql_free_result($rs);
}
function GLO_CbProcesosRO($campo,$idproc,$conn){ 
	$query="SELECT p.Id,p.Fecha,c.Nombre FROM procesosop p,clientes c where p.Id<>0 and p.IdCliente=c.Id and p.Id=$idproc Order by Id";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$texto=str_pad($row['Id'], 5, "0", STR_PAD_LEFT).'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']).'&nbsp;&nbsp;'.substr($row['Nombre'],0,30);
		//
		if( $row['Id'] == $_SESSION[$campo]) {			
			$combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$texto."</option>\n";
		}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;mysql_free_result($rs);
}


function PROC_CbTipoEtapa($campo,$tipo){

	if($tipo==0){//selecciona
		$combo='<option value=""></option>';
		if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."INGRESO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."INGRESO"."</option>\n";}
		if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."EGRESO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."EGRESO"."</option>\n";}
	}else{//muestra
		$combo='';
		if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."INGRESO"."</option>\n";}
		if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."EGRESO"."</option>\n";}
	}
	echo $combo;
}


function PROC_CbTipoUnidadFilter($campo){
	$combo='<option value=""></option>';
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PROPIO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PROPIO"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."TERCEROS"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."TERCEROS"."</option>\n";}
	echo $combo;
}

function PROC_TipoUnidad($tipo){
	$res='';if($tipo==1){$res='PROPIO';}if($tipo==2){$res='TERCEROS';}
	return $res;
}

function PROC_CbTipoUnidad($campo){//una vez que modifica no puede cambiar
	if($_SESSION[$campo]==0){
		$combo='<option value=""></option>';
		if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PROPIO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PROPIO"."</option>\n";}
		if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."TERCEROS"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."TERCEROS"."</option>\n";}
	}else{
		$combo='';
		if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PROPIO"."</option>\n";}
		if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."TERCEROS"."</option>\n";}
	}
	echo $combo;
}

function PROC_CbTipoBarrera($campo){//persona/vehiculo
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PERSONA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PERSONA"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."VEH&Iacute;CULO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."VEH&Iacute;CULO"."</option>\n";}
	echo $combo;
}
function PROC_CbTipoBarreraP($campo){//persona
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PERSONA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PERSONA"."</option>\n";}
	echo $combo;
}
function PROC_CbTipoBarreraV($campo){//vehiculo
	$combo="";
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."VEH&Iacute;CULO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."VEH&Iacute;CULO"."</option>\n";}
	echo $combo;
}

	

function PROC1_TablaItems($idpadre,$conn){//padre procesosop_e1
$idpadre=intval($idpadre);
$query="SELECT m.*,u.Abr as Uni ,i.Nombre as Item,e.Nombre as Env From procesosop_e1_it m,items i,unidadesmedida u,envases e where m.IdIC=i.Id and m.Id<>0 and m.IdU=u.Id and m.IdEnv=e.Id and m.IdPadre=$idpadre Order by i.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="950" class="TableShow TMT10" id="tshow"><tr>';
$tablaclientes .='<td width="300" class="TableShowT" > Producto</td>';   
$tablaclientes .='<td width="50" class="TableShowT" > Unidad</td>';   
$tablaclientes .='<td width="50" class="TableShowT TAR" > Cantidad</td>'; 
$tablaclientes .='<td width="50" class="TableShowT TAR" > Ingreso Planta</td>'; 
$tablaclientes .='<td width="70" class="TableShowT" > Envase</td>';  
$tablaclientes .='<td width="100" class="TableShowT" > Lote</td>';
$tablaclientes .='<td width="50" class="TableShowT TAR" > Bultos</td>'; 
$tablaclientes .='<td width="100" class="TableShowT" > Destino</td>'; 
$tablaclientes .='<td width="50" class="TableShowT TAR" > COA</td>';  
$tablaclientes .='<td width="80" class="TableShowT" > Estado COA</td>'; 
$tablaclientes .='<td width="30" class="TableShowT TAR">';
$tablaclientes .=GLO_FAButton('CmdAdd','submit','','self','Agregar','add','iconbtn'); 
$tablaclientes .='</td></tr>';             
$estilo=" style='cursor:pointer;' "; 
$total=0;$totali=0;$totalb=0;$uni=0;$uniok=0; //0:init, 1:ok, 2:dif  
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarItem.php?Flag1=True"."&id=".$row['Id']."'";
	//estado
	CAM_estadoitemingreso($row['Id'],$idcam,$idestado,$estado,$conn);	
	if($idcam==0){$idcam='';}else{$idcam=str_pad($idcam, 5, "0", STR_PAD_LEFT);}
	//suma total y compara unidades
	$total= $total+$row['Cant'];$totali= $totali+$row['CantI']; $totalb= $totalb+$row['Bultos'];
	if($uniok==0){ $uni=$row['IdU'];$uniok=1;}//toma primer unidad
	if($uniok==1){ if($row['IdU']!=$uni){$uniok=2;} }//descarta total si hay alguna distinta
	//
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Item'],0,36)."</td>"; 
	$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Uni'],0,12)."</td>";
	$tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Cant']."</td>";
	$tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['CantI']."</td>";
	$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Env'],0,10)."</td>";  
	$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Lote'],0,15)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Bultos']."</td>";
	$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Destino'],0,12)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$idcam."</td>"; 
	$tablaclientes .='<td  class="TableShowD"'.$link.' style="font-weight:bold;'.CAM_colorestado($idestado).'"'."> ".substr($estado,0,10)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">'; 
	if($idcam==0){
		$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	}	
	$tablaclientes .="</td></tr>";  
}mysql_free_result($rs);	
//total muestra si las unidades coinciden 
if($uniok==1 and $total>0){$total=number_format($total, 2);$totali=number_format($totali, 2);}else{$total='';$totali='';}//cantidad
if($totalb>0){$totalb=number_format($totalb, 2);}else{$totalb='';}//bultos
$tablaclientes .='<tr><td  class="TableShowD TAR TBlue" colspan="3">'.$total.'</td><td  class="TableShowD TAR TBlue">'.$totali.'</td><td  class="TableShowD" colspan="2" ></td><td  class="TableShowD TAR TBlue">'.$totalb.'</td><td  class="TableShowD" colspan="4"></td></tr>'; 
//cierra y muestra 	
$tablaclientes .="</table>";echo $tablaclientes;	
}
?>