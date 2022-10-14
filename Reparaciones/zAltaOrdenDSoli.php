<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){ 

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	if (empty($_POST['TxtFecha1'])){$fecha1=date("Y-m-d");}else{$fecha1=FechaMySql($_POST['TxtFecha1']);}	

	$uni=intval($_POST['TxtIdUnidad']); 

	$soli=intval($_POST['CbSoli']);

	$idorden=intval($_POST['TxtIdOrden']);

	$wq1='';$wq2='';

	for ($i=1; $i < 19; $i= $i +1) {$wq1=$wq1.",I".$i;}

	for ($i=1; $i < 19; $i= $i +1) {$wq2=$wq2.",0";}

	if($idorden==0){//verifica que no tenga orden asociada

		//insert

		$nroId=GLO_generoID('pedidosrepord',$conn);

		$query="INSERT INTO pedidosrepord (Id,IdUnidad,Fecha,FechaI,FechaE,FechaIT,IdEstado,Km,Hs,Obs,IdSoli,IdPersonalPL,FechaPL,ObsPL,ListoPL".$wq1.") VALUES ($nroId,$uni,'$fecha1','0000-00-00','0000-00-00','0000-00-00',1,0,0,'',$soli,0,'0000-00-00','',0".$wq2.")"; 

		$rs=mysql_query($query,$conn); 

		if ($rs){

			$grabook=1;REP_updateestadoorden($conn,$nroId,1);

			//asigo orden a la solicitud

			if ($soli!=0){

				$query="UPDATE pedidosrep set IdOrden=$nroId,IdEstado=3 Where IdOrden=0 and Id=$soli";$rs=mysql_query($query,$conn);

			}			

		}else{GLO_feedback(2);$grabook=0; } //error al grabar

	}else{GLO_feedback(2);$grabook=0;}//hack-solicitud con orden asociada

	mysql_close($conn); 			

	//volver

	if($grabook==1){

		foreach($_POST as $key => $value){$_SESSION[$key] = "";}

		header("Location:ModificarOrden.php?id=".$nroId."&Flag1=True");

	}else{

		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

		header("Location:AltaOrdenDSoli.php?id=".intval($_POST['CbSoli']));//pasa el nro de solicitud

	}			

}









elseif ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:Modificar.php?id=".intval($_POST['CbSoli'])."&Flag1=True");

}





?>



