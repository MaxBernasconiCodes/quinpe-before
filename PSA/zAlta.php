<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	//verifica campos requeridos
	if (empty($_POST['TxtNro']) or empty($_POST['CbTipo']) or empty($_POST['CbAseg']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		$nro=intval($_POST['TxtNro']); 
		$tipo=intval($_POST['CbTipo']);
		$aseg=intval($_POST['CbAseg']);		
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM polizassegauto";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//query
		$query="INSERT INTO polizassegauto (Id,Nro,IdTipo,IdAseg,FechaI,FechaF) VALUES ($nroId,$nro,$tipo,$aseg,'$fechaa','$fechab')"; 
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:Alta.php");
		}			
	}		
}






elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSA.php");
}



?>

