<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar']))
{
	if ( (empty($_POST['CbSector'])) or (empty($_POST['CbPersonal'])) or (empty($_POST['TxtFechaA'])) or (empty($_POST['OptTipo']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:AltaAuto.php");
	}
	else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$sec=intval($_POST['CbSector']);
		$per=intval($_POST['CbPersonal']);
		$tipo=intval($_POST['OptTipo']);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
	  	//generoid
		$query="SELECT Max(Id) as UltimoId FROM co_autorizantes";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}
		mysql_free_result($rs);
		//inserto
		$query="INSERT INTO co_autorizantes (Id,IdSector,IdPersonal,FechaA,FechaB,Tipo,Ruta) VALUES ($nroId,$sec,$per,'$fechaa','$fechab',$tipo,'')";
		$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);} 
		mysql_close($conn); 
	
		//vuelvo
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		header("Location:Autorizantes.php");
	}		
}

elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Autorizantes.php");
}

?>


