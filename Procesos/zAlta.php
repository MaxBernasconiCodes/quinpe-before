<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

		
if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbCliente'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fa=GLO_FechaMySql($_POST['TxtFechaA']);			
		$cli=intval($_POST['CbCliente']);
		$obs=mysql_real_escape_string(ltrim($_POST['TxtObs']));
		//inserto (estado 0 abierto)
		$nroId=GLO_generoID('procesosop',$conn);
		$query="INSERT INTO procesosop(Id,Fecha,IdCliente,Estado,Obs) VALUES ($nroId,'$fa',$cli,0,'$obs')";
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0;} 
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