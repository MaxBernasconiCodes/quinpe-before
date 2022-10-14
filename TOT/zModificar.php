<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST['CmdAceptar'])){

	if ( empty($_POST['CbCentro']) or empty($_POST['TxtFechaA']) ){

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		

	    GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		include ("Includes/zDatos.php");

		//update

		$query="Update tot Set Fecha='$fa',IdCentro=$ctro,IdCliente=$cli,IdSector=$sec,IdPersonal=$per,IdPersonal2=$per2,IdCat=$cat,AccionR='$obs3',Cons='$obs4',AccionCP='$obs5',O1=$o1,O2=$o2,Estado=$o3 Where Id=$id";

		$rs=mysql_query($query,$conn);

		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

		mysql_close($conn); 

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}

		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

	}

}












?>