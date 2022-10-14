<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);


if (isset($_POST['CmdAceptar'])){ 
		if ( empty($_POST['TxtFecha']) or  empty($_POST['TxtNombre'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fecha=intval($_POST['TxtFecha']);
		$nom=mysql_real_escape_string($_POST['TxtNombre']);	
		$nom1=mysql_real_escape_string($_POST['TxtNombre1']);	
		$nom2=mysql_real_escape_string($_POST['TxtNombre2']);	
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$per=intval($_POST['CbPersonal']);
		$tipor=intval($_POST['CbTipoR']);
		$sec=intval($_POST['CbSector']);
		$id=intval($_POST['TxtNumero']);
		//programa
		$query="UPDATE programas set Fecha=$fecha,IdSector=$sec,Nombre='$nom',Obs='$obs',T1='$nom1',T2='$nom2',IdRef=$tipor,IdResp=$per  Where Id=$id"; $rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		//items
		$aListaid=array_keys($_POST['TxtM1P']);//id
		for ($i=1; $i < 13; $i= $i +1) {$nomc='TxtM'.$i.'P';${'aListamp'.$i}=$_POST[$nomc];}//value programado
		for ($i=1; $i < 13; $i= $i +1) {$nomc='TxtM'.$i.'R';${'aListamr'.$i}=$_POST[$nomc];}//value real
		for ($i=1; $i < 13; $i= $i +1) {$nomc='TxtM'.$i.'Q';${'aListamq'.$i}=$_POST[$nomc];}//value referencia
		//
		foreach($aListaid as $iId) {
			//trae lista
			for ($i=1; $i < 13; $i= $i +1) {${'mp'.$i}=intval(${'aListamp'.$i}[$iId]);}
			for ($i=1; $i < 13; $i= $i +1) {${'mr'.$i}=intval(${'aListamr'.$i}[$iId]);}
			for ($i=1; $i < 13; $i= $i +1) {${'mq'.$i}=mysql_real_escape_string(${'aListamq'.$i}[$iId]);}
			//arma where
			$wq='';
			for ($i=1; $i < 13; $i= $i +1) {
				if($wq==''){$wq=$wq."M".$i."P=".${'mp'.$i};}else{$wq=$wq.",M".$i."P=".${'mp'.$i};}
			}
			for ($i=1; $i < 13; $i= $i +1) {$wq=$wq.",M".$i."R=".${'mr'.$i};}
			for ($i=1; $i < 13; $i= $i +1) {$wq=$wq.",M".$i."Q='".${'mq'.$i}."'";}
			$query="Update programas_t Set ".$wq." Where Id=$iId";$rs=mysql_query($query,$conn);		
		}		
		mysql_close($conn); 		
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		$_SESSION['TxtNLMin']=$_POST['TxtNLMin'];$_SESSION['TxtNLMax']=$_POST['TxtNLMax'];
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}	
}



elseif (isset($_POST['CmdBorrarFilaT'])){
	$query="Delete From programas_t Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtNLMin']=$_POST['TxtNLMin'];$_SESSION['TxtNLMax']=$_POST['TxtNLMax'];
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtNLMin']=$_POST['TxtNLMin'];$_SESSION['TxtNLMax']=$_POST['TxtNLMax'];
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From programas_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From programas_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Programas/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("programas_adj",intval($_POST['TxtId']),"Programas/","Ruta");
}



elseif (isset($_POST['CmdExcel'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
	PL_ExportarPlan($_POST['TxtNumero'],$conn);//cierra cnx en funcion
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



elseif (isset($_POST['CmdRango'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtNLMin']=$_POST['TxtNLMin'];$_SESSION['TxtNLMax']=$_POST['TxtNLMax'];
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


else{
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['GLO_msgE']='Por favor seleccione una cantidad de registros menor';
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
?>