<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){ 
	if ( (empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaDes.php?gid=".intval($_POST['TxtNroEntidad'])."&gidp=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatosEP.php");		
		//inserto
		$nroId=GLO_generoID('proveedores_des',$conn);
		$query="INSERT INTO proveedores_des (Id,IdEntidad,Fecha,IdP1,IdP2,E1,E2,E3,E4,E5,E6,E7,E8,E9,E10,E11,E12,I1,I2,I3,I4,I5,I6,I7,I8,I9,I10,I11,I12) VALUES ($nroId,$idprov,'$fechaa',$p1,$p2,$e1,$e2,$e3,$e4,$e5,$e6,$e7,$e8,$e9,$e10,$e11,$e12,'$i1','$i2','$i3','$i4','$i5','$i6','$i7','$i8','$i9','$i10','$i11','$i12')";$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarDes.php?gidf=1&gid=".$nroId);
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaDes.php?gid=".intval($_POST['TxtNroEntidad']));
		}			
	}
}




elseif (isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

