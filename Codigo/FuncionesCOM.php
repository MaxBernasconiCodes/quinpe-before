<?php include("Seguridad.php") ;

//locales
function GLO_CbSINO($campo){
$combo="";
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."SI"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."SI"."</option>\n";}
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."NO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."NO"."</option>\n";}
echo $combo;
}

function ComboEstadoCivil(){ 
$combo="";
if( "CASADO/A" == $_SESSION['CbEC']) { $combo .= " <option value="."'CASADO/A'"." selected='selected'>"."CASADO/A"."</option>\n";}
else{$combo .= " <option value="."'CASADO/A'"." >"."CASADO/A"."</option>\n";}
if( "DIVORCIADO/A" == $_SESSION['CbEC']) { $combo .= " <option value="."'DIVORCIADO/A'"." selected='selected'>"."DIVORCIADO/A"."</option>\n";}else{$combo .= " <option value="."'DIVORCIADO/A'"." >"."DIVORCIADO/A"."</option>\n";}
if( "SOLTERO/A" == $_SESSION['CbEC']) { $combo .= " <option value="."'SOLTERO/A'"." selected='selected'>"."SOLTERO/A"."</option>\n";}else{$combo .= " <option value="."'SOLTERO/A'"." >"."SOLTERO/A"."</option>\n";}
if( "VIUDO/A" == $_SESSION['CbEC']) { $combo .= " <option value="."'VIUDO/A'"." selected='selected'>"."VIUDO/A"."</option>\n";}
else{$combo .= " <option value="."'VIUDO/A'"." >"."VIUDO/A"."</option>\n";}
if( "CONCUBINO/A" == $_SESSION['CbEC']) { $combo .= " <option value="."'CONCUBINO/A'"." selected='selected'>"."CONCUBINO/A"."</option>\n";}else{$combo .= " <option value="."'CONCUBINO/A'"." >"."CONCUBINO/A"."</option>\n";}
echo $combo;
}

function ComboCUIT(){ 
$combo="";
if( "CUIL" == $_SESSION['CbCUIT']) { $combo .= " <option value="."'CUIL'"." selected='selected'>"."CUIL"."</option>\n";}
else{$combo .= " <option value="."'CUIL'"." >"."CUIL"."</option>\n";}
if( "CUIT" == $_SESSION['CbCUIT']) { $combo .= " <option value="."'CUIT'"." selected='selected'>"."CUIT"."</option>\n";}
else{$combo .= " <option value="."'CUIT'"." >"."CUIT"."</option>\n";}
echo $combo;
}

function ComboDocumento(){ 
$combo="";
if( "DNI" == $_SESSION['CbDocumento']) { $combo .= " <option value="."'DNI'"." selected='selected'>"."DNI"."</option>\n";}
else{$combo .= " <option value="."'DNI'"." >"."DNI"."</option>\n";}
if( "CF" == $_SESSION['CbDocumento']) { $combo .= " <option value="."'CF'"." selected='selected'>"."CF"."</option>\n";}
else{$combo .= " <option value="."'CF'"." >"."CF"."</option>\n";}
if( "LC" == $_SESSION['CbDocumento']) { $combo .= " <option value="."'LC'"." selected='selected'>"."LC"."</option>\n";}
else{$combo .= " <option value="."'LC'"." >"."LC"."</option>\n";}
if( "LE" == $_SESSION['CbDocumento']) { $combo .= " <option value="."'LE'"." selected='selected'>"."LE"."</option>\n";}
else{$combo .= " <option value="."'LE'"." >"."LE"."</option>\n";}
if( "PAS" == $_SESSION['CbDocumento']) { $combo .= " <option value="."'PAS'"." selected='selected'>"."PAS"."</option>\n";}
else{$combo .= " <option value="."'PAS'"." >"."PAS"."</option>\n";}
echo $combo;
}


