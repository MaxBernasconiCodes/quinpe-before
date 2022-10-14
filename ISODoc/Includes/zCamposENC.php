<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>
<table width="725" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="3">&nbsp;<strong>Propiedades:</strong></td><td  align="right"><? echo GLO_FAButton('CmdVersiones','submit','90','blank','Versiones','flag','boton02').' '.GLO_FAButton('CmdAuditoria','submit','90','blank','Historial','clock','boton02');?>&nbsp;</td>  </tr>

<tr><td height="18"  align="right"  >&nbsp;C&oacute;digo:</td><td  valign="top" > &nbsp; <input name="TxtCod" type="text" <? if((($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4) and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14) or ($_SESSION["TxtFR"]!=0) or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?> style="width:100px" maxlength="15"  value="<? echo $_SESSION['TxtCod']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td><td align="right"  >Id:</td><td  valign="top" > &nbsp; <input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td></tr>

<? //admin siempre cambia version (Felix Aun 202011) ?>
<tr><td height="18"  align="right"  >Versi&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtVs" type="text"  <? if((($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14)) or ($_SESSION["TxtFR"]!=0) or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3 and $_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2)){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?> style="text-align:right;width:25px" maxlength="2"  value="<? echo $_SESSION['TxtVs']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Estado:</td><td  valign="top" > &nbsp; <input name="TxtEstado" type="text"  class="TextBoxRO" <?  if ($_SESSION['TxtIdEstado']==4){ echo 'style="font-weight:bold;color:#4CAF50;width:150px"';}else{echo 'style="width:150px"';} ?> readonly="true" value="<? echo $_SESSION['TxtEstado']; ?>"> </td></tr>

<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" > &nbsp; <select name="CbTipo" class="campos" <? if(($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14)  or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'disabled style="width:200px;background:transparent;"';}else{echo'style="width:200px;"';} ?> ><? ComboTablaRFX("iso_doc_tipo","CbTipo","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td height="18"  align="right"  >Expiraci&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtFecha4" type="text"  class="TextBoxRO" style="width:70px" readonly="true" value="<? echo $_SESSION['TxtFecha4']; ?>"> 
<? 
//marcar obsoleto si tiene adjunto
if ( ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14) and $_SESSION['TxtIdEstado']!=6 and $_SESSION['TxtArchivo']!='' ){
    echo '<input name="CmdBaja" type="submit" class="boton05"  value="Baja"  onClick="document.Formulario.target='."'_self'".';return confirm('."'Dar de baja'".');">';
}
//si esta obsoleto y no hay nueva version abro como elaborado
if ( ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14) and $_SESSION['TxtIdEstado']==6 and $_SESSION['TxtFVS']==0){
    echo GLO_FAButton('CmdElaborado','submit','80','self','Abrir','','boton03');
}

?>
</td></tr>

<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" > &nbsp; <select name="CbSector" <? if(($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14) or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'disabled style="width:200px;background:transparent;"';}else{echo'style="width:200px;"';} ?> class="campos"><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td align="right"  ></td><td  valign="top" ></td></tr>
<tr><td height="18"  align="right"  >Origen:</td><td  valign="top" > &nbsp; <select name="CbOrigen" <? if(($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14) or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'disabled style="width:200px;background:transparent;"';}else{echo'style="width:200px;"';} ?> class="campos"><option value=""></option><? ComboISOOrigenDoc(); ?></select> </td><td align="right"  ></td><td  valign="top" ></td></tr>

</table> 

<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtFVS',0);GLO_Hidden('TxtFR',0);GLO_Hidden('TxtFO',0);
GLO_Hidden('TxtIdPers2',0);GLO_Hidden('TxtIdPers3',0);GLO_Hidden('TxtIdEstado',0);
?>