<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,730,'','PRODUCTO '.$nometapa,'salir');
?>

<table width="730" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="300"></td><td width="100"></td><td width="230"></td></tr>
<tr><td height="18"  align="right"  >Cliente Solicitud:</td><td  valign="top" >&nbsp;<select name="CbCliente"  class="campos" id="CbCliente"  style="width:270px" onKeyDown="enterxtab(event)"><? ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn); ?></select></td><td align="right">Rto.Barrera:</td><td>&nbsp;<input name="TxtRto" type="text"   readonly="true"  class="TextBoxRO" style="width:120px"  value="<? echo $_SESSION['TxtRto']; ?>"  /></td></tr>
<tr><td height="18"  align="right"  >Producto:</td><td  valign="top" >&nbsp;<select name="CbItem" style="width:270px"   class="campos" tabindex="1" id="CbItem" ><? if( intval($_SESSION['TxtNumero'])==0 ){echo '<option value=""></option>';ComboTablaRFX("items","CbItem","Nombre","","and Tipo=0",$conn);}else{ ComboTablaRFROX("items","CbItem","Nombre","",$_SESSION['CbItem'],"",$conn);} ?></select><label class="MuestraError"> * </label></td><td align="right">Etapa:</td><td>&nbsp;<select name="CbEtapa" class="campos TBold <? if(intval($_SESSION['CbEtapa'])==1){echo 'TBlue';}else{echo 'TGreen';} ?>" id="CbEtapa"  style="width:80px;"  onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',1);?></select> <? echo $retorno;?></td></tr>
</table>

<table width="730" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="300"></td><td width="100"></td><td width="230"></td></tr>
<tr><td height="18"  align="right"  >Cantidad:</td><td  valign="top" >&nbsp;<input name="TxtRes" type="text"  class="TextBox"  maxlength="14"  value="<? echo $_SESSION['TxtRes']; ?>" tabindex="1"  style="width:70px" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label></td><td align="right">Ingres&oacute; a Planta:</td><td>&nbsp;<input name="TxtCant" type="text"  readonly="true"  class="TextBoxRO"  value="<? echo $_SESSION['TxtCant']; ?>" style="width:70px" ></td></tr>

<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad"  tabindex="1"  class="campos" id="CbUnidad"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("unidadesmedida","CbUnidad","Nombre","","",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">Bultos:</td><td>&nbsp;<input name="TxtBultos" type="text"  class="TextBox"  maxlength="5"  value="<? echo $_SESSION['TxtBultos']; ?>" tabindex="2"  style="width:50px" onChange="this.value=validarEntero(this.value);" ></td></tr>

<tr><td height="18"  align="right"  >Envase:</td><td  valign="top" >&nbsp;<select name="CbEnv"  tabindex="1"  class="campos" id="CbEnv"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("envases","CbEnv","Nombre","","",$conn); ?></select></td><td align="right">Destino:</td><td>&nbsp;<input name="TxtObs" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtObs']; ?>" tabindex="2"  style="width:200px"></td></tr>

<tr><td height="18"  align="right"  >Lote:</td><td  valign="top" >&nbsp;<input name="TxtVal" type="text"  class="TextBox"  maxlength="10"  value="<? echo $_SESSION['TxtVal']; ?>" tabindex="1"  style="width:150px"></td><td align="right"></td><td></td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('ChkRE',0);
?>