function ComboEstadoISO_NC(){
$combo="";
if( "1" == $_SESSION['CbEstadoNC']) { $combo .= " <option value="."'1'"." selected='selected'>"."ABIERTO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ABIERTO"."</option>\n";}
if( "2" == $_SESSION['CbEstadoNC']) { $combo .= " <option value="."'2'"." selected='selected'>"."CUMPLIDO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."CUMPLIDO"."</option>\n";}
if( "3" == $_SESSION['CbEstadoNC']) { $combo .= " <option value="."'3'"." selected='selected'>"."CERRADO"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."CERRADO"."</option>\n";}
if( "4" == $_SESSION['CbEstadoNC']) { $combo .= " <option value="."'4'"." selected='selected'>"."INCUMPLIDO"."</option>\n";}else{$combo .= " <option value="."'4'"." >"."INCUMPLIDO"."</option>\n";}
if( "5" == $_SESSION['CbEstadoNC']) { $combo .= " <option value="."'5'"." selected='selected'>"."REPROGRAMADO"."</option>\n";}else{$combo .= " <option value="."'5'"." >"."REPROGRAMADO"."</option>\n";}
echo $combo;
}

function ComboISOOrigenDoc(){
$combo="";
if( "1" == $_SESSION['CbOrigen']) { $combo .= " <option value="."'1'"." selected='selected'>"."EXTERNO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."EXTERNO"."</option>\n";}
if( "2" == $_SESSION['CbOrigen']) { $combo .= " <option value="."'2'"." selected='selected'>"."INTERNO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."INTERNO"."</option>\n";}
echo $combo;
}

function ComboMoneda($campo){
	$combo="";
	if( "0" == $_SESSION[$campo]) { $combo .= " <option value="."'0'"." selected='selected'>"."PESOS"."</option>\n";}else{$combo .= " <option value="."'0'"." >"."PESOS"."</option>\n";}
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."DOLARES"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."DOLARES"."</option>\n";}
	echo $combo;
}

function ComboUnidMedInstrumentos($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."C"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."C"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."BAR"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."BAR"."</option>\n";}
	if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."F"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."F"."</option>\n";}
	echo $combo;
}

function ComboVerifInstrumentos($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."INTERNA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."INTERNA"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."EXTERNA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."EXTERNA"."</option>\n";}
	echo $combo;
}

function GLO_CbTipoEquipo($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."FIJO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."FIJO"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."MOVIL"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."MOVIL"."</option>\n";}
	echo $combo;
}

function ComboPRQUrg($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."BAJA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."BAJA"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."MEDIA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."MEDIA"."</option>\n";}
	if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."ALTA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."ALTA"."</option>\n";}
	echo $combo;
}








//genericas
function GLO_ComboActivo($tabla,$campo,$orden,$arbol,$where,$conn){//solo muestra dado de baja si es el asignado
	$query="SELECT Id,Nombre,FechaBaja FROM $tabla where Id<>0 $where Order by $orden";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$campo]))){
			if( $row['Id'] == $_SESSION[$campo]) 
			{$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['Nombre']."</option>\n";
			}else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }
		}
	}echo $combo;
}


function ComboTablaRFX($tabla,$campo,$orden,$arbol,$where,$conn){
$query="SELECT Id,Nombre FROM $tabla where Id<>0 $where Order by $orden";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['Nombre']."</option>\n";
  }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }}
echo $combo;
}
function ComboTablaRFXActivo($tabla,$campo,$orden,$arbol,$where,$conn){
$query="SELECT Id,Nombre FROM $tabla where Id<>0 and (FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',FechaBaja)<0)  $where Order by $orden";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['Nombre']."</option>\n";
  }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }}
echo $combo;
}
function ComboTablaRFROX($tabla,$campo,$orden,$arbol,$sel,$where,$conn){ //construye el combo con un solo dato ($sel)
$query="SELECT Id,Nombre FROM $tabla where Id=$sel";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$campo]) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$row['Nombre']."</option>\n";
 }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }}
echo $combo;
}




//construye el combo con strpad
function ComboTablaRFNX($tabla,$campo,$orden,$cant,$arbol,$where,$conn){//construye el combo con strpad
$query="SELECT Id FROM $tabla where Id<>0 $where Order by $orden";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".str_pad($row['Id'], $cant, "0", STR_PAD_LEFT)."</option>\n";
  }else{ $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], $cant, "0", STR_PAD_LEFT)."</option>\n";   }}
echo $combo;
}
function ComboTablaRFNROX($tabla,$campo,$orden,$arbol,$cant,$sel,$where,$conn){ 
	$query="SELECT Id FROM $tabla where Id=$sel";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	  if( $row['Id'] == $_SESSION[$campo]) {
	   $combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".str_pad($row['Id'], $cant, "0", STR_PAD_LEFT)."</option>\n";
	 }else{ $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], $cant, "0", STR_PAD_LEFT)."</option>\n";   }}
	echo $combo;
}
	

