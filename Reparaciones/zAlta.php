<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	//valida
	$graba=1;$elige=0;
	if (empty($_POST['TxtFecha1'])){$graba=0;GLO_feedback(3);}
	if (!(empty($_POST['CbUnidad']))){$elige++;}
	if (!(empty($_POST['CbSector']))){$elige++;}if (!(empty($_POST['CbInstrumento']))){$elige++;}
	if ($elige==0){$graba=0;$_SESSION['GLO_msgE']='Seleccione Unidad, Sector o Equipo';}
	if ($elige>1){$graba=0;$_SESSION['GLO_msgE']='Seleccione Unidad o Sector o Equipo. Solo una opcion';}	
	//graba
	if($graba==0){	
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fecha1=GLO_FechaMySql($_POST['TxtFecha1']);	
		$fecha2=GLO_FechaMySql($_POST['TxtFecha2']);
		$uni=intval($_POST['CbUnidad']); 
		$sec=intval($_POST['CbSector']);
		$ins=intval($_POST['CbInstrumento']);
		$tipo=intval($_POST['CbTipo']);
		$pers=intval($_POST['CbPersonal']);
		//insert
		$nroId=GLO_generoID('pedidosrep',$conn);
		$query="INSERT INTO pedidosrep (Id,IdUnidad,IdSector,IdInstr,Fecha,FechaSI,IdEstado,IdTipo,IdPersonal,IdOrden) VALUES ($nroId,$uni,$sec,$ins,'$fecha1','$fecha2',1,$tipo,$pers,0)"; $rs=mysql_query($query,$conn); 
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
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

