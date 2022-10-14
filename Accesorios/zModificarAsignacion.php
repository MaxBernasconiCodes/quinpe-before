<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);



if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	include ("Includes/zDatosA.php");
	ASIG_validarfecha($id,$idinstr,$fechasok,$fechaa,$fechae,$fechab,$conn);
	if($fechasok==1){	
		//update 
		$query="UPDATE accesorios_asig set FechaH='$fechab',Obs='$obs',IdPersonal=$pers,TIndef=$ti,FechaE='$fechae' Where Id=$id";$rs=mysql_query($query,$conn);	
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 		
	}
	//vuelvo
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarAsignacion.php?id=".intval($_POST['TxtNumero']));
}



elseif ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	//vuelvo
	if(intval($_SESSION['TxtOriACCAsig'])==0){header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}
	else{header("Location:Asignaciones.php");}
}

?>


