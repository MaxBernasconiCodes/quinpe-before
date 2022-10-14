<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>

<table width="750" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80" height="1"  ></td> <td width="100"></td> <td width="70"></td><td width="150"></td><td width="70" height="3"  ></td> <td width="280"></td> </tr>
<tr> <td height="18"  align="right"  >Unidad</td><td  valign="top" colspan="2">&nbsp;<input  name="TxtPRUnidad" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPRUnidad'];?>" style="width:70px"></td><td  valign="top"></td><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<input  name="TxtEstadoA" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtEstadoA'];?>" style="width:230px"></td></tr>
<tr><td height="18"  align="right"  >Clase:</td><td  valign="top" colspan="3">&nbsp;<select name="CbClase" tabindex="1"  style="width:150px" class="campos" id="CbClase" ><option value=""></option> <? ComboTablaRFX("pedidosrepreq_clase","CbClase","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Categor&iacute;a:</td><td  valign="top" >&nbsp;<select name="CbCat" tabindex="2"  style="width:230px" class="campos" id="CbCat" ><option value=""></option> <? ComboTablaRFX("pedidosrepreq_cat","CbCat","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr>  <td height="18"  align="right"  >Tipo:</td><td  valign="top" colspan="3">&nbsp;<select name="CbTipo" tabindex="1"  style="width:150px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("pedidosrepreq_tipo","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Urgencia:</td><td  valign="top" >&nbsp;<select name="CbUrg" tabindex="2"  style="width:100px" class="campos" id="CbUrg" > <? ComboPRQUrg("CbUrg",$conn); ?> </select></td></tr>
<tr> <td height="18"  align="right" >Descripci&oacute;n:</td><td  valign="top"  colspan="5">&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:620px" maxlength="100"  tabindex="3"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>


<table width="750" border="0" cellspacing="0" class="Tabla TMT" >
<tr><td width="80" height="1"  ></td> <td width="100"></td> <td width="70"></td><td width="150"></td><td width="70" height="3"  ></td> <td width="280"></td> </tr>
<tr> <td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkExt"  type="checkbox" tabindex="3" value="1" <? if ($_SESSION['ChkExt'] =='1') echo 'checked'; ?>>Externo</td><td align="right"  >Turno:</td><td  valign="top">&nbsp;<input name="TxtFecha1" id="TxtFecha1"  tabindex="3"  type="text" class="TextBox"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha1']; ?>"   > <? calendario("TxtFecha1","../Codigo/","actual") ?></td><td height="18"  align="right"  >Proveedor:</td><td  valign="top" >&nbsp;<select name="CbProv" style="width:230px" class="campos" id="CbProv" tabindex="3"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td></tr>
</table>



<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="80" height="1"  ></td> <td width="670"></td> </tr>
<tr> <td height="18"  align="right"  >Ingreso:</td><td  valign="top" >&nbsp;<input  name="TxtPRFechaI" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPRFechaI'];?>" style="width:70px">&nbsp;&nbsp;&nbsp;Km:&nbsp;<input  name="TxtPRKm" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPRKm'];?>" style="text-align:right;width:50px">&nbsp;&nbsp;&nbsp;Hs:&nbsp;<input  name="TxtPRHs" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPRHs'];?>" style="text-align:right;width:50px"></td></tr>
</table>

<?
REP_TablaReqSoli($_SESSION['TxtNroEntidad'],$conn); //idorden 
//si esta retirada o finalizada no puede modificar planilla
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
    GLO_botonesform("750",0,2);
}

//hidden
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdEstadoA',0);GLO_Hidden('TxtIdEstadoO',0);
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtPRIdUnidad',0);GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror(); 
?>			




