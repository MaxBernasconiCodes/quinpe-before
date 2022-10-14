<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


function NP_TieneItemsPreauto($idnp,$conn){//2:preauto
	$query="Select npi.Id From co_npedido_it npi Where npi.Id<>0 and npi.IdEstado>1 and npi.IdNP=$idnp LIMIT 1";$rs2=mysql_query($query,$conn);
	if(mysql_num_rows($rs2)!=0){$resultado=1;}else{$resultado=0;}mysql_free_result($rs2);
	return $resultado;
}
function NP_TieneItemsAuto($idnp,$conn){//3:auto
	$query="Select npi.Id From co_npedido_it npi Where npi.Id<>0 and npi.IdEstado>2 and npi.IdNP=$idnp LIMIT 1";$rs2=mysql_query($query,$conn);
	if(mysql_num_rows($rs2)!=0){$resultado=1;}else{$resultado=0;}mysql_free_result($rs2);
	return $resultado;
}

//buscar OC y Remitos
function NP_TieneOC($idnpi,$conn){// si no tiene RI estan EN PROCESO 
	$query="Select i.Id From co_npedido_it i Where i.NroOC<>'0' and i.NroOC<>''  and i.Id=$idnpi";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$resultado=1;}else{$resultado=0;}mysql_free_result($rs2);
	return $resultado;
}

function NP_TieneRI($idnpi,$conn){//COMPRADOS (tiene OC,  )
	$query="Select i.Id From co_npedido_it i,stockmov_items si Where si.IdItemNP=i.Id and i.NroOC<>'0' and i.NroOC<>'' and i.Id=$idnpi";$rs2=mysql_query($query,$conn);
	if(mysql_num_rows($rs2)!=0){$resultado=1;}else{$resultado=0;}mysql_free_result($rs2);
	return $resultado;
}

function NP_TieneRE($idnpi,$conn){//RESUELTO (no tiene OC, se saca de almacen)
	$query="Select si.Id From co_npedido_it i,stockmov_items si Where i.Id=si.IdItemNP and (i.NroOC='0' or i.NroOC='') and i.Id=$idnpi";$rs2=mysql_query($query,$conn);
	if(mysql_num_rows($rs2)!=0){$resultado=1;}else{$resultado=0;}mysql_free_result($rs2);
	return $resultado;
}

