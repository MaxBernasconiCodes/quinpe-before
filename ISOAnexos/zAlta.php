<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos 
		if (empty($_POST['TxtNombre'])){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
			$ori=mysql_real_escape_string(ltrim($_POST['CbOrigen']));
			$sec=intval($_POST['CbSector']);
			//query			
			$nroId=GLO_generoID("iso_anexos",$conn);
			$query="INSERT INTO iso_anexos (Id,Nombre,Ruta,Origen,IdSector) VALUES ($nroId,'$nom','','$ori',$sec)"; $rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			//cierro conx	
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

