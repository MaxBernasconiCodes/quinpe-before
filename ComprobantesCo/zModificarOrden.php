<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../FPDF/fpdf.php");include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


class PDF extends FPDF{
/* //Page header
function Header(){
    $this->Image('logo_pb.png',10,8,33);
    $this->SetFont('Arial','B',15);
    $this->Cell(80);
    $this->Cell(30,10,'Title',1,0,'C');
    $this->Ln(20);
}

//Page footer
function Footer(){
    $this->SetY(-15);
	 $this->SetFont('Arial','I',8);
	 $this->Cell(0,3,'Base Central Neuquen: Conquistadores del Desierto 2450, PIN Oeste - Tel:(299) 4413598 - CP:8300',0,0,'C');$this->Ln();
	 $this->Cell(0,3,'Base Operativa Catriel: Seccion Chacras Colonia Ovejero - Tel:(299) 155124631',0,0,'C');$this->Ln();
	 $this->Cell(0,3,'info@greenoilservices.com / www.greenoilservices.com',0,0,'C');
}*/

}


if (isset($_POST[CmdAceptar])){
	if ((empty($_POST['CbProv'])) or (empty($_POST['CbEje'])) or (empty($_POST['CbAuto'])) or (empty($_POST['TxtFechaA'])) or empty($_POST['TxtNro'])){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatosOC.php");	
		$query="UPDATE co_ocompra set Fecha='$fa',IdProv=$prov,Obs='$obs',IdPerEjec=$eje,IdPerAuto=$auto,Efe=$efe,Efe2='$tefe',Che=$che,Che2='$tche',CC=$cc,Fact1=$f1,Fact1Nro='$tf1',Rem=$rem,RemNro='$trem',Nro=$nrooc,Tran=$tran,TranD=$trand Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}

}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	if(intval($_SESSION['TxtOriCOORD'])==0){header("Location:Ordenes.php");}else{header("Location:OrdenesD.php");}
}



//items
elseif (isset($_POST[CmdAddI])){
	header("Location:AltaItemOC.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST[CmdBorrarFila])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$iditem=intval($_POST['TxtId']);
	//eliminar item
	$query="Delete From co_ocompra_it Where Id=$iditem";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


//adjuntos pedidos
elseif (isset($_POST[CmdVerFile1])){
	GLO_OpenFile("co_npedido_archivos",intval($_POST['TxtId']),"Comprobantes/","Ruta");
}

//obs pedidos
elseif (isset($_POST['CmdObsNP'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$aListaid=array_keys($_POST['TxtObsNP']);//id 
	$aListaobs=$_POST['TxtObsNP'];//valor
	$cont=0;
	foreach($aListaid as $iId) {
		$obs=mysql_real_escape_string($aListaobs[$iId]);
		$query="Update co_npedido Set Obs='$obs' Where Id=$iId";$rs=mysql_query($query,$conn);
		if($rs){$cont=$cont+1;}
	}
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	if ($cont>0){GLO_feedback(1);}else{GLO_feedback(2);} 
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
	

//obs items pedidos
elseif (isset($_POST['CmdObsNPI'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$aListaid=array_keys($_POST['TxtObsNPI']);//id 
	$aListaobs=$_POST['TxtObsNPI'];//valor
	$cont=0;
	foreach($aListaid as $iId) {
		$obs=mysql_real_escape_string($aListaobs[$iId]);
		$query="Update co_npedido_it Set Obs='$obs' Where Id=$iId";$rs=mysql_query($query,$conn);
		if($rs){$cont=$cont+1;}
	}
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	if ($cont>0){GLO_feedback(1);}else{GLO_feedback(2);} 
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


//estados
elseif (isset($_POST[CmdAuto])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=2 Where Id=$id";$rs=mysql_query($query,$conn);			
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST[CmdRech])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=3 Where Id=$id";$rs=mysql_query($query,$conn);	
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST[CmdEnviar])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=4 Where Id=$id";$rs=mysql_query($query,$conn);	
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST[CmdAbrir])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=1 Where Id=$id";$rs=mysql_query($query,$conn);	
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST[CmdCerrar])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=5 Where Id=$id";$rs=mysql_query($query,$conn);	
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


elseif (isset($_POST[CmdAnular])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$fecha=FechaMySql(date("d-m-Y"));
	$query="UPDATE co_ocompra set IdEstado=6 Where Id=$id";$rs=mysql_query($query,$conn);	
	mysql_close($conn);
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:ModificarOrden.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}






?>


