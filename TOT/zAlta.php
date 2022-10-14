<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



		

if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['CbCentro']) or empty($_POST['TxtFechaA']) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		

	    GLO_feedback(3);header("Location:Alta.php");

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		include ("Includes/zDatos.php");

		//inserto 

		$nroId=GLO_generoID('tot',$conn);

		$query="INSERT INTO tot(Id,Fecha,IdCentro,IdCliente,IdSector,IdPersonal,IdPersonal2,IdCat,AccionR,Cons,AccionCP,O1,O2,Estado) VALUES ($nroId,'$fa',$ctro,$cli,$sec,$per,$per2,$cat,'$obs3','$obs4','$obs5',$o1,$o2,$o3)"; 	

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