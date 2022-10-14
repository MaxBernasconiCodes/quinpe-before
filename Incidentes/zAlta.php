<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

		
if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtHora'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatos.php");
		//inserto 
		$nroId=GLO_generoID('incidentes',$conn);
		$query="INSERT INTO incidentes(Id,IdPersonal,Fecha,Hora,IdSector,IdYac,C1,C2,C3,C4,C5,Obs,Tipo1,Tipo2,Obs1,Obs2,Obs3,Obs4,IdE) VALUES ($nroId,$per,'$fa','$hora',$sec,$yac,$c1,$c2,$c3,$c4,$c5,'$obs',$t1,$t2,'$obs1','$obs2','$obs3','$obs4',$est)"; 									
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