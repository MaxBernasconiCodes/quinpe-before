<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or  empty($_POST['CbUnidad'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$inac=intval($_POST['ChkInactivo']); 
		$tipo=intval($_POST['CbTipo']); 
		$unidad=intval($_POST['CbUnidad']);
		//inserto 
		$nroId=GLO_generoID('items',$conn);
		$query="INSERT INTO items (Id,Nombre,Inactivo,Tipo,IdUnidad) VALUES ($nroId,'$nombre',$inac,$tipo,$unidad)";$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);} 
		mysql_close($conn);
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		header("Location:../Conceptos.php");
	}		
}


?>