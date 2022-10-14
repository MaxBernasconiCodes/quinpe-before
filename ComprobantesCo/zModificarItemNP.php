<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( floatval($_POST['TxtCantidad'])==0 ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad']));	
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//idcomprobante
		$prov=intval($_POST['CbProv']);
		$cantauto=floatval($_POST['TxtCantidadA']);	
		$cant=floatval($_POST['TxtCantidad']);	
		$obs=mysql_real_escape_string($_POST['TxtObs']);	
	  	//update
		$query="UPDATE co_npedido_it set Cant=$cant,CantAuto=$cantauto,IdProv=$prov,Obs='$obs' Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}


///estados
elseif (isset($_POST['CmdPAuto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_npedido_it set IdEstado=2,FechaPAuto='$fecha' Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

elseif (isset($_POST['CmdAuto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_npedido_it set IdEstado=3,FechaAuto='$fecha' Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

//
elseif (isset($_POST['CmdRechPre'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="UPDATE co_npedido_it set IdEstado=4 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

elseif (isset($_POST['CmdRechAuto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="UPDATE co_npedido_it set IdEstado=5 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

//
elseif (isset($_POST['CmdAbrir'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="UPDATE co_npedido_it set IdEstado=1 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}
elseif (isset($_POST['CmdPAutoAnt'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_npedido_it set IdEstado=2 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

elseif (isset($_POST['CmdAutoAnt'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_npedido_it set IdEstado=3 Where Id=$id";$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarItemNP.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}
?>