<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	if ( intval($_POST['TxtNro'])==0  or  empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatos.php");
		//updatte
		$query="UPDATE extintores set Nro=$nro,IdUnidad=$uni,Ubicacion=$ubi,IdProd=$prod,Capacidad=$cap,Chapa='$op1',Manguera='$op2',Collarin='$op3',Precinto='$op4',Exterior='$op5',Vto='$fechaa',VtoPH='$fechab',Obs='$obs',Baja=$baja Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);$_SESSION['GLO_msgE'] .='. Verifique si ya se asigno a otra Unidad';} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}






?>


