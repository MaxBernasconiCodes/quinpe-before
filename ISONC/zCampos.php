<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_mensajeerrorE();

$estilotitulo='style="font-size:10px;font-weight:bold;color:#FFFFFF;background-color:#7d97a5; text-align:center"';
?>


<style type="text/css">
        .error {
            color: red;
            display: none;
        }
</style>
    <script type="text/javascript">
        function Validate() {
            var name = document.getElementsByClassName("TextBox");
            var error = document.getElementsByClassName("error");
            error[0].style.display = name[0].value == "" ? "block" : "none";
            name[0].style.border = name[0].value == "" ? "1px solid red" : "";
            name[0].focus();
        }
    </script>


<table width="850" border="0"   cellspacing="0"  class="Tabla">
<tr > <td  colspan="6" <? echo $estilotitulo; ?>   >PROVENIENTE DE</td></tr>
<tr><td width="100" height="1" ></td><td width="270"  ></td><td width="70"  ></td><td width="250"  ></td><td width="130" ></td><td width="30" ></td></tr>
<tr> <td  align="right" height="18" >N&uacute;mero:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td  align="right">Cliente:</td><td >&nbsp;<select name="CbCliente" style="width:200px" class="campos" id="CbCliente"  tabindex="2" ><option value=""></option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select></td><td ><input  name="TxtEstado" type="text"  readonly="true"  class="TextBoxRO"  style="width:100px"   value="<? echo $_SESSION['TxtEstado'];?>" ></td><td  align="right"><? if($_SESSION['TxtIdCumpl']==3 and $_SESSION['TxtIdEstado']==3){echo '<i class="fa fa-award iconsmallsp iconlgray"></i>';} ?>&nbsp;</td></tr>
<tr> <td align="right" height="18">Origen:</td><td >&nbsp;<select name="CbTipo"  tabindex="1" style="width:250px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("iso_nc_tipo","CbTipo","Nombre","","",$conn); ?> </select></td><td align="right">Tipo:</td><td >&nbsp;<select name="CbTipoH" style="width:200px" class="campos" id="CbTipoH"  tabindex="2" ><option value=""></option> <? ComboTablaRFX("iso_nc_tipo2","CbTipoH","Nombre","","",$conn); ?>  </select></td><td ><input  name="TxtCumpl" type="text"  readonly="true"  class="TextBox2"    value="<? echo $_SESSION['TxtCumpl'];?>" style="font-weight:bold; width:100px;<? if($_SESSION['TxtIdCumpl']==2 and $_SESSION['TxtIdEstado']==1){echo 'color:#f44336;';} ?>"></td><td ></td></tr>
</table>





<table width="850" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td colspan="5" <? echo $estilotitulo; ?> >DETALLE DE LA NO CONFORMIDAD</td></tr>
<tr><td width="100" height="1" ></td><td width="150"  ></td><td width="100" ></td><td width="250" ></td><td width="250" ></td></tr>
<tr> <td align="right" height="18">Normas:</td><td >&nbsp;<select name="CbNorma1" style="width:130px"  tabindex="3" class="campos" id="CbNorma1" ><option value=""></option> <? GLO_ComboActivo("iso_nc_norma","CbNorma1","Nombre","","",$conn); ?> </select></td><td align="right">Requisitos:</td><td >&nbsp;<select name="CbReq1" style="width:230px" class="campos" id="CbReq1"  tabindex="4" ><option value=""></option> <? ComboISOReqRFX("CbReq1",$conn); ?> </select></td><td><select name="CbReq4" style="width:230px" class="campos" id="CbReq4"  tabindex="5" ><option value=""></option> <? ComboISOReqRFX("CbReq4",$conn); ?> </select></td></tr>
<tr> <td align="right" height="18"></td><td  >&nbsp;<select name="CbNorma2" style="width:130px" tabindex="3"  class="campos" id="CbNorma2" ><option value=""></option> <? GLO_ComboActivo("iso_nc_norma","CbNorma2","Nombre","","",$conn); ?> </select></td><td align="right"></td><td >&nbsp;<select name="CbReq2" style="width:230px" class="campos" id="CbReq2"  tabindex="4" ><option value=""></option> <? ComboISOReqRFX("CbReq2",$conn); ?> </select></td><td><select name="CbReq5" style="width:230px" class="campos" id="CbReq5" tabindex="5"  ><option value=""></option> <? ComboISOReqRFX("CbReq5",$conn); ?> </select></td></tr>
<tr> <td align="right" height="18"></td><td  >&nbsp;<select name="CbNorma3" style="width:130px" class="campos" id="CbNorma3"  tabindex="3" ><option value=""></option> <? GLO_ComboActivo("iso_nc_norma","CbNorma3","Nombre","","",$conn); ?> </select></td><td align="right"></td><td >&nbsp;<select name="CbReq3" style="width:230px" class="campos" id="CbReq3"  tabindex="4" ><option value=""></option> <? ComboISOReqRFX("CbReq3",$conn); ?> </select></td><td><select name="CbReq6" style="width:230px" class="campos" id="CbReq6"  tabindex="5" ><option value=""></option> <? ComboISOReqRFX("CbReq6",$conn); ?> </select></td></tr>
<tr> <td align="right" height="18" valign="top">Descripci&oacute;n:</td><td  colspan="4">&nbsp;<textarea name="TxtDescripcion" style="width:715px" rows="2" class="TextBox" onkeypress="event.cancelBubble=true;" tabindex="6" ><? echo $_SESSION['TxtDescripcion']; ?></textarea></td><td></td></tr>
<tr> <td align="right" height="18">Fecha:</td><td >&nbsp;<input name="TxtFecha" id="TxtFecha"  type="text" class="TextBox"  tabindex="6"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFecha","../Codigo/","actual") ?></td><td align="right">Resp.Deteccion:<td>&nbsp;<select name="CbRespDet" class="campos" id="CbRespDet"  style="width:230px" onKeyDown="enterxtab(event)" tabindex="6" ><option value=""></option><? ComboPersonalRFX('CbRespDet',$conn); ?></select></td><td><input name="TxtRespDet" type="text"  class="TextBox" tabindex="6"  style="width:230px" maxlength="30"  value="<? echo $_SESSION['TxtRespDet']; ?>"></td></tr>
<tr> <td align="right" height="18">Sectores:</td><td colspan="5">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:175px" onKeyDown="enterxtab(event)" tabindex="6" ><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> &nbsp; <select name="CbSector2" class="campos" id="CbSector2"  style="width:175px" onKeyDown="enterxtab(event)" tabindex="6" ><option value=""></option><? ComboTablaRFX("sector","CbSector2","Nombre","","",$conn); ?></select> &nbsp; <select name="CbSector3" class="campos" id="CbSector3"  style="width:170px" onKeyDown="enterxtab(event)" tabindex="6" ><option value=""></option><? ComboTablaRFX("sector","CbSector3","Nombre","","",$conn); ?></select> &nbsp; <select name="CbSector4" class="campos" id="CbSector4"  style="width:170px" onKeyDown="enterxtab(event)" tabindex="6" ><option value=""></option><? ComboTablaRFX("sector","CbSector4","Nombre","","",$conn); ?></select></td><td></td></tr>
</table>



