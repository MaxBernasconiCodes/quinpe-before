<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST['CmdAceptar'])){
	if ( floatval($_POST['TxtCantidad'])==0 ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}	
		GLO_feedback(3);header("Location:ModificarItemRI.php?IdItem=".intval($_POST['TxtNumero'])."&Id=".intval($_POST['TxtNroEntidad']));	
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//datos remito
		$query="SELECT * From stockmov where Id=".intval($_POST['TxtNroEntidad']);$rs=mysql_query($query,$conn);
		while($row=mysql_fetch_array($rs)){
			$iddep=$row['IdDeposito'];$idtipo=$row['IdTipoMov'];$idcliprop=$row['IdCliente'];
		}mysql_free_result($rs);
		//datos item
		$iditem=intval($_POST['TxtIdArticulo']);
		$iditem2=intval($_POST['TxtIdItem']);
		$cantini=floatval($_POST['TxtCantidadInicial']);
		$cant=floatval($_POST['TxtCantidad']);	
		if($idtipo==1 or $idtipo==3){$cantcs=$cant;}else{$cantcs=-$cant;}	
		$idcam=0;$etapaproc=0;
	  	//update
		$query="UPDATE stockmov_items set Cantidad=$cant,CantidadCS=$cantcs Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
		//stock
		if($rs){
			//calculo ajuste(solo suma pendiente)
			$cant=$cant-$cantini; 	
			include("Includes/zAltaMovStock.php");
		}
		mysql_close($conn); 
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True&".$query);

	}

}






elseif (isset($_POST['CmdSalir'])){

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");

}



?>