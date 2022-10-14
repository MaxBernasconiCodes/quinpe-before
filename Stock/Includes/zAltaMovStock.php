<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//variables
$modifstock=0;

//obtengo datos del articulo
if($iditem!=0){
	$query="Select a.Stock From epparticulos a Where a.Id=$iditem";$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$modifstock=$row['Stock'];}mysql_free_result($rs);
}

//actualizo stock si el articulo modifica stock (Stock=1) o si es producto
if ($modifstock==1 or $iditem2!=0){
	//verifico si existe en stockdepositos el articulo+dep o producto+dep
	$nroIdsd=0;$stock=0;
	if($iditem!=0){
		$query="Select * From stockdepositos Where IdArticulo=$iditem and IdDeposito=$iddep and IdCliente=$idcliprop";
	}else{
		$query="Select * From stockdepositos Where IdItem=$iditem2 and IdDeposito=$iddep and IdCliente=$idcliprop";
	}	
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$nroIdsd=$row['Id'];$stock=$row['Stock'];}mysql_free_result($rs);



	//verifico tipo movimiento (suma(1AI,3RI) o resta(2AE,4RE) )
	if($idtipo==1 or $idtipo==3){$stock=$stock+$cant;}else{$stock=$stock-$cant;}			

	//si no existe inserto, si existe update
	if($nroIdsd==0){
		$nroIdsd=GLO_generoID("stockdepositos",$conn);
		$query="INSERT INTO stockdepositos (Id,IdDeposito,IdArticulo,Stock,IdItem,IdCliente) VALUES ($nroIdsd,$iddep,$iditem,$stock,$iditem2,$idcliprop)";$rs=mysql_query($query,$conn);
	}else{		
		$query="Update stockdepositos Set Stock=$stock Where Id=$nroIdsd";$rs=mysql_query($query,$conn);
	}

	//actualizo cantidad ingresada a planta (solo si corresponde a etapa ingreso planta 3)
	if($idcam!=0 and $etapaproc==3){
		//busco item producto barrera
		$query="Select a1.Id,a1.CantI From cam a,procesosop_e1_it a1 Where a.IdPE1IT=a1.Id and a.Id=$idcam";
		$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$cantipl=0;$iditproc=0;}else{$cantipl=$row['CantI'];$iditproc=$row['Id'];}
		mysql_free_result($rs);	
		//verifico tipo movimiento (suma(1AI,3RI) o resta(2AE,4RE) )
		if($idtipo==1 or $idtipo==3){$cantipl=$cantipl+$cantsinfactor;}else{$cantipl=$cantipl-$cantsinfactor;}
		//actualizo cantidad ingresada a planta
		$query="Update procesosop_e1_it Set CantI=$cantipl Where Id=$iditproc";$rs=mysql_query($query,$conn);
	}
	
}



?>