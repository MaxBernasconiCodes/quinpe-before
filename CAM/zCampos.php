<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}





function CAM_TablaActividades($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT i.*,m.Nombre as Metodo, u.Nombre as Unidad From cam_items i,metodos m,metodosunidades u where i.IdMetodo=m.Id and i.IdUnidad=u.Id and i.IdPadre=$idpadre Order by m.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" class="TableShow TMT" id="tshow"><tr>';
$tablaclientes .="<td "."width="."470"." class="."TableShowT".' style="font-weight:bold;"'."> Metodo Pueba</td>";   
$tablaclientes .="<td "."width="."80"." class="."TableShowT".' style="font-weight:bold;"'."> Unidad</td>";   
$tablaclientes .="<td "."width="."80"." class="."TableShowT".' style="font-weight:bold;"'."> Resultados</td>";   
$tablaclientes .="<td "."width="."80"." class="."TableShowT".' style="font-weight:bold;"'."> Valor Ref.</td>";  
$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAdd','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' "; $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarItem.php?Flag1=True"."&id=".$row['Id']."'";
	if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
	else{$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td  class="."TableShowD ".$link.' style="white-space:normal;"'."> ".substr($row['Metodo'],0,200)."</td>"; 
	$tablaclientes .="<td  class="."TableShowD ".$link.' style="vertical-align:top"'." > ".substr($row['Unidad'],0,12)."</td>";
	$tablaclientes .="<td  class="."TableShowD ".$link.' style="vertical-align:top"'."> ".$row['Res']."</td>"; 
	$tablaclientes .="<td  class="."TableShowD ".$link."> ".$row['Val']."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">'; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .="</table>";echo $tablaclientes;	
}

?>



<table width="750" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="110" height="5"  ></td> <td width="350"></td><td width="100"></td> <td width="180"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td align="right"  >Vencimiento:</td><td>&nbsp;<?php  GLO_calendariovto("TxtFechaV","../Codigo/","actual",1); ?></td></tr>

<tr> <td height="18"  align="right"  >Producto:</td><td>&nbsp;<select name="CbProducto"  tabindex="1"  class="campos" id="CbProducto"  style="width:300px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option> '; ComboTablaRFX("items","CbProducto","Nombre","","and Tipo=0",$conn);}else{ComboTablaRFROX("items","CbProducto","Nombre","",$_SESSION['CbProducto'],"",$conn);} ?></select><label class="MuestraError"> * </label></td><td align="right">Estado:</td><td>&nbsp;<select name="CbEstado"  tabindex="1"  class="campos" id="CbEstado"  style="width:130px; font-weight:bold;<? echo CAM_colorestado(intval($_SESSION['CbEstado']));?>" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtIdRto'])==0 or $_SESSION['TxtIdPE1IT']==0){ComboTablaRFX("cam_est","CbEstado","Id","","",$conn);}else{ComboTablaRFROX("cam_est","CbEstado","Id","",$_SESSION['CbEstado'],"",$conn);} ?></select></td></tr>

<tr> <td height="18"  align="right"  >Cliente:</td><td >&nbsp;<select name="CbCliente"  tabindex="1"  class="campos" id="CbCliente"  style="width:300px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente","Interno,Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?></select><label class="MuestraError"> * </label></td><td align="right">Solicitud:</td><td>&nbsp;<input  name="TxtIdPadre" type="text"  readonly="true"  class="TextBoxRO TBold"   value="<? echo $_SESSION['TxtIdPadre'];?>" style="text-align:right;width:50px"> <input  name="TxtOrigen" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtOrigen'];?>" style="width:77px">&nbsp;
<?
//si tiene solicitud
if( intval($_SESSION['TxtIdPadre'])!=0 ){
	echo GLO_FAButton("CmdVerSoli",'submit','','self','Ver Solicitud','lupa','iconbtn');
}

?>
</td></tr>
</table>

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="250"></td><td width="100"></td> <td width="180"></td></tr>
<tr> <td height="18"  align="right"  >Lote:</td><td colspan="2">&nbsp;<input name="TxtLote" type="text"  class="TextBox"  maxlength="13"  value="<? echo $_SESSION['TxtLote']; ?>" tabindex="2"  style="width:100px">&nbsp;Vto.Lote:&nbsp;<?php  GLO_calendariovto("TxtFechaC","../Codigo/","actual",2); ?></td><td align="right">Realiz&oacute;:</td>  <td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  tabindex="3" style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Remito:</td><td colspan="2">&nbsp;<input name="TxtRto" type="text"  class="TextBox"  maxlength="13"  value="<? echo $_SESSION['TxtRto']; ?>" tabindex="2"  style="width:100px"></td><td align="right">Registr&oacute;:</td>  <td>&nbsp;<input name="TxtUserA" type="text"  readonly="true"  class="TextBoxRO" style="width:150px" value="<? echo $_SESSION['TxtUserA']; ?>"  ></td></tr>

<tr> <td height="18"  align="right"  >Orden Compra:</td><td colspan="2">&nbsp;<input name="TxtNroOC" type="text"  class="TextBox"  maxlength="13"  value="<? echo $_SESSION['TxtNroOC']; ?>" tabindex="2"   style="width:100px"></td><td></td><td>&nbsp;<label class="TBlue"><? echo $lblplanta; ?></label></td></tr>
</table>

<? 
if(intval($_SESSION['TxtNumero'])!=0){CAM_TablaActividades($_SESSION['TxtNumero'],$conn);}

GLO_obsform(750,110,'Equipos y Reactivos','TxtObs1',4,0);
GLO_obsform(750,110,'Observaciones','TxtObs2',4,0);

GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdRto',0);GLO_Hidden('TxtIdPE1IT',0);GLO_Hidden('TxtIdPE2IT',0);
GLO_botonesform("750",0,2);
if(intval($_SESSION['TxtNumero'])!=0){GLO_exportarform(750,0,0,1,0,0);}
GLO_mensajeerror(); 
?>	