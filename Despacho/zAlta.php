<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['CbCliente']) or empty($_POST['TxtFechaA']) or empty($_POST['CbTipo']) ){
		//if ( empty($_POST['CbCliente']) or empty($_POST['TxtFechaA']) or empty($_POST['CbTipo']) or empty($_POST['CbServicio']) ){ //sacar comentario
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$tipocambio=1;//insert
		include("Includes/zDatos.php");
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

	
else {
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:".$_SERVER['HTTP_REFERER']);
}
	
?>

