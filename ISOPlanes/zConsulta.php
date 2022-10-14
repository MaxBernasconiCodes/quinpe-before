<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	if(!(empty($_POST['TxtFechaDCP']))){$wfechad="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";}else{$wfechad='';}
	if(!(empty($_POST['TxtFechaHCP']))){$wfechah="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";}else{$wfechah='';}
	$sector=intval($_POST['CbSector']);if($sector!=0){$wsector="and m.IdSector=$sector";}else{$wsector='';}
	//
	$_SESSION['TxtQISOPLA']="Select m.*,s.Nombre as Sector From plan m,sector s Where m.Id<>0 and m.IdSector=s.Id $wfechad $wfechah $wsector Order by m.Fecha";
	header("Location:../ISO_Planes.php");
}


if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From plan Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Planes.php"); 	
}




if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQISOPLA']=$_POST['TxtQISOPLA'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

 
?>