//construye el combo con strpad
function GLO_CbComprobante($tabla,$campo,$orden,$cant,$arbol,$where,$conn){//construye el combo con strpad
	$query="SELECT Id,Fecha FROM $tabla where Id<>0 $where Order by $orden";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$texto=str_pad($row['Id'], $cant, "0", STR_PAD_LEFT).'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']);
		if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";  }else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;
}
function GLO_CbComprobanteV($tabla,$campo,$orden,$cant,$arbol,$where,$conn){//construye el combo con strpad

	$query="SELECT a.Id,a.Fecha,c.Nombre FROM $tabla a,clientes c where a.Id<>0 and a.IdCliente=c.Id $where Order by $orden";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$texto=str_pad($row['Id'], $cant, "0", STR_PAD_LEFT).'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']).'&nbsp;&nbsp;'.substr($row['Nombre'],0,30);
		if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";  }else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;
}

function GLO_CbComprobanteRO($tabla,$campo,$orden,$arbol,$cant,$sel,$where,$conn){ 
	$query="SELECT Id,Fecha FROM $tabla where Id=$sel";$rs=mysql_query($query,$conn);
	$combo="";$texto='';
	while($row=mysql_fetch_array($rs)){ 
		if( $row['Id'] == $_SESSION[$campo]) {
		$texto=str_pad($row['Id'], $cant, "0", STR_PAD_LEFT).'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']);
		$combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$texto."</option>\n";
		}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;
}
	

  

//masivo
function ComboTablaRFXMasivo($tabla,$campo,$orden,$arbol,$where,$conn){
	$query="SELECT Id,Nombre FROM $tabla where Id<>0 $where Order by $orden";$rs10=mysql_query($query,$conn);
	$combo="";
	while($row10=mysql_fetch_array($rs10)){ 
	  if( $row10['Id'] == $campo) {$combo .= " <option value='".$row10['Id']."' selected='"."selected"."'>".$row10['Nombre']."</option>\n";
	  }else{ $combo .= " <option value='".$row10['Id']."'>".$row10['Nombre']."</option>\n";   }}
	mysql_free_result($rs10);
	return $combo;
}
	
function ComboTablaRFXMasivoPers($campo,$where,$conn){
	$idsel=intval($campo);//id dato seleccionado
	$query="SELECT Id,Apellido,Nombre,FechaBaja FROM personal where Id<>0 and (Id=$idsel or FechaBaja='0000-00-00' or DATEDIFF('".date("Y-m-d"). "',FechaBaja)<0) $where Order by Apellido, Nombre";
	$rs10=mysql_query($query,$conn);
	$combo="";
	while($row10=mysql_fetch_array($rs10)){ 
		if( $row10['Id'] == $idsel) {
			$combo .= " <option value='".$row10['Id']."' selected='"."selected". "'>".substr($row10['Apellido'].' '.$row10['Nombre'],0,50)."</option>\n";
		}else{$combo .= " <option value='".$row10['Id']."'>".substr($row10['Apellido'].' '.$row10['Nombre'],0,50)."</option>\n";}
	}mysql_free_result($rs10); 	 
	return $combo;
}


function ComboTablaRFXMasivoUni($campo,$where,$conn){
	$query="SELECT Id,Dominio,Nombre,FechaBaja FROM unidades where Id<>0 $where Order by Nombre,Dominio";
	$rs10=mysql_query($query,$conn);
	$combo="";
	while($row10=mysql_fetch_array($rs10)){ 
	if(($row10['FechaBaja']=='0000-00-00') or ($row10['FechaBaja']!='0000-00-00' and ($row10['Id'] == $campo))){
		$texto=$row10['Id'].'&nbsp;&nbsp;'.$row10['Nombre'].'&nbsp;&nbsp;'.$row10['Dominio'];
		if( $row10['Id'] == $campo) {$combo .= " <option value='".$row10['Id']."' selected='"."selected"."'>".$texto."</option>\n";
		}else{ $combo .= " <option value='".$row10['Id']."'>".$texto."</option>\n";   }
	}
	}
	mysql_free_result($rs10);
	return $combo;
	}
	
		




