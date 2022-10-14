<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}
?>



<input name="TxtExCriterio2" type="text" class="TextBox" style="width:100px" maxlength="20"   tabindex="1" onKeyPress="if(event.keyCode==13){document.Formulario.CmdExBuscar2.click();}">&nbsp;<? echo GLO_FAButton('CmdExBuscar2','submit','80','self','Buscar','lupa','boton02');?> &nbsp;<select name="CbItem2"  class="campos" id="CbItem2" style="width:360px">
<? 

//permite seleccionar vacio para completar observaciones en la nota de pedido si no sabe el articulo
//permite agregar tambien productos laboratorio(items) trae los activos tipo producto(Tipo 0)

//variables
$articulo2=intval($_SESSION['CbItem2']);
$criteriop=mysql_real_escape_string($_SESSION['TxtExCriterio2']);
$criteriop2=intval($_SESSION['TxtExCriterio2']);
//query
if ($_SESSION['TxtExCriterio2']!=""){//buscar
	$query="(SELECT a.Id,a.Nombre,u.Abr FROM items a,unidadesmedida u where a.Id<>0 and a.Inactivo=0 and a.Tipo=0 and a.IdUnidad=u.Id and (a.Nombre Like '%".$criteriop."%' or a.Id=$criteriop2) Order by a.Nombre)";
}else{// ver
	$query="(SELECT a.Id,a.Nombre,u.Abr FROM items a,unidadesmedida u where a.Id<>0 and a.IdUnidad=u.Id  and a.Id=$articulo2)";
}
$rs=mysql_query($query,$conn);		
//construye combo	
$combo="";
while($row=mysql_fetch_array($rs)){ 
   $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,50).' ('.substr($row['Abr'],0,5).')'."</option>\n";}
echo $combo;
mysql_free_result($rs);
?>

<option value=""></option>
</select>