<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){ 
		//verifica campos requeridos
		if ( empty($_POST['CbTipo']) or empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}
		else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");
			$nroId=GLO_generoID("iso_audi_prog",$conn);
			$query="INSERT INTO iso_audi_prog (Id,IdSector,IdTipo,FechaProg,FechaReal,Obs,IdEstado,IdYac,HoraReal,Duracion,Anulado,IdInstalacion,Dirigido,Obj,Alcance,OP,AP,NC,IdCentro,FechaRProg,Met,Res,Cri,Tipo,Nombre) VALUES ($nroId,$sec,$tipo,'$fechaa','0000-00-00','',1,0,'00:00:00','00:00:00',0,0,'','','','','','',0,'0000-00-00','','','',0,'$nom')"; 
			$rs=mysql_query($query,$conn);
			if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:Alta.php");
			}			

		}		
}




?>

