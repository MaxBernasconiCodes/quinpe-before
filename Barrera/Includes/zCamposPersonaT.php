<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar terceros persona
?>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Cliente:</td><td >&nbsp;<select name="CbCliente"  tabindex="3" style="width:250px" class="campos" id="CbCliente" ><option value="">Seleccione Cliente</option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td >&nbsp;<select name="CbProv"  tabindex="3" style="width:250px" class="campos" id="CbProv" ><option value="">Seleccione Proveedor</option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select></td><td align="right"  ></td><td>&nbsp;</td></tr>
</table>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td><td width="100"></td><td width="200"></td><td width="110"></td><td width="240"></td></tr>
<tr> <td height="18"  align="right"  >DNI Persona:</td><td colspan="2">&nbsp;<input name="TxtDoc" type="text"  tabindex="6" class="TextBox"  maxlength="13"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" placeholder="Buscar documento" /> 
<? 
echo GLO_formbutton('CmdBuscarCH','submit','','self','Buscar','lupa','iconbtn',6,0,0);
?></td><td align="right" title="Habilitacion Nacional de Transporte de Cargas Peligrosas" ></td><td></td></tr>
<tr> <td height="18"  align="right" > Nombre Persona:</td><td colspan="2">&nbsp;<input name="TxtChofer" type="text"  tabindex="6" class="TextBox" style="width:250px" maxlength="50"  value="<? echo $_SESSION['TxtChofer']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right" >Temperatura:</td><td>&nbsp;<input name="TxtTemp" type="text"  class="TextBox" style="width:50px;<? if (floatval($_SESSION['TxtTemp'])>=37){echo 'color:#f44336;font-weight:bold;';}?>" maxlength="5"  tabindex="6" value="<? echo $_SESSION['TxtTemp']; ?>" onChange="this.value=validarNumero(this.value);"></td><td>Olfato:&nbsp;<select name="CbOlf"  tabindex="6" style="width:50px;<? if (intval($_SESSION['CbOlf'])==2){echo 'color:#f44336;font-weight:bold;';}?>" class="campos" id="CbOlf" ><option value=""></option> <? GLO_CbSINO("CbOlf"); ?> </select></td><td align="right"></td><td></td></tr>
</table>


<?
GLO_obsform(760,110,'Observaciones','TxtObs',3,0);

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);GLO_Hidden('TxtDocCong',0);GLO_Hidden('TxtNroEntidad',0);
?>