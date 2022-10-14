<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (isset($_POST['CmdAceptar'])){

	if ((empty($_POST['TxtFecha'])) or (empty($_POST['TxtObs'])) ){

		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		

		GLO_feedback(3);header("Location:ModificarReqSoli.php?id=".intval($_POST['TxtNumero']));

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);

		$fecha=GLO_FechaMySql($_POST['TxtFecha']);	

		$urg=intval($_POST['CbUrg']);

		$obs=mysql_real_escape_string($_POST['TxtObs']);

		$idorden=intval($_POST['TxtIdOrden']);

		$id=intval($_POST['TxtNumero']);

		//verifica que no tenga orden asociada

		if($idorden==0){

			$query="UPDATE pedidosrepreqsoli set Fecha='$fecha',Urg=$urg,Obs='$obs' Where Id=".intval($_POST['TxtNumero']);

			$rs=mysql_query($query,$conn);if (!($rs)){GLO_feedback(2);} 

		}else{GLO_feedback(2);}

		mysql_close($conn); 	

		//limpiar datos del form anterior

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

	}

}









elseif ( isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}





?>





