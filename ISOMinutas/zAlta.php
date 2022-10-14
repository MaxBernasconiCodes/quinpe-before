<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ( empty($_POST['TxtFecha']) or empty($_POST['TxtHora1']) or  empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}
			$hora1=$_POST['TxtHora1'];if($hora1==''){$hora1='00:00';}
			$obs=mysql_real_escape_string($_POST['TxtNombre']);	
			//query
			$nroId=GLO_generoID("iso_minutas",$conn);
			$query="INSERT INTO iso_minutas (Id,Fecha,Hora,Nombre) VALUES ($nroId,'$fecha','$hora1','$obs')"; $rs=mysql_query($query,$conn);
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
		}//cierra 1.	
}//cierra cmd







?>

