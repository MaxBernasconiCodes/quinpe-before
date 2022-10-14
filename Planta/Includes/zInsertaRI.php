<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


//datos para rto
$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro	
$fecha=FechaMySql(date("d-m-Y"));
$idtipo=3;//remito ingreso
//aplico factor si corresponde
$cantsinfactor=$cant;
if($llevafactor==1){$cant=$cant*$factor;}
//cantidad con signo para conciliar (suma(1AI,3RI) o resta(2AE,4RE) )
if($idtipo==1 or $idtipo==3){$cantcs=$cant;}else{$cantcs=-$cant;}	
//inserto 
$ident=GLO_generoID('stockmov',$conn);
$query="INSERT INTO stockmov (Id,IdTipoMov,Fecha,IdProveedor,IdDeposito,Obs,Anulado,Tipo,Suc,Nro,IdUnidad,IdPersonal,NroOC,IdCAM,IdPedido,IdUser,IdCliente,IdOrigen,IdInstr,IdSectorM) VALUES ($ident,$idtipo,'$fecha',0,$iddep,'',0,'',0,0,0,0,0,$idcam,0,$paudi,$idcliprop,5,0,0)";
$rs=mysql_query($query,$conn);
if ($rs){
	$grabook=1;
	//inserto(etapa 3 ingreso a planta)
	$etapaproc=3;
	$nroId=GLO_generoID("stockmov_items",$conn);
	$query="INSERT INTO stockmov_items (Id,IdMov,IdArticulo,Cantidad,CantidadCS,IdNP,IdItemNP,IdUser,IdItem,IdCAM,IdPedido,IdUniIT,IdEnvIT,LoteIT,Etapa,CantSinFactor) VALUES ($nroId,$ident,0,$cant,$cantcs,0,0,$paudi,$iditem2,$idcam,0,0,0,'',$etapaproc,$cantsinfactor)";
	$rs=mysql_query($query,$conn);
	if($rs){include("../Stock/Includes/zAltaMovStock.php");}
	else{$_SESSION['GLO_msgE']='El remito se grabo incompleto. Por favor eliminelo';}		
}else{GLO_feedback(2);$grabook=0;} 


?>