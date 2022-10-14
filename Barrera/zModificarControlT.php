<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(13);



if (isset($_POST['CmdAceptar'])){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//Id procesosop_e1
		//elimino y vuelvo a grabar		
		$query="Delete From procesosop_e1_ct Where IdPadre=$ident";$rs=mysql_query($query,$conn);
		for ($i=1; $i < 7; $i= $i +1) {
			$opt='OptI'.$i;$txt='TxtOI'.$i;
			$val=intval($_POST[$opt]);
			$obs=mysql_real_escape_string($_POST[$txt]);
			//inserto si completa algo
			if($val!=0 or $obs!=''){
				$nroId=GLO_generoID("procesosop_e1_ct",$conn);
				$query="INSERT INTO procesosop_e1_ct (Id,IdPadre,Item,Valor,Obs) VALUES ($nroId,$ident,$i,$val,'$obs')";
				$rs=mysql_query($query,$conn);
			}
		}			
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarControlT.php?id=".intval($_POST['TxtNroEntidad']));
}


elseif (isset($_POST['CmdEliminar'])){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//Id procesosop_e1
		//elimino y vuelvo a grabar		
		$query="Delete From procesosop_e1_ct Where IdPadre=$ident";$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


elseif ( isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>


