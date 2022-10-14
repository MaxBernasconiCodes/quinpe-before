<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtAnio']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		$anio=intval($_POST['TxtAnio']); 
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM pssa";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//query
		$query="INSERT INTO pssa (Id,Year,FechaA) VALUES ($nroId,$anio,'$fechaa')"; 
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




elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSSA.php");
}


?>

