<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdAceptar'])){ 
	if (empty($_POST['CbDesvio']) ){ 
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}				
	    GLO_feedback(3);header("Location:ModificarDesvio.php?Flag1=True"."&id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);
		$desv=intval($_POST['CbDesvio']);
		$descr=mysql_real_escape_string($_POST['TxtDesc']);
		$accion=mysql_real_escape_string($_POST['TxtAccion']);
	  	//update 
		$query="UPDATE iso_audi_progdes set IdDesvio=$desv,Obs='$descr',Accion='$accion' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}

if (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}

?>