//unidades
function GLO_ComboActivoUni($tabla,$campo,$orden,$arbol,$where,$conn){//solo muestra dado de baja si es el asignado
$query="SELECT Id,Dominio,Nombre,FechaBaja FROM $tabla where Id<>0 $where Order by Nombre,Dominio";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$campo]))){
	$texto=$row['Nombre'].'&nbsp;&nbsp;'.$row['Dominio'];
	if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";
	}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }}
}echo $combo;
}
function GLO_ComboActivoUniRO($tabla,$campo,$orden,$arbol,$sel,$where,$conn){ //construye el combo con un solo dato ($sel)
$query="SELECT Id,Dominio,Nombre FROM $tabla where Id=$sel";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
	$texto=$row['Nombre'].'&nbsp;&nbsp;'.$row['Dominio'];
	if( $row['Id'] == $_SESSION[$campo]) {
	$combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$texto."</option>\n";
	}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }}
echo $combo;
}


//servicios quinpe
function CompletarComboServicioRFX($nombre,$conn){ //solo muestra dado de baja si es el asignado
	$query="SELECT se.Id,se.FechaBaja,c.Nombre as Cli,s1.Nombre as CC FROM servicios se,clientes c,serviciostipo1 s1 where se.Id<>0 and se.IdCliente=c.Id and se.IdTipo=s1.Id Order by c.Nombre,s1.Nombre";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	$texto=substr($row['Cli'],0,20).', '.substr($row['CC'],0,30);
	if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$nombre]))){
		if( $row['Id'] == $_SESSION[$nombre]){$combo.="<option value='".$row['Id']."' selected='"."selected". "'>".$texto."</option>\n";}
		else{$combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";}
	} 
	}echo $combo;
}

function ComboServicioCliente($campo,$cliente,$conn){//solo muestra dado de baja si es el asignado
	$query="SELECT se.Id,se.FechaBaja,s1.Nombre as LineaA FROM servicios se,serviciostipo1 s1 where se.Id<>0 and se.IdTipo=s1.Id and se.IdCliente=$cliente Order by s1.Nombre";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$campo]))){
			if( $row['Id'] == $_SESSION[$campo]) 
			{$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['LineaA']."</option>\n";
			}else{ $combo .= " <option value='".$row['Id']."'>".$row['LineaA']."</option>\n";   }
		}
	}echo $combo;
}


function ComboServicioRO($campo,$sel,$conn){ //construye el combo con un solo dato ($sel)
	$query="SELECT se.Id,s1.Nombre as LineaA FROM servicios se,serviciostipo1 s1 where se.Id<>0 and se.IdTipo=s1.Id and se.Id=$sel";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	  if( $row['Id'] == $_SESSION[$campo]) {
	   $combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$row['LineaA']."</option>\n";
	 }else{ $combo .= " <option value='".$row['Id']."'>".$row['LineaA']."</option>\n";   }}
	echo $combo;
}





function ComboPersonalRFX($nombre,$conn){  
	$idsel=intval($_SESSION[$nombre]);//id dato seleccionado
	$query="SELECT Id,Apellido,Nombre,FechaBaja FROM personal where Id<>0 and (Id=$idsel or FechaBaja='0000-00-00' or DATEDIFF('".date("Y-m-d"). "',FechaBaja)<0) Order by Apellido, Nombre";
	$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		if( $row['Id'] == $idsel) {
			$combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</option>\n";
		}else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</option>\n";}
	}mysql_free_result($rs); 	 
	echo $combo;
}
  

function ComboPersonalRFROX($nombre,$actual,$conn){ 
$query="SELECT Id,Apellido,Nombre,FechaBaja FROM personal where Id<>0 and Id=$actual";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
	if( $row['Id'] == $_SESSION[$nombre]) {
		$combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</option>\n";
	}else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</option>\n";}
} 
echo $combo;
}


//proveedores
function ComboProveedorRFX($nombre,$where,$conn){  //solo muestra dado de baja si es el asignado
$query="SELECT Id,Apellido,Nombre,FechaBaja FROM proveedores where Id<>0 $where Order by Apellido";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
	if($row['Nombre']!=""){$fantasia=" (".$row['Nombre'].")";}else{$fantasia="";}
	if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$nombre]))){
	  if( $row['Id'] == $_SESSION[$nombre]) {
	   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".$row['Apellido'].$fantasia."</option>\n";
	 }else{$combo .= " <option value='".$row['Id']."'>".$row['Apellido'].$fantasia."</option>\n";}} 
}echo $combo;
}
function ComboProveedorRFROX($nombre,$sel,$where,$conn){ 
$query="SELECT Id,Apellido,Nombre,FechaBaja FROM proveedores where Id=$sel";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
	if($row['Nombre']!=""){$fantasia=" (".$row['Nombre'].")";}else{$fantasia="";}
  	if( $row['Id'] == $_SESSION[$nombre]) {$combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".$row['Apellido'].$fantasia."</option>\n";
 	}else{$combo .= " <option value='".$row['Id']."'>".$row['Apellido'].$fantasia."</option>\n";}
} echo $combo;
}

