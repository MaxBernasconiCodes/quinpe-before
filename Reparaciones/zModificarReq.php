<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbClase'])) or (empty($_POST['CbTipo'])) or (empty($_POST['CbCat'])) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$estorden=intval($_POST['TxtIdEstadoO']);
		$clase=intval($_POST['CbClase']);
		$tipo=intval($_POST['CbTipo']);
		$urg=intval($_POST['CbUrg']);
		$cat=intval($_POST['CbCat']);
		$ext=intval($_POST['ChkExt']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		if (empty($_POST['TxtFecha1'])){$fecha1="0000-00-00";}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}//turno
		$prov=intval($_POST['CbProv']);
		$id=intval($_POST['TxtNumero']);
		if($estorden!=7){//valido que no sea finalizada
			//actualizo //pedidosrepreq IdPR join Id pedidosrepord
			$query="UPDATE pedidosrepreq set Clase=$clase,Tipo=$tipo,Alcance=$ext,Urg=$urg,IdCat=$cat,Obs='$obs',FTurno='$fecha1',IdProv=$prov  Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);REP_updateestadoaccion($conn,$id,$ident,0);}
			else{GLO_feedback(2);} 
		}else{GLO_feedback(2);}//hack-orden finalizada sin accion	
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}





elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoReq.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From pedidosrepreq_arch Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From pedidosrepreq_arch Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("pedidosrepreq_arch",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}






elseif (isset($_POST['CmdAddC'])){
	header("Location:AltaComentarioReq.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaC'])){
	$query="Delete From pedidosrepreq_com Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdAddAc'])){
	header("Location:AltaAc.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaAc'])){
	$query="Delete From pedidosrepreq_act Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);
	REP_updateestadoaccion($conn,intval($_POST['TxtNumero']),intval($_POST['TxtNroEntidad']),0);}
	else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaI.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaI'])){
	$query="Delete From pedidosrepreq_ins Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);
	REP_updateestadoaccion($conn,intval($_POST['TxtNumero']),intval($_POST['TxtNroEntidad']),0);}
	else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST['CmdFin'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:FinalizarReq.php?id=".intval($_POST['TxtNumero']));
}


elseif ( isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarOrden.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


?>


