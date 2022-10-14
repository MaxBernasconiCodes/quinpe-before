<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("../FPDF/fpdf.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	//grabar los datos en la tabla
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$fecha=FechaMySql($_POST['TxtFechaA']);
	$tipo2=mysql_real_escape_string($_POST['TxtTipo']);
	$suc=intval($_POST['TxtSuc']);
	$nro=intval($_POST['TxtNro']);
	$obs=mysql_real_escape_string($_POST['TxtObs']);
	//update
	$query="UPDATE stockmov set Fecha='$fecha',Obs='$obs',Tipo='$tipo2',Suc=$suc,Nro=$nro Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	
}

//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id pedido para volver
	$_SESSION['TxtOriOPESoli']=6;//id etapa para volver
	header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtIdPadre'])."&Flag1=True");	
}


elseif ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$ori=intval($_SESSION['TxtOriOPEPla']);//de dde viene
	$_SESSION['TxtOriOPEPla']='';//limpio
	//
	if($ori==0){
		if(intval($_SESSION['TxtOriStock'])==0){header("Location:Stock.php");}else{header("Location:StockD.php");}
	}else{
		if($ori==1){header("Location:ModificarP.php?id=".intval($_POST['TxtNroPedido'])."&Flag1=True".'#A3');}//pedido planta
		if($ori==2){header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtIdPadre'])."&Flag1=True");	}//solicitud
	}
}


elseif (isset($_POST['CmdAddD'])){
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdBorrarFilaD'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtId']);
	$idtipo=intval($_POST['CbTipo']);
	$iddep=intval($_POST['CbDep']);
	$idcam=intval($_POST['TxtIdCAM']);	
	$idcliprop=intval($_POST['CbCliente']);//propietario
	include("../Stock/Includes/zBajaMovStock.php");
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdGrabaFilaD'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$iditem=intval($_POST['TxtId']);
	$aListaenv=$_POST['CbEnv'];$idenv=intval($aListaenv[$iditem]);//trae el valor de esa fila
	$aListalote=$_POST['TxtVal'];$lote=mysql_real_escape_string($aListalote[$iditem]);//trae el valor de esa fila
	//update
	$query="UPDATE stockmov_items set IdEnvIT=$idenv,LoteIT='$lote' Where Id=$iditem";
	$rs=mysql_query($query,$conn);
	if (!($rs)){GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


?>