function NP_TraeRINPI($idnpi,$conn){//Trae remito de COMPRADOS (tiene OC,  )
	$query="Select si.IdMov,s.Tipo,s.Suc,s.Nro  From co_npedido_it i,stockmov_items si,stockmov s Where si.IdItemNP=i.Id and si.IdMov=s.Id and i.NroOC<>'0' and i.NroOC<>'' and i.Id=$idnpi";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$resultado=$row2['Tipo'].str_pad($row2['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row2['Nro'], 8, "0", STR_PAD_LEFT);}else{$resultado='';}mysql_free_result($rs2);
	return $resultado;
}






//estado
function NP_BuscarEstadoNPI($idnpi,$estado,$conn){
//verifico si tiene re
if(NP_TieneRE($idnpi,$conn)!=0){$estado='RESUELTO';}//resuelto
else{
	//verifico si tiene oc
	if(NP_TieneOC($idnpi,$conn)==1){$estado='EN PROCESO';}//en proceso
	//verifico si tiene ri
	if(NP_TieneRI($idnpi,$conn)!=0){$estado='COMPRADO';}//comprado
}
return $estado;
}

function NP_BuscarEstadoNPIId($idnpi,$idestado,$conn){
//verifico si tiene re
if(NP_TieneRE($idnpi,$conn)!=0){$idestado=9;}//resuelto
else{
	//verifico si tiene oc
	if(NP_TieneOC($idnpi,$conn)==1){$idestado=6;}//en proceso
	//verifico si tiene ri
	if(NP_TieneRI($idnpi,$conn)!=0){$idestado=7;}//comprado
}
return $idestado;
}

function NP_BuscarEstadoNPIColor($idestado){
$colorest='';
if($idestado=='1'){$colorest=' style="font-weight:bold;color:#000000"';}//abierto
if($idestado=='2'){$colorest=' style="font-weight:bold;color:#ff9900"';}//preauto
if($idestado=='3'){$colorest=' style="font-weight:bold;color:#4CAF50"';}//auto
if($idestado=='4'){$colorest=' style="font-weight:bold;color:#f44336"';}//rech
if($idestado=='5'){$colorest=' style="font-weight:bold;color:#f44336"';}//rech
if($idestado=='6'){$colorest=' style="font-weight:bold;color:#00bcd4"';}//en proceso
if($idestado=='7'){$colorest=' style="font-weight:bold;color:#cc0099"';}//comprado
if($idestado=='8'){$colorest=' style="font-weight:bold;color:#00668e"';}//comprar
if($idestado=='9'){$colorest=' style="font-weight:bold;color:#cc0099"';}//resuelto
return $colorest;
}
function NP_BuscarEstadoNPIColor2($idestado){
$colorest='';
if($idestado=='1'){$colorest=';font-weight:bold;color:#000000';}//abierto
if($idestado=='2'){$colorest=';font-weight:bold;color:#ff9900';}//preauto
if($idestado=='3'){$colorest=';font-weight:bold;color:#4CAF50';}//auto
if($idestado=='4'){$colorest=';font-weight:bold;color:#f44336';}//rech
if($idestado=='5'){$colorest=';font-weight:bold;color:#f44336';}//rech
if($idestado=='6'){$colorest=';font-weight:bold;color:#00bcd4';}//en proceso
if($idestado=='7'){$colorest=';font-weight:bold;color:#cc0099';}//comprado
if($idestado=='8'){$colorest=';font-weight:bold;color:#00668e';}//comprar
if($idestado=='9'){$colorest=';font-weight:bold;color:#cc0099';}//resuelto
return $colorest;
}






//cotizaciones
function CO_BuscarCOTIZ($var,$conn){
	$query="Select distinct p.Id From co_pcotiz p,co_pcotiz_it i,co_pcotiz_est e Where i.IdPCotiz=p.Id and p.IdEstado=e.Id and i.IdItemNP=$var";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$resultado=str_pad($row2['Id'], 6, "0", STR_PAD_LEFT);}else{$resultado='';}mysql_free_result($rs2);
	return $resultado;
}

function CO_BuscarCOTIZ_T($var,$conn){//todas
	$resultado='';
	$query="Select distinct p.Id From co_pcotiz p,co_pcotiz_it i,co_pcotiz_est e Where i.IdPCotiz=p.Id and p.IdEstado=e.Id and i.IdItemNP=$var";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){
		if($resultado==''){$resultado=str_pad($row2['Id'], 6, "0", STR_PAD_LEFT);}
		else{$resultado=$resultado.'  '.str_pad($row2['Id'], 6, "0", STR_PAD_LEFT);} 
	}mysql_free_result($rs2);
	return $resultado;
}






//autorizantes
function NP_EsPreAutorizante($conn){
	$resultado=0;$log=$_SESSION["GLO_IdPersLog"];
	$query="SELECT a.Id FROM co_autorizantes a where a.Id<>0 and a.FechaB='0000-00-00' and a.Tipo=1 and a.IdPersonal=$log";
	$rs2=mysql_query($query,$conn);if(mysql_num_rows($rs2)!=0){$resultado=1;}mysql_free_result($rs2);
	return $resultado;
}

function NP_EsAutorizante($conn){
	$resultado=0;$log=$_SESSION["GLO_IdPersLog"];
	$query="SELECT a.Id FROM co_autorizantes a where a.Id<>0 and a.FechaB='0000-00-00' and a.Tipo=2 and a.IdPersonal=$log";
	$rs2=mysql_query($query,$conn);if(mysql_num_rows($rs2)!=0){$resultado=1;}mysql_free_result($rs2);
	return $resultado;
}


