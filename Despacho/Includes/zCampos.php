<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


$estipoplanta=DES_estipoplanta(intval($_SESSION['CbTipo']),0);
$estipobarrera=DES_estipobarrera(intval($_SESSION['CbTipo']));

//


?>

<table width="750" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="400"></td><td width="100" height="3"  ></td> <td width="150"></td> </tr>
<tr><td height="18"  align="right"  >Pedido:</td><td  valign="top" >&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td><td height="18"  align="right"  >Fecha:</td><td  valign="top" >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td></tr>

<tr> <td height="18"  align="right"  >Cliente:</td><td  valign="top">&nbsp;<select name="CbCliente" style="width:350px" class="campos" id="CbCliente" tabindex="1" <? if(intval($_SESSION['TxtNumero'])==0){echo ' onChange="this.form.submit()"><option value=""></option>';GLO_ComboActivo("clientes","CbCliente","Interno,Nombre","","",$conn);}else{ echo '>';ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?> </select><label class="MuestraError"> * </label></td></td><td align="right">Hora:</td><td>&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="1" value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);"></td></tr>


<tr> <td height="18"  align="right"  >Accion:</td><td  valign="top">&nbsp;<select name="CbTipo" style="width:180px" class="campos" id="CbTipo"  tabindex="1"> <? 
if($esdespacho==1 and intval($_SESSION['CbEstado'])<=1){//despacho pdte
    if($esdespacho==1 and intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';}
    echo ComboTablaRFX("despacho_tipo","CbTipo","Orden","","",$conn);
}else{ComboTablaRFROX("despacho_tipo","CbTipo","Orden","",$_SESSION['CbTipo'],"",$conn);} 
?> </select><label class="MuestraError"> * </label></td><td  align="right"  >Estado:</td><td>&nbsp;<input name="TxtEstado" type="text"  class="TextBoxRO" style="font-weight:bold;width:130px;<? echo $colorfield;?>" readonly="true" value="<? echo $_SESSION['TxtEstado']; ?>"></td></tr>

<? /* //sacar comentario
<tr> <td height="18"  align="right"  >Servicio:</td><td  valign="top">&nbsp;<select name="CbServicio" style="width:180px" class="campos" id="CbServicio" tabindex="1">  <? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboServicioCliente("CbServicio",$_SESSION['CbCliente'],$conn);}else{ ComboServicioRO("CbServicio",$_SESSION['CbServicio'],$conn);} ?> </select> <label class="MuestraError"> * </label>  </td></td><td align="right"></td><td>&nbsp;</td></tr>
*/?>

<tr> <td height="18"  align="right"  >Servicio:</td><td  valign="top">&nbsp;<select name="CbServicio" style="width:180px" class="campos" id="CbServicio" tabindex="1" > <? if($tieneitems==0){echo ' <option value=""></option>';ComboServicioCliente("CbServicio",$_SESSION['CbCliente'],$conn);}else{ComboServicioRO("CbServicio",$_SESSION['CbServicio'],$conn);} ?> </select> </td></td><td align="right"></td><td>&nbsp;
<?
//solo planta
if($esdespacho==3 and intval($_SESSION['TxtNumero'])!=0){
    if ($_SESSION['CbEstadoP'] =='0'){$colorp='color:#f44336;';}else{$colorp='color:#0F9D58;';}
    echo '<input name="CbEstadoP"  type="checkbox" class="check"  value="1"';if ($_SESSION['CbEstadoP'] =='1'){echo 'checked';}  
    echo '><label style="border: none;'.$colorp.'">Finalizado Planta</label>';
}
?>
</td></tr>


<tr> <td height="18"  align="right" >Solicitud:</td><td>&nbsp;<select name="TxtNroEntidad" style="width:180px" class="campos TBold" id="TxtNroEntidad"  tabindex="1"> 
<? 
//alta + modificar desde despacho sin items
if(intval($_SESSION['TxtNumero'])!=0) {
    GLO_CbComprobanteRO("procesosop","TxtNroEntidad","Id","",6,$_SESSION['TxtNroEntidad'],"",$conn);
} 
?>
 </select>&nbsp;
 <?

//si tiene solicitud 
if( intval($_SESSION['TxtNroEntidad'])!=0 and intval($_SESSION['TxtNumero'])!=0){
	echo GLO_FAButton("CmdVerSoli",'submit','','self','Ver Solicitud','lupa','iconbtn');
}


 ?> 
 </td><td height="18"  align="right"  ></td><td>&nbsp;</td></tr>
</table> 

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" > 
<tr><td width="100" height="3"  ></td> <td width="400"></td><td width="100" height="3"  ></td> <td width="150"></td> </tr>
<tr> <td height="18"  align="right"  valign="top">Recibio:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  tabindex="2" style="width:350px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select></td><td align="right"  >Medio recepcion:</td><td  valign="top">&nbsp;<select name="CbMedio" style="width:120px" class="campos" id="CbMedio"  tabindex="2"> <option value=""></option><? GLO_CbMedioRecepcion("CbMedio"); ?> </select></td></tr>
</table> 

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" > 
<tr><td width="100" height="3"  ></td> <td width="400"></td><td width="100" height="3"  ></td> <td width="150"></td> </tr>
<tr> <td height="18"  align="right"  valign="top">Comprador:</td><td>&nbsp;<input name="TxtContacto" type="text" class="TextBox" style="width:350px" maxlength="40" tabindex="2" value="<? echo $_SESSION['TxtContacto']; ?>" ></td><td align="right"  >Entrega pactada:</td><td  valign="top">&nbsp;<?php  GLO_calendario("TxtFechaB","../Codigo/","actual",3); ?></td></tr>

<tr> <td height="18"  align="right"  valign="top">Cliente final:</td><td>&nbsp;<input name="TxtCliente" type="text" class="TextBox" style="width:350px" maxlength="100" tabindex="2" value="<? echo $_SESSION['TxtCliente']; ?>" ></td><td align="right">Hora:</td><td>&nbsp;<input name="TxtHora2"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="3" value="<? echo $_SESSION['TxtHora2']; ?>" onChange="this.value=validarHora(this.value);"></td></tr>

<tr> <td height="18"  align="right"  valign="top">Remito:</td><td>&nbsp;<input name="TxtRto" type="text"  class="TextBox" tabindex="2"  maxlength="8"  value="<? echo $_SESSION['TxtRto']; ?>"  style="width:70px" onChange="this.value=validarEntero(this.value);"></td><td align="right"  ></td><td  valign="top">&nbsp;</td></tr>
</table> 


<table width="750" border="0"  cellspacing="0" class="Tabla TMT" > 
<tr> <td width="100" height="3"></td> <td width="650"></td></tr>
<tr> <td height="18"  align="right" valign="top" >Locacion:</td><td  valign="top">&nbsp;<textarea name="TxtUbic" style="width:630px" rows="3" tabindex="4" class="TextBox"  onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtUbic']; ?></textarea></td></tr>
<tr> <td height="18"  align="right" valign="top" >Observaciones:</td><td  valign="top">&nbsp;<textarea name="TxtObs" style="width:630px" rows="3" tabindex="4" class="TextBox"  onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea></td></tr>
</table> 

<? 


GLO_Hidden('TxtId',0);GLO_Hidden('CbEstado',0);

echo '<table width="750" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td height="5" width="200" ></td><td width="350"></td><td width="200"></td></tr>
<tr><td height="18"></td><td height="18"  align="center">
<input name="CmdAceptar" type="submit" class="boton" tabindex="5" value="Guardar" onClick="document.Formulario.target='."'_self'".'"></td><td height="18"  align="right">';
echo '&nbsp;</td></tr></table>'; 

if($esdespacho==1 and intval($_SESSION['TxtNumero'])!=0){
    echo '<table width="750" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td align="right">'; 
    echo ' '.GLO_FAButton('CmdImprimir','submit','80','blank','Logistica','print','boton02');
    echo ' '.GLO_FAButton('CmdImprimirB','submit','80','blank','Barrera','print','boton02');
    echo '</td> </tr></table>'; 
}

GLO_mensajeerror();



?>