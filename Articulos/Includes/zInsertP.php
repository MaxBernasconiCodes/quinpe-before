<? 

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST[CmdAceptar])){ 

	if ((empty($_POST['CbTipoCertif'])) or (empty($_POST['CbInstrumento'])) or (empty($_POST['TxtFechaA']))){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

		GLO_feedback(3);header("Location:AltaP.php");

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}

		if($fechab=="0000-00-00"){$estado=1;}else{$estado=2;}	

		$ins=intval($_POST['CbInstrumento']); 

		$cer=intval($_POST['CbTipoCertif']); 

		$certif=mysql_real_escape_string($_POST['TxtCertif']);

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		$inac=intval($_POST['ChkInactivo']);

		//query

		$nroId=GLO_generoID('instrumentosprog',$conn);

		$query="INSERT INTO instrumentosprog (Id,IdInstrumento,IdTipoCertif,FechaProg,FechaReal,IdEstado,Certificado,Obs,Ruta,Inactivo) VALUES ($nroId,$ins,$cer,'$fechaa','$fechab',$estado,'$certif','$obs','',$inac)"; 

		$rs=mysql_query($query,$conn); 

		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 

		mysql_close($conn); 			

		//volver

		if($grabook==1){

			foreach($_POST as $key => $value){$_SESSION[$key] = "";}

			header("Location:ModificarP.php?id=".$nroId."&Flag1=True");

		}else{

			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

			header("Location:AltaP.php");

		}			

	}	

}

?>

