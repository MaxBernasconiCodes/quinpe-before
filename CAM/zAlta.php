<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

		
if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbProducto']) or empty($_POST['CbCliente']) or empty($_POST['CbPersonal'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatos.php");
		//inserto 
		$nroId=GLO_generoID('cam',$conn);
		$query="INSERT INTO cam(Id,Fecha,FechaV,IdProducto,IdCliente,Lote,Rto,OC,Obs1,Obs2,IdPE1IT,IdPE2IT,IdE,IdPer,IdUser,LoteVto) VALUES ($nroId,'$fa','$fv',$prod,$cli,'$lote','$rto','$oc','$obs1','$obs2',0,0,$est,$per,$paudi,'$fvl')"; 	
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


if (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../CAM.php");
}



?>