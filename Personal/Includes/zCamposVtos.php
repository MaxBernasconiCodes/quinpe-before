<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,700,'','HABILITACIONES','salir');
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="400"></td><td width="10"></td><td width="190"></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top">&nbsp;<select name="CbTipo" style="width:300px" class="campos" id="CbTipo"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("personalvtos_tipos","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"></td><td><input name="ChkReq"  type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> Requerido</td></tr>
<tr><td height="18"  align="right"  >Emisi&oacute;n:</td><td  valign="top">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td><td align="right"></td><td><input name="ChkInactivo"   type="checkbox"  value="1" <? if ($_SESSION['ChkInactivo'] =='1') echo 'checked'; ?>>Inactivo</td></tr>
<tr><td height="18"  align="right"  >Vencimiento:</td><td  valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      >&nbsp;&nbsp;&nbsp;<?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right"  >Certificado:</td><td  valign="top" >&nbsp;
<? 
GLO_Hidden('TxtArchivo',0);
if (intval($_SESSION['TxtNumero'])!=0){echo GLO_FAButton('CmdArchivoH','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}
if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtArchivo']))){echo GLO_FAButton('CmdVerArchivoH','submit','','blank','Ver','lupa','iconbtn').' &nbsp; '.GLO_FAButton('CmdBorrarArchivoH','submit','','self','Borrar','trash','iconbtn');}
?>   
</td><td align="right"></td><td></td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(700,100,'Observaciones','TxtObs',4,0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();
?>             
