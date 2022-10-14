<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ((empty($_POST['CbClase'])) or (empty($_POST['CbTipo'])) or (empty($_POST['CbCat'])) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaReq.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//IdPR id orden
		$estorden=intval($_POST['TxtIdEstadoO']);
		$clase=intval($_POST['CbClase']);
		$tipo=intval($_POST['CbTipo']);
		$urg=intval($_POST['CbUrg']);
		$cat=intval($_POST['CbCat']);
		$ext=intval($_POST['ChkExt']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		if (empty($_POST['TxtFecha1'])){$fecha1="0000-00-00";}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}//turno
		$prov=intval($_POST['CbProv']);
		if($estorden!=7){//valido que no sea finalizada
			//insert //pedidosrepreq IdPR join Id pedidosrepord
			$nroId=GLO_generoID('pedidosrepreq',$conn);
			$query="INSERT INTO pedidosrepreq (Id,IdPR,Clase,Tipo,Alcance,Urg,IdCat,IdEstado,Obs,FTurno,IdProv,FFin,Pdtes) VALUES ($nroId,$ident,$clase,$tipo,$ext,$urg,$cat,1,'$obs','$fecha1',$prov,'0000-00-00',0)";$rs=mysql_query($query,$conn);
			if ($rs){$grabook=1;REP_updateestadoaccion($conn,$nroId,$ident,1);}
			else{GLO_feedback(2);$grabook=0; } 
		}else{GLO_feedback(2);$grabook=0; }//hack-orden finalizada sin accion
		mysql_close($conn); 	
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarReq.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaReq.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
	}
}


elseif (  isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarOrden.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

