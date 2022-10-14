<?php session_start();include("Config.php");

//compruebo usr-pass
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$login = mysql_real_escape_string($_POST['TxtUsuario']);
$pass = mysql_real_escape_string(trim($_POST['TxtPassword']));
$_SESSION["NombreUsuario"]="Nombre desconocido";
$existe=0;
//verifico que exista usuario y no est&eacute; dado de baja
$query="SELECT * FROM usuarios WHERE Usuario <> '' and Password <> '' and Usuario='$login' and FechaBaja='0000-00-00' and Password='".crypt($pass , 'otro@letra8')."'" ;
$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){ 
	$tipo=$row['Tipo'];$idprov=$row['IdProveedor'];$idpers=$row['IdPersonal'];$perfil=$row['IdPerfil'];$existe=1;		
	//verifico que el personal/proveedor no est&eacute; dado de baja
	$baja=0;
	if ($tipo=='PERSONAL'){
		$query= "Select Nombre,Apellido,FechaBaja From personal Where Id=$idpers"; $rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){
			if($row2['FechaBaja']!='0000-00-00'){$baja=1;};
			$_SESSION["NombreUsuario"]=substr($row2['Nombre'],0,25)." ".substr($row2['Apellido'],0,25);
		} mysql_free_result($rs2);
	}
	if ($tipo=='PROVEEDOR'){
		$query= "Select Nombre,Apellido,FechaBaja From proveedores Where Id=$idprov"; $rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){
			if($row2['FechaBaja']!='0000-00-00'){$baja=1;};
			$_SESSION["NombreUsuario"]=substr($row2['Apellido'],0,40);
		} mysql_free_result($rs2);
	}	
	
} 
mysql_free_result($rs);mysql_close($conn); 

//----------------------------------------------------------------------------------------------------------------------------

//si existe el usuario y no est&aacute; dado de baja ni el usuarios, ni el presonal/proveedor logueo
if ($existe==1 and $baja==0){
	//busco perfiles SGI 2:controlar,3:aprobar
	$idcon=0;$idapr=0;
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//control
	$query="Select IdPersonal From iso_doc_resp Where IdAccion=2 and FechaB='0000-00-00'";
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){ $idcon=$row['IdPersonal'];}	mysql_free_result($rs);
	//aprob
	$query="Select IdPersonal From iso_doc_resp Where IdAccion=3 and FechaB='0000-00-00'";
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){ $idapr=$row['IdPersonal'];}	mysql_free_result($rs);
	mysql_close($conn); 
	//variables globales
	$_SESSION["login"]=$login;
	$_SESSION["autentificado"]= "SI"; 
	$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
	$_SESSION["IdPerfilUser"]=$perfil;
	$_SESSION["GLO_IdProvLog"]=$idprov;
	$_SESSION["GLO_IdPersLog"]=$idpers;
	$_SESSION["GLO_IdPersCON"]=$idcon;
	$_SESSION["GLO_IdPersAPR"]=$idapr;
	$_SESSION["GLO_ValidaEmpresa"]='QUINPE 2794984711';
	$_SESSION["NivelArbol"]="";	
	$_SESSION["GLO_IdSistema"]="";			
	include ("InitSession.php");//init variables que no se limpian	
	include ("LimpiarSession.php");//init variables que se limpian
	
	//registro login en historial
	if($login!='admin'){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fechaaudit=date("Y-m-d H:i:s");$user=$_SESSION["login"];
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM auditorialogin";$rsvf=mysql_query($query,$conn);$rowvf=mysql_fetch_array($rsvf);
		if(mysql_num_rows($rsvf)==0){$nroIdvf=1;}else{$nroIdvf=$rowvf['UltimoId']+1;}	mysql_free_result($rsvf);
		//inserto
		$query="INSERT INTO auditorialogin (Id,IdUsuario,Fecha) VALUES ($nroIdvf,'$user','$fechaaudit')";$rsvf=mysql_query($query,$conn);
		mysql_close($conn); 	
	}	
	
	header("location:../InicioIntranet.php");
}else{
	header("Location:../Index.php?&msgE=Verifique el usuario y la clave");
}

?>

