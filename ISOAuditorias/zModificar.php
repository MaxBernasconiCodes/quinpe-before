<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){
		//verifica campos requeridos
		if ( empty($_POST['CbTipo']) or empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{ 
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");
			$query="UPDATE iso_audi_prog set IdSector=$sec,IdTipo=$tipo,FechaProg='$fechaa',FechaReal='$fechab',Obs='$obs',IdEstado=$estado,IdYac=$yac,HoraReal='$hora',Duracion='$horad',Anulado=$anul,IdInstalacion=$inst,Dirigido='$diri',Obj='$obj',Alcance='$alc',IdCentro=$ctro,FechaRProg='$fecharp',Met='$met',Res='$res',Cri='$cri',Tipo=$tipoie,Nombre='$nom' Where Id=$id";
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
			mysql_close($conn); 		
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");

		}		
}



//procesos
elseif (isset($_POST['CmdAddPro'])){
	header("Location:AltaProceso.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));
}
elseif (isset($_POST['CmdBorrarFilaPro'])){
	$query="Delete From iso_audi_procesos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//archivos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From iso_audi_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_audi_archivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/NC/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("iso_audi_archivos",intval($_POST['TxtId']),"NC/","Ruta");
}


//
elseif (isset($_POST['CmdAddA1'])){
	header("Location:AltaAuditor.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$query="Delete From iso_audi_auditores Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//
elseif (isset($_POST['CmdAddA2'])){
	header("Location:AltaAuditado.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));
}
elseif (isset($_POST['CmdBorrarFilaA2'])){
	$query="Delete From iso_audi_auditados Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//
elseif (isset($_POST['CmdAddD'])){
	header("Location:AltaDesvio.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));
}
elseif (isset($_POST['CmdBorrarFilaD'])){
	$query="Delete From iso_audi_progdes Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//
elseif (isset($_POST['CmdAddR'])){
	header("Location:AltaReq.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));
}
elseif (isset($_POST['CmdBorrarFilaR'])){
	$query="Delete From iso_audi_progreq Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//nc
elseif (isset($_POST['CmdVerH'])){
	header("Location:../ISONC/Ver.php?id=".intval($_POST['TxtId']));
}

?>


