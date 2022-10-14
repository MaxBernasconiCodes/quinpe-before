<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);

if (isset($_POST['CmdAceptar'])){ 
		if ( empty($_POST['TxtFecha']) or  empty($_POST['CbTipo']) or  empty($_POST['CbTipoE']) or  empty($_POST['TxtNombre'])){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$fecha=intval($_POST['TxtFecha']);
			$nom=mysql_real_escape_string($_POST['TxtNombre']);	
			$nom1=mysql_real_escape_string($_POST['TxtNombre1']);	
			$nom2=mysql_real_escape_string($_POST['TxtNombre2']);	
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$per=intval($_POST['CbPersonal']);
			$sec=intval($_POST['CbSector']);	
			$tipo=intval($_POST['CbTipo']);
			$tipor=intval($_POST['CbTipoR']);
			$tipoe=intval($_POST['CbTipoE']);
			//query
			$nroId=GLO_generoID("programas",$conn);
			$query="INSERT INTO programas (Id,Fecha,IdSector,Nombre,IdTipo,IdTipoE,Obs,T1,T2,IdRef,IdResp) VALUES ($nroId,$fecha,$sec,'$nom',$tipo,$tipoe,'$obs','$nom1','$nom2',$tipor,$per)"; 
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