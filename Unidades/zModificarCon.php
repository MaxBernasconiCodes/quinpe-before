<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbProv']) or  empty($_POST['TxtFechaA']) or  empty($_POST['TxtFechaB']) or  empty($_POST['TxtNroCon']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarCon.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$prov=intval($_POST['CbProv']);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}	
		$con=intval($_POST['TxtNroCon']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		//actualizo
		$query="UPDATE unidades_con set FechaI='$fechaa',FechaF='$fechab',IdProv=$prov,NroCon=$con,Obs='$obs' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarCon.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}


//archivos adjuntos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoCon.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From unidades_cona Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From unidades_cona Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("unidades_cona",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}





//tarifas adjuntos
elseif (isset($_POST['CmdAddT'])){
	header("Location:AltaConT.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaT'])){
	$iditem=intval($_POST['TxtId']);	
	$identidad=intval($_POST['TxtNumero']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//obtengo fechadesde y hasta del item a eliminar
	$fechad='0000-00-00';$fechah='0000-00-00';
	$query="SELECT * FROM unidades_cont Where Id=$iditem";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);$fechadmayor='';
	if(mysql_num_rows($rs)!=0){$fechad=$row['FechaD'];$fechah=$row['FechaH'];}mysql_free_result($rs);
	//pongo nueva fechah al item anterior del eliminado 
	$query="UPDATE unidades_cont set FechaH='$fechah' Where FechaH='$fechad' and IdEntidad=$identidad";$rs=mysql_query($query,$conn);	
	//eliminar item
	$query="Delete From unidades_cont Where Id=$iditem";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	//vuelvo
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A8');
}


?>


