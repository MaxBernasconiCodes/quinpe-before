<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBorrarFila'])){ 
	$idobjetivo=intval($_POST['TxtNroEntidad']);
	$tablaobj=OBJ_tabla($_POST['TxtNroEntidad'] );
	if($idobjetivo>0 and $idobjetivo<6){
		//elimina
		$query="Delete From $tablaobj Where Id=".intval($_POST['TxtId']);
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
	}
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Consulta.php?ido=".intval($_POST['TxtNroEntidad']));
}

elseif (isset($_POST['CmdAgregar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Alta.php?ido=".intval($_POST['TxtNroEntidad']));//le pasa el id del objetivo a crear
}

elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:".OBJ_volver($_POST['TxtNroEntidad']).".php");
}


?>