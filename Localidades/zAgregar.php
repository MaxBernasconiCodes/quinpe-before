<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=12   and $_SESSION["IdPerfilUser"]!=13 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){

	if ((empty($_POST['TxtNombre'])) or (empty($_POST['CbPcia'])) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

		GLO_feedback(3);header("Location:Agregar.php");

	}else{

		//grabar los datos en la tabla

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));

		$cp=mysql_real_escape_string($_POST['TxtCP']);

		$pcia=intval($_POST['CbPcia']); 

	  	//generoid

		$query="SELECT Max(Id) as UltimoId FROM localidades";

		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}

		mysql_free_result($rs);

		//inserto

		$query="INSERT INTO localidades (Id,Nombre,CP,IdPcia) VALUES ($nroId,'$nombre','$cp',$pcia)";

		$rs=mysql_query($query,$conn);

		mysql_close($conn); 

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		

		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

	}		

}





//add y refresh

elseif (isset($_POST['CmdAddProv'])){

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:../Provincias/Agregar.php");

}

elseif (isset($_POST['CmdRefreshProv'])){

	foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}

	header("Location:Agregar.php");

}



?>



