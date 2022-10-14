<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	if ( (empty($_POST['CbProv'])) or (empty($_POST['TxtFechaA'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarFactura.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$tipo=mysql_real_escape_string($_POST['TxtTipo']);
		$suc=intval($_POST['TxtSuc']); 
		$nro=intval($_POST['TxtNro']); 
		$est=intval($_POST['CbEstado']);
		$tipoiva=intval($_POST['OptTipoIVA']);	//1:21%, 2:10,5
		$oi=floatval($_POST['TxtOI']); 
		$id=intval($_POST['TxtNumero']);
		$query="UPDATE co_facturas set Fecha='$fa',IdEstado=$est,Obs='$obs',Tipo='$tipo',Suc=$suc,Nro=$nro,TipoIVA=$tipoiva,OtrosImp=$oi Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarFactura.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}

}

elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaItemFC.php?Id=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From co_facturas_it Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarFactura.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Facturas.php");
}







?>


