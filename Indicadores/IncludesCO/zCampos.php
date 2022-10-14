<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if ( empty($_SESSION['TxtFechaDI']) ){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=0;
	$_SESSION['TxtFechaDI']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaHI']=$hoy;
}


GLO_tituloypath(0,650,'../Inicio.php','COMPRAS','linksalir'); 
?>
<table width="650" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="130"></td><td width="90"></td><td width="100"></td><td width="70"></td><td width="100"></td></tr>
<tr> <td height="18"  align="right">Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaDI","../Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaHI","../Codigo/","actual",1); ?></td><td height="18" align="right">Sector:</td><td>&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td  align="right"  colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
//valido periodo
if( empty($_SESSION['TxtFechaDI'])  or  empty($_SESSION['TxtFechaHI']) ){
	echo '<p class="MuestraError" align="center">Por favor seleccione el periodo</p>';
}else{
	//filtro fechas 
	$wherefecha="and (DATEDIFF(a2.Fecha,'".GLO_FechaMySql($_SESSION['TxtFechaDI'])."')>=0) and (DATEDIFF(a2.Fecha,'".GLO_FechaMySql($_SESSION['TxtFechaHI'])."')<=0) ";
	//otros filtros
	$sec=intval($_SESSION['CbSector']);if($sec!=0){$wsec="and a2.IdSector=$sec";}else{$wsec='';}
	//integrado
	$wherefecha=$wherefecha.' '.$wsec.' '.$wherecomun;


	
	
	// traigo cant del mes por estado
	$groupcol="e.Nombre";$grouptable=",co_npedido_est e";$groupjoin="and a.IdEstado=e.Id";$temptable="temp_grupochar";
	$i=0; $array1[$i][0] = 'grupo';$array1[$i][1] = 'valor';$i=1;
	include("IncludesCO/zQuerys.php") ;
	$rs=mysql_query($querycest,$conn);
	while($row=mysql_fetch_array($rs)){	
		$array1[$i][0] = $row['grupo'];$array1[$i][1] = round($row['valor']);$i++;
	}mysql_free_result($rs);
	
	
	// traigo cant del mes por sector
	$groupcol="s.Nombre";$grouptable=",sector s";$groupjoin="and a2.IdSector=s.Id";$temptable="";
	$i=0; $array2[$i][0] = 'grupo';$array2[$i][1] = 'valor';$i=1;
	include("IncludesCO/zQuerys.php") ;
	$rs=mysql_query($queryc,$conn);
	while($row=mysql_fetch_array($rs)){	
		$array2[$i][0] = $row['grupo'];$array2[$i][1] = round($row['valor']);$i++;
	}mysql_free_result($rs);
	
	
	// traigo cant del mes por art (top)
	$groupcol="e.Nombre";$grouptable=",epparticulos e";$groupjoin="and a.IdArticulo=e.Id and a.IdArticulo<>0";$temptable="";
	$i=0; $array3[$i][0] = 'grupo';$array3[$i][1] = 'valor';$i=1;
	include("IncludesCO/zQuerys.php") ;
	$rs=mysql_query($querytopc,$conn);
	while($row=mysql_fetch_array($rs)){	
		$array3[$i][0] = substr($row['grupo'],0,25);$array3[$i][1] = round($row['valor']);$i++;
	}mysql_free_result($rs);
	
	// traigo cant del mes por prov (top)
	$groupcol="p.Apellido";$grouptable=",co_ocompra_it i,co_ocompra o,proveedores p";$groupjoin="and a.Id=i.IdItemNP and i.IdOCompra=o.Id and o.IdProv=p.Id and o.IdProv<>0";$temptable="";
	$i=0; $array4[$i][0] = 'grupo';$array4[$i][1] = 'valor';$i=1;
	include("IncludesCO/zQuerys.php") ;
	$rs=mysql_query($querytopc,$conn);
	while($row=mysql_fetch_array($rs)){	
		$array4[$i][0] = substr($row['grupo'],0,25);$array4[$i][1] = round($row['valor']);$i++;
	}mysql_free_result($rs);


	//graficos
	include("zCharts.php") ; 
}	


?>