<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAddFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$idcam=intval($_POST['TxtId']);
	$factor=floatval($_POST['TxtFactor']);//valor factor	
	$aListanrodep=$_POST['CbDeposito'];//array valor deposito
	$aListacant=$_POST['TxtCant'];//array valor cantidad
	//valido si puede ingresar el cam
	PLA_puedeingresarcam($idcam,$iditem,$iditem2,$cant,$existerto,$idcliprop,$llevafactor,$conn);
	//recorro depositos y verifico que la cantidad total sea correcta y que tenga deposito cada cantidad
	$total=0; $cantprod=$cant;$errordep=0; 
	for ($i=1; $i<6; $i=$i+1) { 
		$cantsub=floatval($aListacant[$i]);
		$depsub=intval($aListanrodep[$i]);
		$total=$total+$cantsub;//suma cantidades		
		//valida cant+depositos completos (que no tenga solo uno de los datos)
		if( ($cantsub!=0 and $depsub==0) or ($cantsub==0 and $depsub!=0) ){$errordep=1;}
	}
	//valido si requiere factor
	if($llevafactor==1 and $factor==0){$factorok=0;}else{$factorok=1;}
	//valido si  tiene cantidad y no se ingreso, la cant total es correcta y tiene los depositos
	if($cant!=0 and $existerto==0 and $total==$cantprod and $errordep==0 and $factorok==1){
		//inserto RIs
		for ($i=1; $i<6; $i=$i+1) { 
			$iddep=intval($aListanrodep[$i]);
			$cant=floatval($aListacant[$i]);
			if($iddep!=0 and $cant!=0){include("Includes/zInsertaRI.php") ;}		
		}
	}else{
		$grabook=0;
		if($factorok==0){$_SESSION['GLO_msgE']='Por favor seleccione el factor de conversion';}
		if($total!=$cantprod){$_SESSION['GLO_msgE']='Por favor revise la cantidad ingresada ';}
		if($errordep==1){$_SESSION['GLO_msgE']='Por favor seleccione los depositos y cantidades ';}
		if($cant==0){$_SESSION['GLO_msgE']='Falta completar la cantidad del producto en Barrera';}
		if($existerto!=0){$_SESSION['GLO_msgE']='Ya existe un remito de ingreso incompleto asociado nro '.$existerto;}
	}
	mysql_close($conn); 
	//volver
	if($grabook==1){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Inbox.php");
	}else{
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		header("Location:InboxD.php?id=".intval($idcam));//pasa idcam
	}	
}





?>