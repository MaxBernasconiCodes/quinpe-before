<? include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtAnio']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&ido=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$anio=intval($_POST['TxtAnio']); 
		$fechaa=GLO_FechaMySql($_POST['TxtFechaA']);
		$tit=mysql_real_escape_string($_POST['TxtTitulo']);
		$det=mysql_real_escape_string($_POST['TxtTexto']);		
		//update
		$tablaobj=OBJ_tabla($_POST['TxtNroEntidad'] );//busca tabla segun tipo objetivo
		$query="UPDATE $tablaobj set Titulo='$tit',Nombre='$det',Fecha='$fechaa',Anio=$anio Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//volver
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Consulta.php?ido=".intval($_POST['TxtNroEntidad']));		
	}		
}






?>