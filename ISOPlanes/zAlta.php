<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST['CmdAceptar'])){ 

		if ( empty($_POST['TxtFecha']) or empty($_POST['TxtCodigo']) or  empty($_POST['TxtNombre']) ){

			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

			GLO_feedback(3);header("Location:Alta.php");

		}else{

			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

			$fecha=FechaMySql($_POST['TxtFecha']);

			$cod=mysql_real_escape_string($_POST['TxtCodigo']);	

			$obs=mysql_real_escape_string($_POST['TxtNombre']);	

			$sec=intval($_POST['CbSector']);	

			//query

			$nroId=GLO_generoID("plan",$conn);

			$query="INSERT INTO plan (Id,Fecha,Codigo,IdSector,Nombre) VALUES ($nroId,'$fecha','$cod',$sec,'$obs')"; 

			$rs=mysql_query($query,$conn);

			if ($rs){GLO_feedback(1);$grabook=1;PL_Auditoria(1,$nroId,$conn);}else{GLO_feedback(2);$grabook=0; } 

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