<table width="850" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td colspan="2" <? echo $estilotitulo; ?> >ANALISIS DE CAUSA (C&oacute;mo o por qu&eacute; pas&oacute;?)</td></tr>
<tr><td width="100" height="1" ></td><td width="750"  ></td></tr>
<tr> <td align="right" height="18" valign="top">Causa:</td><td  >&nbsp;<textarea name="TxtCausa" style="width:715px" rows="2" class="TextBox" onkeypress="event.cancelBubble=true;" tabindex="7" ><? echo $_SESSION['TxtCausa']; ?></textarea></td></tr>
<tr> <td align="right" height="18">Participantes:</td><td>&nbsp;<select name="CbPartCausa1" class="campos" id="CbPartCausa1"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa1',$conn); ?></select>&nbsp;<select name="CbPartCausa2" class="campos" id="CbPartCausa2"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa2',$conn); ?></select>&nbsp;<select name="CbPartCausa3" class="campos" id="CbPartCausa3"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa3',$conn); ?></select>&nbsp;<select name="CbPartCausa4" class="campos" id="CbPartCausa4"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa4',$conn); ?></select>&nbsp;<select name="CbPartCausa5" class="campos" id="CbPartCausa5"  style="width:120px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa5',$conn); ?></select>&nbsp;<select name="CbPartCausa6" class="campos" id="CbPartCausa6"  style="width:120px" onKeyDown="enterxtab(event)" tabindex="7" ><option value=""></option><? ComboPersonalRFX('CbPartCausa6',$conn); ?></select></td></tr>
<tr> <td align="right" height="18">Otros Part.:</td><td>&nbsp;<input name="TxtOtrosP" type="text"  class="TextBox" tabindex="7"  style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtOtrosP']; ?>"></td></tr>
<tr> <td align="right" height="18">Mail Otros:</td><td >&nbsp;<input name="TxtOtrosPM" type="text"  class="TextBox"  tabindex="7" style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtOtrosPM']; ?>" title="Separar con comas"></td></tr>
</table>




<table width="850" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td colspan="4" <? echo $estilotitulo; ?> >ACCION INMEDIATA</td></tr>
<tr><td width="100" height="1" ></td><td width="150"  ></td><td width="100" ></td><td width="500" ></td></tr>
<tr> <td align="right" height="18" valign="top">Descripci&oacute;n:</td><td  colspan="3">&nbsp;<input name="TxtDesAI" type="text"  class="TextBox" tabindex="8"  style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtDesAI']; ?>"></td></tr>
<tr> <td align="right" height="18">Fecha:</td><td >&nbsp;<input name="TxtFechaAI" id="TxtFechaAI"  tabindex="8"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaAI']; ?>"   >
<? calendario("TxtFechaAI","../Codigo/","actual") ?></td><td align="right">Responsable:</td><td>&nbsp;<select name="CbPartAI"  tabindex="8" class="campos" id="CbPartAI"  style="width:230px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPartAI',$conn); ?></select></td></tr>
</table>




