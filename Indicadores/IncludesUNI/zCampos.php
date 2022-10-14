<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=9){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



GLO_tituloypath(0,650,'../Inicio.php','UNIDADES','linksalir'); 
?>
<table width="650" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="100"></td><td width="130"></td><td width="80"></td><td width="130"></td><td width="20"></td><td width="150"></td><td width="50"></td></tr>
<tr> <td height="18"  align="right">Sector:</td><td >&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td align="right"></td><td ><input name="ChkAfe"  type="checkbox" tabindex="7"  class="check" value="1" <? if ($_SESSION['ChkAfe'] =='1') echo 'checked'; ?>>Afectadas</td><td align="right"></td><td>&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
//filtros
$sec=intval($_SESSION['CbSector']);if($sec!=0){$wsec="and a.IdSector=$sec";}else{$wsec='';}
$afe=intval($_SESSION['ChkAfe']);if($afe!=0){$wafe="and a.Afectado=$afe";}else{$wafe='';}
$wherecomun=" and a.FechaBaja='0000-00-00'";//nomina activa


// traigo cant del mes por sector
$groupcol="c.Nombre";$grouptable=",sector c";$groupjoin="and c.Id=a.IdSector";
$i=0; $array1[$i][0] = 'grupo';$array1[$i][1] = 'valor';$i=1;
include("IncludesUNI/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array1[$i][0] = $row['grupo'];$array1[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);
	
/*
// traigo cant del mes por servicios
$groupcol="c.Nombre";$grouptable=",servicios c";$groupjoin="and c.Id=a.IdServicio";
$i=0; $array2[$i][0] = 'grupo';$array2[$i][1] = 'valor';$i=1;
include("IncludesUNI/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array2[$i][0] = $row['grupo'];$array2[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);
*/

// traigo cant por categoria
$groupcol="c.Nombre";$grouptable=",unidadescateg c";$groupjoin="and c.Id=a.IdCateg";
$i=0; $array3[$i][0] = 'grupo';$array3[$i][1] = 'valor';$i=1;
include("IncludesUNI/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array3[$i][0] = $row['grupo'];$array3[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);



// traigo cant por estado
$groupcol="c.Nombre";$grouptable=",unidadescond c";$groupjoin="and c.Id=a.IdCond";
$i=0; $array4[$i][0] = 'grupo';$array4[$i][1] = 'valor';$i=1;
include("IncludesUNI/zQuerys.php") ;
$rs=mysql_query($queryac,$conn);
while($row=mysql_fetch_array($rs)){	
	$array4[$i][0] = $row['grupo'];$array4[$i][1] = round($row['valor']);$i++;
}mysql_free_result($rs);


//graficos
include("zCharts.php") ; 

?>