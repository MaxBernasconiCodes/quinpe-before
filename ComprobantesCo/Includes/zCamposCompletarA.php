<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['IdItem'],0,0);
if($paginaretorno!='zCompletarArticuloC'){GLO_ValidaGET($_GET['Id'],0,0);}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad']=intval($_GET['Id']);//oc
$_SESSION['TxtNumero']=intval($_GET['IdItem']);//item nota pedido

//trae obs del item
$idarticuloitem=0;$idarticuloitem2=0;$asococ='';
$query="SELECT c.Obs,c.IdArticulo,c.IdItem,c.INC,c.NroOC From co_npedido_it c Where c.Id=".intval($_GET['IdItem']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$idarticuloitem=$row['IdArticulo'];$idarticuloitem2=$row['IdItem'];
	$_SESSION['TxtObs'] =$row['Obs'];$finc=$row['INC'];$asococ=$row['NroOC'];
}mysql_free_result($rs);	

/*
//liliana medina solicita poder modificar todos
//solo creadas incompletas
if($finc==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
*/

//valida que no esta en ninguna cotizacion
$asocpc='';
$query="SELECT distinct i.IdPCotiz From co_pcotiz_it i Where i.IdItemNP=".intval($_GET['IdItem']);
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$asocpc=GLO_ListaTexto($asocpc,$row['IdPCotiz']);
}mysql_free_result($rs);
//muestra en mensaje error si alguna esta asociada
if($asocpc!=''){$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].' Asociado a PC '.$asocpc;}

//valida que no esta en ninguna oc
if($asococ!='0' and $asococ!=''){$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].' Asociado a OC '.$asococ;}

GLO_InitHTML($_SESSION["NivelArbol"],'TxtExCriterio','BannerPopUpMH',$paginaretorno,0,0,0,0); 
GLO_tituloypath(0,720,'compras','COMPLETAR ARTICULO','salir');
?>

<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >Art&iacute;culo o Equipo:</td><td >&nbsp;<? if(intval($_SESSION['TxtIdEstado'])<2){ echo '<input name="TxtExCriterio" type="text" class="TextBox" tabindex="4"   style="width:100px" maxlength="20" onKeyPress="if(event.keyCode==13){document.Formulario.CmdExBuscar.click();}"> '.GLO_FAButton('CmdExBuscar','submit','80','self','Buscar','lupa','boton02').'&nbsp';} ?><select name="CbItem"  class="campos" id="CbItem" style="width:360px" tabindex="4"  >
 <? //articulo
$criterio=mysql_real_escape_string($_SESSION['TxtExCriterio']);
$articulo=intval($_SESSION['CbItem']);
if ($_SESSION['TxtExCriterio']!=""){
	$criterio2=intval($_SESSION['TxtExCriterio']);
	$query="(SELECT a.Id,a.Nombre,a.Modelo, m.Nombre as Marca,u.Abr FROM epparticulos a,unidadesmedida u,marcas m where a.Id<>0 and a.IdUnidad=u.Id and a.IdMarca=m.Id and (a.Nombre Like '%".$criterio."%' or a.Id=$criterio2) Order by a.Nombre)";
}else{
	$query="(SELECT a.Id,a.Nombre,a.Modelo, m.Nombre as Marca,u.Abr FROM epparticulos a,unidadesmedida u,marcas m where a.Id<>0 and a.IdUnidad=u.Id and a.IdMarca=m.Id and a.Id=$articulo  Order by a.Nombre)";
}
$rs=mysql_query($query,$conn);		
$combo="";
while($row=mysql_fetch_array($rs)){ 
   $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,40).' ('.substr($row['Abr'],0,5).')'.' '.substr($row['Marca'],0,15).' '.substr($row['Modelo'],0,15)."</option>\n";
}mysql_free_result($rs);
echo $combo;
?>
</select></td></tr>
<tr> <td ></td><td height="5" ></td></tr>
<tr> <td height="18"  align="right"  >Producto Laboratorio:</td><td >&nbsp;<? if(intval($_SESSION['TxtIdEstado'])<2){ echo '<input name="TxtExCriterio2" type="text" class="TextBox" tabindex="4"   style="width:100px" maxlength="20" onKeyPress="if(event.keyCode==13){document.Formulario.CmdExBuscar2.click();}"> '.GLO_FAButton('CmdExBuscar2','submit','80','self','Buscar','lupa','boton02').'&nbsp';} ?><select name="CbItem2"  class="campos" id="CbItem2" style="width:360px" tabindex="4"  >
 <? //producto
$articulo2=intval($_SESSION['CbItem2']);
$criteriop=mysql_real_escape_string($_SESSION['TxtExCriterio2']);
if ($_SESSION['TxtExCriterio2']!=""){
	$criteriop2=intval($_SESSION['TxtExCriterio2']);
	$query="(SELECT a.Id,a.Nombre,u.Abr FROM items a,unidadesmedida u where a.Id<>0 and a.Inactivo=0 and a.Tipo=0 and a.IdUnidad=u.Id and (a.Nombre Like '%".$criteriop."%' or a.Id=$criteriop2) Order by a.Nombre)";
}else{
	$query="(SELECT a.Id,a.Nombre,u.Abr FROM items a,unidadesmedida u where a.Id<>0 and a.IdUnidad=u.Id and a.Id=$articulo2)";
}
$rs=mysql_query($query,$conn);		
$combo="";
while($row=mysql_fetch_array($rs)){ 
   $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,50).' ('.substr($row['Abr'],0,5).')'."</option>\n";
}mysql_free_result($rs);
echo $combo;
?>
</select></td></tr>
</table> 

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Observaciones:</td><td>&nbsp;<input name="TxtObs" type="text"  class="TextBoxRO" style="width:545px" readonly="true" value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table> 


<?
//graba si no esta asociado a ninguna pc ni oc
if($asocpc=='' and ($asococ=='0' or $asococ=='') ){GLO_botonesform("720",0,2);}//muestra grabar
else{GLO_botonesform("720",1,2);}//oculta grabar
?>

<table width="720" border="0"  cellpadding="0" cellspacing="0" class="TMT">
<tr><td align="right"><input name="CmdAddArt" type="submit" class="boton02" value="Crear Art&iacute;culo" style=" width:90px" onClick="document.Formulario.target='_blank';document.forms['Formulario']['TxtExCriterio'].focus()"></td> </tr>
</table>


<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(720,0);
echo 'Podr&aacute; buscar el <font class="comentario2">Art&iacute;culo</font> por <font class="comentario3">C&oacute;digo</font> o <font class="comentario3">Nombre</font><br>';
echo 'Si el <font class="comentario3">Art&iacute;culo</font> no existe, puede agregarlo con el boton <font class="comentario2">Crear Art&iacute;culo</font><br>';
echo 'Solo puede modificar el <font class="comentario3">Art&iacute;culo</font> si no esta asociado a ninguna <font class="comentario2">Cotizaci&oacute;n</font>, y a ninguna <font class="comentario2">Orden</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>