<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ( empty($_POST['TxtFecha']) or empty($_POST['CbPersonal']) or  empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");
			//query			
			$nroId=GLO_generoID("iso_cambios",$conn);
			$query="INSERT INTO iso_cambios (Id,Fecha,Nombre,Razon,Req,IdPersonal,Estado,Prio,Obs,FechaE,Obs2,FechaR,Res) VALUES ($nroId,'$fecha','$nom','$raz','$req',$per,$est,$prio,'$obs','$fechae','$obs2','$fechar',$res)"; $rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:Alta.php");
			}			
		}//cierra 1.	
}//cierra cmd




elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../ISO_Cambios.php");
}

elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../ISO_Cambios.php");
}


?>

