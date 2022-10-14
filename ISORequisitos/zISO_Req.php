<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	if ((empty($_POST['TxtBusqueda']))){$wnom="";}else{$wnom="and (d.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	if ((empty($_POST['TxtNro']))){$wnro="";}else{$wnro="and (d.Nro Like '%".mysql_real_escape_string($_POST['TxtNro'])."%')";}
	$norma=intval($_POST['CbNorma']);if($norma!=0){$wnorma="and d.IdNorma=$norma";}else{$wnorma='';}
	//consulta
	$_SESSION['TxtQuery31']="Select d.*,n.Nombre as Norma From iso_nc_req d,iso_nc_norma n Where d.Id<>0 and d.IdNorma=n.Id $wnom $wnro $wnorma Order By d.FechaBaja,n.Nombre,d.Nro ";
	header("Location:../ISO_Requisitos.php");
}



if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From iso_nc_req Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Requisitos.php"); 	
}

?>