<table width="850" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td colspan="4" <? echo $estilotitulo; ?> >ACCION CORRECTIVA</td></tr>
<tr><td width="100" height="1" ></td><td width="150"  ></td><td width="100" ></td><td width="500" ></td></tr>
<tr> <td align="right" height="18" valign="top">Descripci&oacute;n:</td><td  colspan="3">&nbsp;<textarea name="TxtAccion" style="width:715px" rows="2" tabindex="8"  class="TextBox" onkeypress="event.cancelBubble=true;"><? echo $_SESSION['TxtAccion']; ?></textarea></td></tr>
<tr> <td align="right" height="18">Responsables:</td><td colspan="3">&nbsp;<select name="CbRespAccion1" class="campos" id="CbRespAccion1"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="8" ><option value=""></option><? ComboPersonalRFX('CbRespAccion1',$conn); ?></select><label class="MuestraError"> * </label><select name="CbRespAccion2" class="campos" id="CbRespAccion2"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="8" ><option value=""></option><? ComboPersonalRFX('CbRespAccion2',$conn); ?></select>&nbsp;<select name="CbRespAccion3" class="campos" id="CbRespAccion3"  tabindex="8"  style="width:115px" onkeydown="enterxtab(event)"> <option value=""></option> <? ComboPersonalRFX('CbRespAccion3',$conn); ?></select>&nbsp;<select name="CbRespAccion4" class="campos" id="CbRespAccion4"  style="width:115px" onKeyDown="enterxtab(event)" tabindex="8" ><option value=""></option><? ComboPersonalRFX('CbRespAccion4',$conn); ?></select> <select name="CbRespAccion5" class="campos" id="CbRespAccion5"  style="width:120px" onKeyDown="enterxtab(event)" tabindex="8" ><option value=""></option><? ComboPersonalRFX('CbRespAccion5',$conn); ?></select>&nbsp;<select name="CbRespAccion6" class="campos" id="CbRespAccion6"  style="width:120px" onKeyDown="enterxtab(event)" tabindex="8" ><option value=""></option><? ComboPersonalRFX('CbRespAccion6',$conn); ?></select></td></tr>
<tr> <td align="right" height="18">Otros Resp.:</td><td colspan="3">&nbsp;<input name="TxtOtrosR" type="text"  tabindex="8"  class="TextBox" style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtOtrosR']; ?>"></td></tr>
<tr> <td align="right" height="18">Mail Otros:</td><td colspan="3">&nbsp;<input name="TxtOtrosRM" type="text" tabindex="8"   class="TextBox" style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtOtrosRM']; ?>" title="Separar con comas"></td></tr>
<tr> <td align="right" height="18">Plazo:</td><td>&nbsp;<input name="TxtFPlazo" id="TxtFPlazo"  type="text"  tabindex="8" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFPlazo']; ?>"   ><? calendario("TxtFPlazo","../Codigo/","actual") ?></td><td align="right">Cumplimiento:</td><td >&nbsp;<input name="TxtFCumpl" id="TxtFCumpl"  type="text" class="TextBox"  style="width:65px" maxlength="10"  tabindex="8"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFCumpl']; ?>"   >
<? calendario("TxtFCumpl","../Codigo/","actual") ?></td></tr>
</table>




<table width="850" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td colspan="6" <? echo $estilotitulo; ?> >VERIFICACION DE LA EFICACIA</td></tr>
<tr><td width="100" height="1" ></td><td width="170"></td><td width="100" ></td><td width="160"></td><td width="160"></td><td width="160" ></td></tr>
<tr> <td align="right" height="18">Verificador:</td><td>&nbsp;<select name="CbVerif" style="width:150px"  tabindex="8" class="campos" id="CbVerif" ><option value=""></option> <? ComboTablaRFX("iso_nc_verif","CbVerif","Nombre","","",$conn); ?> </select></td><td ><input name="ChkAceptada"  type="checkbox"  tabindex="8"  value="1" <? if ($_SESSION['ChkAceptada'] =='1') echo 'checked'; ?>>Aceptada</td><td>Prevista:&nbsp;<? GLO_calendario("TxtFPrevista","../Codigo/","actual",8) ?></td><td>Cierre:&nbsp;<? GLO_calendario("TxtFCierre","../Codigo/","actual",8) ?></td><td>Nueva NC:&nbsp;<select name="CbNuevaNC" style="width:75px" class="campos" id="CbNuevaNC" tabindex="8"  ><option value=""></option> <? ComboISO_Nueva($conn); ?> </select></td></tr>
<tr> <td align="right" height="18" valign="top">Observaciones:</td><td colspan="6">&nbsp;<input name="TxtObsVerif" type="text"  class="TextBox" tabindex="8"  style="width:715px" maxlength="200"  value="<? echo $_SESSION['TxtObsVerif']; ?>"></td></tr>
</table>


<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdEstado',0);GLO_Hidden('TxtIdCumpl',0);
GLO_Hidden('TxtPuedeModificar',0);
?>