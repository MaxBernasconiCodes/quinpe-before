<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//totales estado
//creo temporary table segun tipo dato
if($temptable=="temp_grupochar"){
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_grupochar (Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,valor decimal(10,2) NOT NULL,grupo CHAR(100) NOT NULL)";$rs=mysql_query($query,$conn);
	//la borro por si existia	
	$query = "Delete from $temptable";$rs=mysql_query($query,$conn);
	
	//RESUELTOS (con remito egreso, no genera OC, hay en almacen, no se compra)
	$queryresueltos="Select si.IdItemNP From co_npedido a2,co_npedido_it a,stockmov_items si Where  a.Id<>0 and a2.Id=a.IdNP and si.IdItemNP=a.Id $wherefecha";
	//inserto en temporal
	$query="Select count(si.IdItemNP) as valor, 'RESUELTO' as grupo From co_npedido a2,co_npedido_it a,stockmov_items si Where  a.Id<>0 and a2.Id=a.IdNP and si.IdItemNP=a.Id $wherefecha";
	$rs=mysql_query($query,$conn);	
	while($row=mysql_fetch_array($rs)){
	$queryt="Insert Into $temptable(Id,valor,grupo) values(0,".$row['valor'].",'".$row['grupo']."')";$rst=mysql_query($queryt,$conn);	
	}mysql_free_result($rs);


	//COMPRADOS (con remito ingreso)
	$querycomprados="Select i.IdItemNP From co_npedido a2,co_npedido_it a,co_ocompra_it i,co_ocompra o,stockmov_items si Where  a.Id<>0 and a2.Id=a.IdNP and a.Id=i.IdItemNP and i.IdOCompra=o.Id and o.IdEstado<>3 and o.IdEstado<>6 and si.IdItemOC=i.Id and a.Id NOT IN($queryresueltos) $wherefecha";
	//inserto en temporal
	$query="Select count(i.IdItemNP) as valor, 'COMPRADO' as grupo From co_npedido a2,co_npedido_it a,co_ocompra_it i,co_ocompra o,stockmov_items si  Where a.Id<>0 and a2.Id=a.IdNP and a.Id=i.IdItemNP and i.IdOCompra=o.Id and o.IdEstado<>3 and o.IdEstado<>6 and si.IdItemOC=i.Id and a.Id NOT IN($queryresueltos) $wherefecha";
	$rs=mysql_query($query,$conn);	
	while($row=mysql_fetch_array($rs)){
	$queryt="Insert Into $temptable(Id,valor,grupo) values(0,".$row['valor'].",'".$row['grupo']."')";$rst=mysql_query($queryt,$conn);	
	}mysql_free_result($rs);
	
	
	
	//EN PROCESO (tiene OC, pero n o tiene RI)
	$queryenproceso="Select i.IdItemNP From co_npedido a2,co_npedido_it a,co_ocompra_it i,co_ocompra o Where  a.Id<>0 and a2.Id=a.IdNP and a.Id=i.IdItemNP and i.IdOCompra=o.Id and o.IdEstado<>3 and o.IdEstado<>6 and a.Id NOT IN($querycomprados) $wherefecha";
	//inserto en temporal
	$query="Select count(i.IdItemNP) as valor, 'EN PROCESO' as grupo From co_npedido a2,co_npedido_it a,co_ocompra_it i,co_ocompra o  Where a.Id<>0 and a2.Id=a.IdNP and a.Id=i.IdItemNP and i.IdOCompra=o.Id and o.IdEstado<>3 and o.IdEstado<>6 $wherefecha and a.Id NOT IN($querycomprados)";
	$rs=mysql_query($query,$conn);	
	while($row=mysql_fetch_array($rs)){
	$queryt="Insert Into $temptable(Id,valor,grupo) values(0,".$row['valor'].",'".$row['grupo']."')";$rst=mysql_query($queryt,$conn);	
	}mysql_free_result($rs);
	
	//todos los estados menos EN PROCESO, COMPRADO, RESUELTO
	$query="Select count(a.Id) as valor, $groupcol as grupo From co_npedido a2,co_npedido_it a $grouptable Where a.Id<>0 and a2.Id=a.IdNP $groupjoin $wherefecha and a.Id NOT IN($querycomprados) and a.Id NOT IN($queryenproceso) and a.Id NOT IN($queryresueltos) Group by $groupcol";$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
	$queryt="Insert Into $temptable(Id,valor,grupo) values(0,".$row['valor'].",'".$row['grupo']."')";$rst=mysql_query($queryt,$conn);	
	}mysql_free_result($rs);
	
	//totales
	$querycest="Select sum(t.valor) as valor,t.grupo From $temptable t Group by t.grupo";	

}else{

	//totales cantidad
	$queryc="Select count(a.Id) as valor, $groupcol as grupo From co_npedido a2,co_npedido_it a $grouptable Where a.Id<>0 and a2.Id=a.IdNP $groupjoin $wherefecha Group by $groupcol";
	//top 
	$querytopc="Select x.* From ($queryc) x Order by x.valor desc limit 6";

}

?>