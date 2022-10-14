<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['TxtNombre']) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

		GLO_feedback(3);header("Location:Alta.php");	

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));

		//inserto

		$nroId=GLO_generoID('metodos',$conn);

		$query="INSERT INTO metodos (Id,Nombre) VALUES ($nroId,'$nom')";$rs=mysql_query($query,$conn);

		if (!($rs)){GLO_feedback(2);} 

		mysql_close($conn); 

		//vuelvo

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		

		header("Location:Consulta.php");

	}

}



?>