<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$ori=intval($_SESSION['TxtOriOPESoli']);//de dde viene
	$oriid=intval($_SESSION['TxtIdOriOPESoli']);//id pagina origen	
	$_SESSION['TxtOriOPESoli']='';$_SESSION['TxtIdOriOPESoli']='';//limpio
	//vuelvo
	if($ori==0 or $oriid==0){header("Location:Procesos.php");}//solicitudes
	else{
		if($ori==1){header("Location:../Barrera/ModificarVehiculo.php?id=".$oriid."&Flag1=True");}//barrera
		if($ori==2){header("Location:../CAM/Modificar.php?id=".$oriid."&Flag1=True");}//lab
		if($ori==3){header("Location:../Barrera/ModificarPD.php?id=".$oriid."&Flag1=True");}//barrera pedido
		if($ori==4){header("Location:../Despacho/Modificar.php?id=".$oriid."&Flag1=True");}//despacho
		if($ori==5){header("Location:../Planta/ModificarP.php?id=".$oriid."&Flag1=True");}//planta pedido
		if($ori==6){header("Location:../Planta/Modificar.php?id=".$oriid."&Flag1=True");}//planta mov
	}
	
}


//cerrar/abrir
elseif (isset($_POST['CmdCerrarP'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="update procesosop set Estado=1 Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
	if (!($rs)){GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdAbrirP'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="update procesosop set Estado=0 Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
	if (!($rs)){GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}





//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From procesosop_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From procesosop_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Solicitudes/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("procesosop_adj",intval($_POST['TxtId']),"Solicitudes/","Ruta");
}


//ver barrera
elseif (isset($_POST['CmdVer1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtOriOPEBar']=2;//vuelve a solicitud
	header("Location:../Barrera/ModificarVehiculo.php?id=".intval($_POST['TxtId'])."&Flag1=True");	
}

//ver laboratorio
elseif (isset($_POST['CmdVer2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtOriOPELab']=1;//vuelve a solicitud
	header("Location:../CAM/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");	
}


//ver planta
elseif (isset($_POST['CmdVer3'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtOriOPEPla']=2;//vuelve a solicitud
	header("Location:../Planta/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");	
}


//ver despacho
elseif (isset($_POST['CmdVer4'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtOriOPEDes']=1;//vuelve a solicitud
	header("Location:../Despacho/Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");	
}





?>