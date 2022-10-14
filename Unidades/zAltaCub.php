<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtFecha']) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaCub.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosCub.php");
		//inserto
		$nroId=GLO_generoID('unidades_cubiertas',$conn);
		$query="INSERT INTO unidades_cubiertas (Id,IdUnidad,Fecha,IdPersonal,Odo,Cant,IdMarca,Med,Ali,Bal,UbiR,KmR,Obs) VALUES ($nroId,$ident,'$fechaa',$per,$km1,$cant,$marca,'$med',$ali,$bal,'$ubir',$km2,'$obs')";$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarCub.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaCub.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A5');
}



?>

