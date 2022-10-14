<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//variables
$iditem=0;$iditem2=0;$cant=0;$modifstock=0;$cantsinfactor=0;


//obtengo datos del item articulo+cant o prod+cant
$query="Select s.*,a.Stock From stockmov_items s,epparticulos a Where s.IdArticulo=a.Id and s.Id=$id";
$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$iditem=$row['IdArticulo'];$iditem2=$row['IdItem'];	$cant=$row['Cantidad'];$modifstock=$row['Stock'];
	$etapaproc=$row['Etapa'];$cantsinfactor=$row['CantSinFactor'];
}mysql_free_result($rs);


//borro item
$query="Delete From stockmov_items Where Id=$id";$rs=mysql_query($query,$conn);
if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 


//actualizo stock si el articulo modifica stock (Stock=1) o si es producto
if ($rs and ($modifstock==1 or $iditem2!=0)){	
	//busco stock en stockdepositos segun articulo+dep  o producto+dep
	if($iditem!=0){
		$query="Select * From stockdepositos Where IdArticulo=$iditem and IdDeposito=$iddep and IdCliente=$idcliprop";
	}else{
		$query="Select * From stockdepositos Where IdItem=$iditem2 and IdDeposito=$iddep and IdCliente=$idcliprop";
	}
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){$nroIdsd=0;$stock=0;}else{$nroIdsd=$row['Id'];$stock=$row['Stock'];}
	mysql_free_result($rs);	


	//verifico tipo movimiento (suma(1AI,3RI) o resta(2AE,4RE) pero al reves porque anula )
	if($idtipo==1 or $idtipo==3){$stock=$stock-$cant;}	else{$stock=$stock+$cant;}

	//actualizo stock
	if($nroIdsd!=0){$query="Update stockdepositos Set Stock=$stock Where Id=$nroIdsd";$rs=mysql_query($query,$conn);}

	//actualizo cantidad ingresada a planta (solo si corresponde a etapa ingreso planta 3)
	if($idcam!=0 and $etapaproc==3){
		//busco item producto barrera
		$query="Select a1.Id,a1.CantI From cam a,procesosop_e1_it a1 Where a.IdPE1IT=a1.Id and a.Id=$idcam";
		$rs=mysql_query($query,$conn);	$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$cantipl=0;$iditproc=0;}else{$cantipl=$row['CantI'];$iditproc=$row['Id'];}
		mysql_free_result($rs);	
		//actualizo cantidad ingresada a planta
		//verifico tipo movimiento (suma(1AI,3RI) o resta(2AE,4RE) pero al reves porque anula )
		if($idtipo==1 or $idtipo==3){$cantipl=$cantipl-$cantsinfactor;}else{$cantipl=$cantipl+$cantsinfactor;}
		$query="Update procesosop_e1_it Set CantI=$cantipl Where Id=$iditproc";$rs=mysql_query($query,$conn);
	}
}



?>