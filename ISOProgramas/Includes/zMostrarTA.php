<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

if ($_GET['Flag1']=="True"){
	$query="SELECT mt.*,m.IdTipoE From programas_t mt,programas m where mt.IdP=m.Id and mt.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdP'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbTipoE'] = $row['IdTipoE'];
		$_SESSION['TxtObs'] =  $row['Obs'];	
		$_SESSION['TxtObs2'] =  $row['Obs2'];	
		$_SESSION['TxtObs3'] =  $row['Obs3'];
		//entidad
		$_SESSION['CbCliente'] =  $row['IdCliente'];
		$_SESSION['CbUnidad'] =  $row['IdUnidad'];
		$_SESSION['CbPersonal'] =  $row['IdPersonal'];
		$_SESSION['CbServicio'] =  $row['IdServicio'];
		$_SESSION['TxtNombre'] =  $row['Otro'];
	}mysql_free_result($rs);
}
?>