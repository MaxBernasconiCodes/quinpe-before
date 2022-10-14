<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

function ISODOC_grabaauditoria($id,$cbio,$conn){
	$faudit=FechaMySqlHora(date("d-m-Y H:i:s"));$user=$_SESSION["login"];
	$nroId2=GLO_generoID("iso_doc_auditoria",$conn);
	$query="INSERT INTO iso_doc_auditoria (Id,IdDoc,IdUsuario,IdCambio,Fecha) VALUES ($nroId2,$id,'$user',$cbio,'$faudit')";
	$rs10=mysql_query($query,$conn);		
}
function ISODOC_TieneVersionNueva($id,$conn){
	$res=0;
	$query="Select Id From iso_doc Where FlagRev=$id LIMIT 1";$rs10=mysql_query($query,$conn);
	$row10=mysql_fetch_array($rs10);if(mysql_num_rows($rs10)!=0){$res=1;}mysql_free_result($rs10);
	return $res;
}

function ISODOC_ColorEstado($idestado){
	$colorest='';
	if($idestado=='0'){$colorest=' style="color:#ef6c00"';}//elaborado naranja
	if($idestado=='1'){$colorest=' style="color:#cc0099"';}//abierto violeta
	if($idestado=='2'){$colorest=' style="color:#0079b1"';}//controlado azul
	if($idestado=='3'){$colorest=' style="color:#f44336"';}//rev control  rojo
	if($idestado=='4'){$colorest=' style="color:#0F9D58"';}//aprob  verde
	if($idestado=='5'){$colorest=' style="color:#f44336"';}//rev aprob  rojo
	if($idestado=='6'){$colorest=' style="color:#666666"';}//obsoleto gris
	return $colorest;
}


function ISODOC_puedemodificar($v){
	//perfiles permitidos
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){$perfilok=1;}else{$perfilok=0;}	
	//estados
	if($v==1){		
		if($_SESSION['TxtIdEstado']!=6){$estadook=1;}else{$estadook=0;}	//no obsoleto
	}
	//permiso
	if($estadook==1 and $perfilok==1){$res=1;}else{$res=0;}
	return $res;
}


function ISODOC_puedever($v){
	//perfiles permitidos
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){$perfilok=1;}else{$perfilok=0;}	
	//usuario controla/aprueba
	if ($_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers2"] or $_SESSION["GLO_IdPersLog"]==$_SESSION["TxtIdPers3"]){$userok=1;}else{$userok=0;}	
	//permiso
	if($userok==1 or $perfilok==1){$res=1;}else{$res=0;}
	return $res;
}



?>