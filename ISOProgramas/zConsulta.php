<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$fechad=intval($_POST['TxtFechaDCP']);if($fechad!=0){$wfechad="and m.Fecha=$fechad";}else{$wfechad='';}
	$sector=intval($_POST['CbSector']);if($sector!=0){$wsector="and m.IdSector=$sector";}else{$wsector='';}
	$tipo=intval($_POST['CbTipo']);if($tipo!=0){$wtipo="and m.IdTipo=$tipo";}else{$wtipo='';}
	//
	$_SESSION['TxtQISOPROG']="Select m.*,s.Nombre as Sector, t.Nombre as Tipo From programas m,sector s,programas_tipo t Where m.Id<>0 and m.IdSector=s.Id and m.IdTipo=t.Id $wfechad $wsector $wtipo Order by m.Fecha";
	header("Location:Consulta.php");
}


if (isset($_POST['CmdManualIntra'])){
	GLO_OpenPDF('Manual/SGIProgramas.pdf',0);
}

if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From programas Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Consulta.php"); 	
}




if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQISOPROG']=$_POST['TxtQISOPROG'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

elseif (isset($_POST['CmdExportarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
	PL_ExportarPlan($_POST['TxtId'],$conn);//cierra cnx en funcion
	header("Location:Consulta.php"); 	
}

?>