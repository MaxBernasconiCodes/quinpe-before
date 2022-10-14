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
		header("Location:AltaOrden.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFecha1'])){$fecha1=date("Y-m-d");}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}	
		$uni=intval($_POST['CbUnidad']); 
		$sec=intval($_POST['CbSector']);
		$ins=intval($_POST['CbInstrumento']);
		$wq1='';$wq2='';
		for ($i=1; $i < 19; $i= $i +1) {$wq1=$wq1.",I".$i;}
		for ($i=1; $i < 19; $i= $i +1) {$wq2=$wq2.",0";}
		//insert
		$nroId=GLO_generoID('pedidosrepord',$conn);
		$query="INSERT INTO pedidosrepord (Id,IdUnidad,IdSector,IdInstr,Fecha,FechaI,FechaE,FechaIT,IdEstado,Km,Hs,Obs,IdSoli,IdPersonalPL,FechaPL,ObsPL,ListoPL".$wq1.") VALUES ($nroId,$uni,$sec,$ins,'$fecha1','0000-00-00','0000-00-00','0000-00-00',1,0,0,'',0,0,'0000-00-00','',0".$wq2.")"; 
		$rs=mysql_query($query,$conn); 
		if ($rs){GLO_feedback(1);$grabook=1;REP_updateestadoorden($conn,$nroId,1);}
		else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarOrden.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaOrden.php");
		}			
	}	
}






?>

