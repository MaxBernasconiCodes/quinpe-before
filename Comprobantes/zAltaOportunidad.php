<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ((empty($_POST['CbCliente'])) or (empty($_POST['TxtFechaA']))  or (empty($_POST['CbPersonal'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:AltaOportunidad.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$cli=intval($_POST['CbCliente']); 
		$per=intval($_POST['CbPersonal']);
		$tipo1=intval($_POST['CbTipo']); 
		$tipo2=intval($_POST['CbTipoC']); 
		$fa=GLO_FechaMySql($_POST['TxtFechaA']);
		$est=intval($_POST['CbEstado']); 
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$ref=mysql_real_escape_string($_POST['TxtRef']); 
		$con=mysql_real_escape_string($_POST['TxtContacto']); 
		$loc=mysql_real_escape_string($_POST['TxtUbic']);
		//query
		$nroId=GLO_generoID("c_oportunidades",$conn);
		$query="INSERT INTO c_oportunidades (Id,IdCliente,IdTipo,Fecha,IdEstado,Obs,Ref,Contacto,IdPersonal,Loc,IdTipoC) VALUES ($nroId,$cli,$tipo1,'$fa',$est,'$obs','$ref','$con',$per,'$loc',$tipo2)"; $rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarOportunidad.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaOportunidad.php");
		}			
	}		

}




?>

