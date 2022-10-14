<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ( intval($_POST['TxtNro'])==0  or  empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatos.php");
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM extintores";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
		//query
		$query="INSERT INTO extintores (Id,Nro,IdUnidad,Ubicacion,IdProd,Capacidad,Chapa,Manguera,Collarin,Precinto,Exterior,Vto,VtoPH,Obs,Baja) VALUES ($nroId,$nro,$uni,$ubi,$prod,$cap,'$op1','$op2','$op3','$op4','$op5','$fechaa','$fechab','$obs',$baja)"; 
		$rs=mysql_query($query,$conn); 
		if ($rs){$grabook=1;}
		else{GLO_feedback(2);$grabook=0;$_SESSION['GLO_msgE'] .='. Verifique si ya se asigno a otra Unidad'; } 
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

