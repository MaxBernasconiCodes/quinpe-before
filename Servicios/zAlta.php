<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbTipoC'])) or (empty($_POST['CbCliente']))  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$cli=intval($_POST['CbCliente']); 
		$tipo1=intval($_POST['CbTipoC']); 
		$int=mysql_real_escape_string($_POST['OptTipoI']);	
		$fechaa=FechaMySql(date("d-m-Y"));
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);};
		$tipoc=intval($_POST['CbTipoContrato']); 
		//inserto			
		$nroId=GLO_generoID("servicios",$conn);
		$query="INSERT INTO servicios (Id,IdCliente,IdTipo,Interno,FechaAlta,FechaBaja,IdTipoContrato) VALUES ($nroId,$cli,$tipo1,'$int','$fechaa','$fechab',$tipoc)";
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


?>

