<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFuncionesA.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	include ("Includes/zDatosA.php");
	ASIG_validarfecha($id,$idinstr,$fechasok,$fechaa,$fechae,$fechab,$conn);
	if($fechasok==1){	
		//update 
		$query="UPDATE instrumentosasig set FechaH='$fechab',Obs='$obs',TIndef=$ti,FechaE='$fechae' Where Id=$id";$rs=mysql_query($query,$conn);	
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
	if(intval($_SESSION['TxtOriARTAsig'])==0){header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");}
	else{header("Location:Asignaciones.php");}
}

?>


