<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}
?>

<input name="TxtExCriterio" type="text" class="TextBox" style="width:100px" maxlength="20"   tabindex="1" onKeyPress="if(event.keyCode==13){document.Formulario.CmdExBuscar.click();}">&nbsp;<? echo GLO_FAButton('CmdExBuscar','submit','80','self','Buscar','lupa','boton02');?> &nbsp;<select name="CbItem"  class="campos" id="CbItem" style="width:360px">
<? 
//variables
$articulo=intval($_SESSION['CbItem']);
$criterio=mysql_real_escape_string($_SESSION['TxtExCriterio']);
$criterio2=intval($_SESSION['TxtExCriterio']);
//query 
if ($_SESSION['TxtExCriterio']!=""){//si es una busqueda(solo los que modifican stock a.Stock=1)
	$query="(SELECT a.Id,a.Nombre,a.Modelo, m.Nombre as Marca,u.Abr FROM epparticulos a,unidadesmedida u,marcas m where a.Id<>0 and a.FechaBaja='0000-00-00' and a.Stock=1 and a.IdUnidad=u.Id and a.IdMarca=m.Id and (a.Nombre Like '%".$criterio."%' or a.Id=$criterio2) Order by a.Nombre)";
}else{// ver art&iacute;culo al modificar
	$query="(SELECT a.Id,a.Nombre,a.Modelo, m.Nombre as Marca,u.Abr FROM epparticulos a,unidadesmedida u,marcas m where a.Id<>0 and a.IdUnidad=u.Id and a.IdMarca=m.Id and a.Id=$articulo  Order by a.Nombre)";
}
$rs=mysql_query($query,$conn);		
//construye combo	
$combo="";
while($row=mysql_fetch_array($rs)){ 
   $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,40).' ('.substr($row['Abr'],0,5).')'.' '.substr($row['Marca'],0,15).' '.substr($row['Modelo'],0,15)."</option>\n";}
echo $combo;
mysql_free_result($rs);
?>
</select>