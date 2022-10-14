<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");   $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar']))
{
	if ( (empty($_POST['CbAccion'])) or (empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}
	else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$sec=0;
		$acc=intval($_POST['CbAccion']);		
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		//update
		$query="UPDATE iso_doc_resp set IdSector=$sec,IdAccion=$acc,FechaA='$fechaa',FechaB='$fechab' Where Id=".intval($_POST['TxtNumero']);	$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		//actualizar variables de sesion
		$idcon=0;$idapr=0;
		//control
		$query="Select IdPersonal From iso_doc_resp Where IdAccion=2 and FechaB='0000-00-00'";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)!=0){ $idcon=$row['IdPersonal'];}	mysql_free_result($rs);
		//aprob
		$query="Select IdPersonal From iso_doc_resp Where IdAccion=3 and FechaB='0000-00-00'";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)!=0){ $idapr=$row['IdPersonal'];}	mysql_free_result($rs);
		$_SESSION["GLO_IdPersCON"]=$idcon;
		$_SESSION["GLO_IdPersAPR"]=$idapr;		
		
		mysql_close($conn); 	
		//vuelvo
		foreach($_POST as $key => $value){$_SESSION[$key] = "";	}
		header("Location:../ISO_Resp.php");
	}		
	
}






?>

