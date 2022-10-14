<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	//verifica campos requeridos
	if (empty($_POST['TxtNombre']) or empty($_POST['CbTipo']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatos.php");
		$query="UPDATE pssa_act set Nombre='$nombre',IdTipo=$tipo,IdFrec=$frec,IdResp=$resp Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:../PSSAAct.php");
	}
}




elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSSAAct.php");
}



?>


