<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtAnio']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php?ido=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$anio=intval($_POST['TxtAnio']); 
		$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
		$tit=mysql_real_escape_string($_POST['TxtTitulo']);
		$det=mysql_real_escape_string($_POST['TxtTexto']);		
		//inserto
		$tablaobj=OBJ_tabla($_POST['TxtNroEntidad'] );//busca tabla segun tipo objetivo
		$nroId=GLO_generoID($tablaobj,$conn);
		$query="INSERT INTO $tablaobj (Id,Titulo,Nombre,Fecha,Anio) VALUES ($nroId,'$tit','$det','$fechaa',$anio)"; 
		$rs=mysql_query($query,$conn); 
		if ($rs){GLO_feedback(1);$grabook=1;}else{
			$_SESSION['GLO_msgE']="Los cambios no se grabaron. Por favor verifique si el A&ntilde;o ya fue registrado";
			$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Consulta.php?ido=".intval($_POST['TxtNroEntidad']));
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:Alta.php?ido=".intval($_POST['TxtNroEntidad']));
		}			
	}	
}






?>

