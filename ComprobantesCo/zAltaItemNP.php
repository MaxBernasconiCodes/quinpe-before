<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	//debe tener articulo, producto u observaciones
	if ( ( intval($_POST['CbItem'])==0 and intval($_POST['CbItem2'])==0 and empty($_POST['TxtObs'])) or (floatval($_POST['TxtCantidad'])==0) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}
		$_SESSION['GLO_msgE']='Complete Cantidad e Item a solicitar';
		header("Location:AltaItemNP.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=False");
	}else{
		if(intval($_POST['CbItem'])!=0 and intval($_POST['CbItem2'])!=0){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}
			$_SESSION['GLO_msgE']='Seleccione Art&iacute;culo o Producto, no ambos';
			header("Location:AltaItemNP.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=False");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$ident=intval($_POST['TxtNroEntidad']);//idcomprobante
			$iditem=intval($_POST['CbItem']);
			$iditem2=intval($_POST['CbItem2']);
			$prov=intval($_POST['CbProv']);
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$cant=floatval($_POST['TxtCantidad']);
			if($iditem==0 and $iditem2==0){$finc=1;}else{$finc=0;}//identifica los que traen observacion en vez de articulo	
			//valido que tenga perfil para agregar items
			$query="SELECT IdPerSoli,IdUsr,IdPerPAuto,IdPerAuto From co_npedido where Id=$ident";$rs=mysql_query($query,$conn);
			$vsoli=0;$vuser=0;$vpauto=0;$vauto=0;
			while($row=mysql_fetch_array($rs)){
				$vsoli=$row['IdPerSoli'];$vuser=$row['IdUsr'];$vpauto=$row['IdPerPAuto'];$vauto=$row['IdPerAuto'];
			}mysql_free_result($rs);
			//alta si es solicitante o quien registro
			if( intval($_SESSION["GLO_IdPersLog"])==$vsoli or intval($_SESSION["GLO_IdPersLog"])==$vuser ){$essolioreg=1;}else{$essolioreg=0;}
			//o  es perfil compras
			if( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11 ){$escompras=1;}else{$escompras=0;}
			//o  es auto
			if( intval($_SESSION["GLO_IdPersLog"])==$vauto ){$esauto=1;}else{$esauto=0;}
			//o si es preauto 
			if( intval($_SESSION["GLO_IdPersLog"])==$vpauto ){$espreauto=1;}else{$espreauto=0;}
			//valido
			if( $essolioreg==1 or $escompras==1 or $esauto==1 or $espreauto==1){
				//inserto
				if($ident!=0){//estan cargando items con con IdNP=0
					$canta=0;$est=1;$fa='0000-00-00';$fpa='0000-00-00';$fcom='0000-00-00';
					include("Includes/zAltaNPI.php");
				}
			}
			mysql_close($conn); 	
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}
	}

}


//articulos o productos
elseif (isset($_POST['CmdExBuscar']) or isset($_POST['CmdExBuscar2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	header("Location:AltaItemNP.php?Id=".intval($_POST['TxtNroEntidad'])."&Flag1=False");
}



elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}






?>