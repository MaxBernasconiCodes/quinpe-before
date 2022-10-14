<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


//grabar los datos en la tabla
$paudi=intval($_SESSION["GLO_IdPersLog"]);//personal registro
$fecha=FechaMySql(date("d-m-Y"));
$ped=intval($_POST['TxtNumero']);//nro pedido
//inserto
$nroId=GLO_generoID('stockmov',$conn);
$query="INSERT INTO stockmov (Id,IdTipoMov,Fecha,IdProveedor,IdDeposito,Obs,Anulado,Tipo,Suc,Nro,IdUnidad,IdPersonal,NroOC,IdCAM,IdPedido,IdUser,IdCliente,IdOrigen,IdInstr,IdSectorM) VALUES ($nroId,$tipo,'$fecha',0,$dep,'',0,'',0,0,0,0,0,0,$ped,$paudi,$cli,$ori,0,0)";$rs=mysql_query($query,$conn);
if ($rs){$_SESSION['GLO_msgE']='Ingrese al Remito y complete los Items a egresar/ingresar';}else{GLO_feedback(2);} 
	
		
	

?>