function NP_BuscarFirmaAuto($idper,$conn){//busca autorizante con el id personal del autorizante
	$query="SELECT a.Ruta FROM co_autorizantes a where a.Id<>0 and a.FechaB='0000-00-00' and a.IdPersonal=$idper and a.Tipo=2";
	$rs=mysql_query($query,$conn);while($row=mysql_fetch_array($rs)){$ruta=$row['Ruta'];}mysql_free_result($rs);
	//path
	if($ruta!=''){$ruta="../Archivos/Comprobantes/".$ruta;}
	return $ruta;
}

	
function CO_CbAutorizante($nombre,$actual,$tipo,$ro,$conn){//$tipo 1:preauto, 2:auto, $ro 1:read only
	//preauto/auto
	if($tipo==1){//preauto	
		if($ro==0){$sector=$_SESSION['CbSector'];$filtro=" and a.IdSector=$sector";}else{$filtro=" and p.Id=$actual";}
		$query="SELECT distinct p.Id, p.Nombre,p.Apellido FROM co_autorizantes a, personal p where a.Id<>0 and a.FechaB='0000-00-00' and a.IdPersonal=p.Id $filtro Order by p.Apellido,p.Nombre";
	}else{
		if($ro==0){$filtro="";}else{$filtro=" and p.Id=$actual";}
		$query="SELECT distinct p.Id, p.Nombre,p.Apellido FROM co_autorizantes a,personal p where a.Id<>0 and a.FechaB='0000-00-00' and a.IdPersonal=p.Id and a.Tipo=2 $filtro Order by p.Apellido,p.Nombre";
	}
	$rs=mysql_query($query,$conn);
	//completa lista
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		if( $row['Id'] == $_SESSION[$nombre]) {
			$combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,35)."</option>\n";
	}else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,35)."</option>\n";}
	}mysql_free_result($rs); 
	echo $combo;
	}
	




function CO_PersonalSoliNP($conn){ 
$query="SELECT distinct p.Id,p.Nombre,p.Apellido FROM personal p,co_npedido n where p.Id<>0 and n.IdPerSoli=p.Id Order by p.Apellido, p.Nombre";
$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbSoli']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";
 }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";}} 
echo $combo;mysql_free_result($rs);
}

function CO_PersonalAutoNP($conn){ 
$query="SELECT distinct p.Id,p.Nombre,p.Apellido FROM personal p,co_npedido n where p.Id<>0 and (n.IdPerAuto=p.Id or n.IdPerPAuto=p.Id) Order by p.Apellido, p.Nombre";
$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbAuto']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";
 }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</option>\n";}} 
echo $combo;mysql_free_result($rs);
}



//prioridad
function CO_Prioridad(){
$combo="";
if( "1" == $_SESSION['CbPrio']) { $combo .= " <option value="."1"." selected='selected'>"."ALTA"."</option>\n";}
else{$combo .= " <option value="."1"." >"."ALTA"."</option>\n";}
if( "2" == $_SESSION['CbPrio']) { $combo .= " <option value="."2"." selected='selected'>"."MEDIA"."</option>\n";}
else{$combo .= " <option value="."2"." >"."MEDIA"."</option>\n";}
if( "3" == $_SESSION['CbPrio']) { $combo .= " <option value="."3"." selected='selected'>"."BAJA"."</option>\n";}
else{$combo .= " <option value="."3"." >"."BAJA"."</option>\n";}
echo $combo;
}

function CO_VerPrioridad($var,&$stprio){
$res='';$stprio='';
switch ($var) {
	case 1:	$res='Alta !';$stprio=' TRed';break;
	case 2:	$res='Media';$stprio=' TOrange';break;
	case 3:	$res='Baja';$stprio=' TGreen';break;
}
return $res;
}
?>