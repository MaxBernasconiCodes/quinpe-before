<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,650,'../Inicio.php','NOMINA','linksalir'); 
?>
<table width="650" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="100"></td><td width="120"></td><td width="80"></td><td width="120"></td><td width="70"></td><td width="120"></td><td width="50"></td></tr>
<tr> <td height="18" align="right">Sector:</td><td >&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td align="right"></td><td >&nbsp;</td><td align="right"></td><td >&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
//filtros
$sec=intval($_SESSION['CbSector']);if($sec!=0){$wsec="and a.IdSector=$sec";}else{$wsec='';}
$wherecomun=" and a.FechaBaja='0000-00-00'";//nomina activa

// traigo cant del mes por sector
$groupcol="c.Nombre";$grouptable=",sector c";$groupjoin="and c.Id=a.IdSector";
$i=0; $array1[$i][0] = 'grupo';$array1[$i][1] = 'valor';$i=1;
include("IncludesRR2/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array1[$i][0] = $row['grupo'];$array1[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);
	

// traigo cant del mes por estudios
$groupcol="c.Nombre";$grouptable=",estudios c";$groupjoin="and c.Id=a.IdEstudios";
$i=0; $array2[$i][0] = 'grupo';$array2[$i][1] = 'valor';$i=1;
include("IncludesRR2/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array2[$i][0] = $row['grupo'];$array2[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);


// traigo cant por franja de edad
$i=0; $array3[$i][0] = 'grupo';$array3[$i][1] = 'valor';$i=1;
include("IncludesRR2/zQuerys.php") ;
$rs=mysql_query($queryfr1,$conn);
while($row=mysql_fetch_array($rs)){	
	$array3[$i][0] = $row['grupo'];$array3[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);



// traigo cant por franja de antigedad
$i=0; $array4[$i][0] = 'grupo';$array4[$i][1] = 'valor';$i=1;
include("IncludesRR2/zQuerys.php") ;
$rs=mysql_query($queryfr2,$conn);
while($row=mysql_fetch_array($rs)){	
	$array4[$i][0] = $row['grupo'];$array4[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);


//graficos
include("zCharts.php") ; 

?>