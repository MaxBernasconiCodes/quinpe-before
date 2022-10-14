<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFecha']) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:ModificarCub.php?id=".intval($_POST['TxtNumero']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosCub.php");
		//actualizo
		$query="UPDATE unidades_cubiertas set Fecha='$fechaa',IdPersonal=$per,Odo=$km1,Cant=$cant,IdMarca=$marca,Med='$med',Ali=$ali,Bal=$bal,UbiR='$ubir',KmR=$km2,Obs='$obs' Where Id=$id";
		$rs=mysql_query($query,$conn);
		if (!($rs)){GLO_feedback(2);}
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
	}
}



elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
}


?>