//equipos
function GLO_ComboEquipos($campo,$tabla,$conn){//solo muestra dado de baja si es el asignado
	if($tabla=='epparticulos'){$w='and EPP=2';}else{$w='';}//para quinpe
	//
	  $query="SELECT Id,Nombre,NSE,FechaBaja FROM $tabla where Id<>0 $w Order by Nombre";
	  $rs=mysql_query($query,$conn);
	  $combo="";
	  while($row=mysql_fetch_array($rs)){ 
		  if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$campo]))){
			  if($row['NSE']!=''){$texto=$row['Nombre'].' NSE:'.$row['NSE'];}else{$texto=$row['Nombre'];}
			  if( $row['Id'] == $_SESSION[$campo]) 
			  {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";
			  }else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
		  }
	  }echo $combo;
  }
function GLO_ComboEquiposRO($campo,$sel,$tabla,$conn){//solo muestra dado de baja si es el asignado
	$query="SELECT Id,Nombre,NSE,FechaBaja FROM $tabla where Id<>0 and Id=$sel";
	$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
			if($row['NSE']!=''){$texto=$row['Nombre'].' NSE:'.$row['NSE'];}else{$texto=$row['Nombre'];}
			if( $row['Id'] == $_SESSION[$campo]) 
			{$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";
			}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
		
	}echo $combo;
}


function ComboISOReqRFX($campo,$conn){//solo muestra dado de baja si es el asignado
$query="Select d.*,n.Nombre as Norma From iso_nc_req d,iso_nc_norma n Where d.Id<>0 and d.IdNorma=n.Id Order By n.Nombre,d.Nro";
$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
if(($row['FechaBaja']=='0000-00-00') or ($row['FechaBaja']!='0000-00-00' and ($row['Id'] == $_SESSION[$campo]))){
	$texto=$row['Norma'].' | '.$row['Nro'].' | '.$row['Nombre'];
	if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";
	}else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }}
}echo $combo;
}


///quinpe
function GLO_CbMedioRecepcion($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."EMAIL"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."EMAIL"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."TELEFONO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."TELEFONO"."</option>\n";}
    if( "4" == $_SESSION[$campo]) { $combo .= " <option value="."'4'"." selected='selected'>"."PERSONALMENTE"."</option>\n";}else{$combo .= " <option value="."'4'"." >"."PERSONALMENTE"."</option>\n";}
    if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."CORREO"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."CORREO"."</option>\n";}
    echo $combo;
}
function GLO_VerMedioRecepcion($id){
    $res='';
    switch ($id) {
		case 1: $res='EMAIL'; break;
		case 2: $res='TELEFONO'; break;
		case 3: $res='CORREO'; break;
		case 4: $res='PERSONALMENTE'; break;
    }
    return $res;
}


function GLO_CbTipoItem($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."ARTICULO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ARTICULO"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."PRODUCTO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."PRODUCTO"."</option>\n";}
    echo $combo;
}

function GLO_CbEstadoASIG($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."SIN DEVOLVER"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."SIN DEVOLVER"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."DEVUELTOS"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."DEVUELTOS"."</option>\n";}
    if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>".""."</option>\n";}else{$combo .= " <option value="."'3'"." >".""."</option>\n";}
    echo $combo;
}


///
function GLO_CbComprobanteBQ($tabla,$campo,$orden,$cant,$arbol,$where,$conn){//buscar quinpe
	//no pone strpad para poder buscar	
	$query="SELECT a.Id,a.Fecha,c.Nombre FROM $tabla a,clientes c where a.Id<>0 and a.IdCliente=c.Id $where Order by $orden";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$texto=$row['Id'].'&nbsp;&nbsp;'.FormatoFecha($row['Fecha']).'&nbsp;&nbsp;'.substr($row['Nombre'],0,30);
		if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$texto."</option>\n";  }else{ $combo .= " <option value='".$row['Id']."'>".$texto."</option>\n";   }
	}echo $combo;
}


?>