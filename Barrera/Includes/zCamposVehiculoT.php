<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar terceros vehiculo
?>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Propietario Camion:</td><td >&nbsp;<select name="CbCliente"  tabindex="3" style="width:250px" class="campos" id="CbCliente" ><option value="">Seleccione Cliente</option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"  >Remito:</td><td>&nbsp;<input name="TxtRto" type="text"  tabindex="4" class="TextBox" style="width:120px" maxlength="13"  value="<? echo $_SESSION['TxtRto']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td></tr>
<tr> <td height="18"  align="right"  >Propietario Camion:</td><td >&nbsp;<select name="CbProv"  tabindex="3" style="width:250px" class="campos" id="CbProv" ><option value="">Seleccione Proveedor</option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select></td><td align="right"  >Motivo:</td><td>&nbsp;<input name="TxtMotivo" type="text"  tabindex="4" class="TextBox" style="width:210px" maxlength="50"  value="<? echo $_SESSION['TxtMotivo']; ?>"  /></td></tr>
</table>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  ></td><td ><input name="Chk1"  type="checkbox" class="check" tabindex="5" value="1" <? if ($_SESSION['Chk1'] =='1') echo 'checked'; ?>> Certificado de analisis</td><td align="right"  ></td><td><input name="Chk2"  type="checkbox" class="check" tabindex="5" value="1" <? if ($_SESSION['Chk2'] =='1') echo 'checked'; ?>> Hojas de seguridad de los productos</td></tr>
</table>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td><td width="100"></td><td width="200"></td><td width="110"></td><td width="240"></td></tr>
<tr> <td height="18"  align="right"  >DNI Conductor:</td><td colspan="2">&nbsp;<input name="TxtDoc" type="text"  tabindex="6" class="TextBox"  maxlength="13"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" placeholder="Buscar documento" /> 
<? 
echo GLO_formbutton('CmdBuscarCH','submit','','self','Buscar','lupa','iconbtn',6,0,0);
?>
</td><td align="right" title="Habilitacion Nacional de Transporte de Cargas Peligrosas" >HNTC Peligrosas:</td><td><input name="ChkC1"  type="checkbox" class="check" tabindex="7" value="1" <? if ($_SESSION['ChkC1'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaC1","../Codigo/","actual",7); ?></td></tr>
<tr> <td height="18"  align="right" > Nombre Conductor:</td><td colspan="2">&nbsp;<input name="TxtChofer" type="text"  tabindex="6" class="TextBox" style="width:250px" maxlength="50"  value="<? echo $_SESSION['TxtChofer']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td><td align="right" title="Carnet Municipal Categoria" >Carnet Mun.Categ:</td><td><input name="ChkC2"  type="checkbox" class="check" tabindex="7" value="1" <? if ($_SESSION['ChkC2'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaC2","../Codigo/","actual",7); ?></td></tr>
<tr> <td height="18"  align="right" >SEDRONAR:</td><td colspan="2">&nbsp;<input name="TxtSedronar" type="text"  tabindex="6" class="TextBox" style="width:250px" maxlength="30"  value="<? echo $_SESSION['TxtSedronar']; ?>" ></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right" >Temperatura:</td><td>&nbsp;<input name="TxtTemp" type="text"  class="TextBox" style="width:50px;<? if (floatval($_SESSION['TxtTemp'])>=37){echo 'color:#f44336;font-weight:bold;';}?>" maxlength="5"  tabindex="6" value="<? echo $_SESSION['TxtTemp']; ?>" onChange="this.value=validarNumero(this.value);"></td><td>Olfato:&nbsp;<select name="CbOlf"  tabindex="6" style="width:50px;<? if (intval($_SESSION['CbOlf'])==2){echo 'color:#f44336;font-weight:bold;';}?>" class="campos" id="CbOlf" ><option value=""></option> <? GLO_CbSINO("CbOlf"); ?> </select></td><td align="right"></td><td></td></tr>
</table>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Dominio:</td><td >&nbsp;<input name="TxtDominio" type="text"  class="TextBox" style="width:100px;" maxlength="10"  tabindex="8"   value="<? echo $_SESSION['TxtDominio']; ?>" onKeyUp="this.value=this.value.toUpperCase()"  placeholder="Buscar dominio" /> 
<? 
echo GLO_formbutton('CmdBuscarD1','submit','','self','Buscar','lupa','iconbtn',8,0,0);
//if(empty($_SESSION['TxtDominioCong'])){echo GLO_formbutton('CmdBuscarD1','submit','','self','Buscar','lupa','iconbtn',8,0,0);} 
?>
</td><td align="right"  >Verif.Tecnica:</td><td><input name="ChkU1"  type="checkbox" class="check" tabindex="9"  value="1" <? if ($_SESSION['ChkU1'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaU1","../Codigo/","actual",9); ?></td></tr>

<tr> <td height="18"  align="right"  >Cami&oacute;n:</td><td >&nbsp;<select name="CbMarca"  tabindex="8" style="width:250px;" class="campos" id="CbMarca" ><option value=""></option> <? ComboTablaRFX("unidadesmarcas","CbMarca","Nombre","","",$conn); ?> </select></td><td align="right"  >Seguro:</td><td><input name="ChkU2"  type="checkbox" class="check"  tabindex="9" value="1" <? if ($_SESSION['ChkU2'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaU2","../Codigo/","actual",9); ?></td></tr>

<tr> <td height="18"  align="right"  >Tipo:</td><td >&nbsp;<select name="CbCateg" style="width:250px"  tabindex="8" class="campos" id="CbCateg" ><option value=""></option> <? ComboTablaRFX("unidadescateg","CbCateg","Nombre","","",$conn); ?> </select></td><td align="right"  >R.U.T.A.:</td><td><input name="ChkU3"  type="checkbox" class="check" tabindex="9"  value="1" <? if ($_SESSION['ChkU3'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaU3","../Codigo/","actual",9); ?></td></tr>

<tr> <td height="18"  align="right"  >Modelo/A&ntilde;o:</td><td >&nbsp;<input name="TxtModelo" type="text"  class="TextBox" style="width:250px" maxlength="30"  tabindex="8"  value="<? echo $_SESSION['TxtModelo']; ?>"></td><td align="right"  ></td><td></td></tr>
</table>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Dominio:</td><td >&nbsp;<input name="TxtDominio2" type="text"  class="TextBox" style="width:100px;" maxlength="10"  tabindex="10"   value="<? echo $_SESSION['TxtDominio2']; ?>" onKeyUp="this.value=this.value.toUpperCase()"  placeholder="Buscar dominio" />  
<? 
echo GLO_formbutton('CmdBuscarD2','submit','','self','Buscar','lupa','iconbtn',10,0,0);
//if(empty($_SESSION['TxtDominio2Cong'])){echo GLO_formbutton('CmdBuscarD2','submit','','self','Buscar','lupa','iconbtn',10,0,0);} 
?>
</td><td align="right"  >Verif.Tecnica:</td><td><input name="ChkS1"  type="checkbox" class="check"  tabindex="11" value="1" <? if ($_SESSION['ChkS1'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaS1","../Codigo/","actual",11); ?></td></tr>

<tr> <td height="18"  align="right"  >Semirremolque:</td><td >&nbsp;<select name="CbMarca2"  tabindex="10" style="width:250px" class="campos" id="CbMarca2" ><option value=""></option> <? ComboTablaRFX("unidadesmarcas","CbMarca2","Nombre","","",$conn); ?> </select></td><td align="right"  >Seguro:</td><td><input name="ChkS2"  type="checkbox" class="check"  tabindex="11" value="1" <? if ($_SESSION['ChkS2'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaS2","../Codigo/","actual",11); ?></td></tr>
<tr> <td height="18"  align="right"  >Tipo:</td><td >&nbsp;<select name="CbCateg2" style="width:250px"  tabindex="10" class="campos" id="CbCateg2" ><option value=""></option> <? ComboTablaRFX("unidadescateg","CbCateg2","Nombre","","",$conn); ?> </select></td><td align="right"  >R.U.T.A.:</td><td><input name="ChkS3"  type="checkbox" class="check"  tabindex="11" value="1" <? if ($_SESSION['ChkS3'] =='1') echo 'checked'; ?>> <?php  GLO_calendariovto("TxtFechaS3","../Codigo/","actual",11); ?></td></tr>

<tr> <td height="18"  align="right"  >Modelo/A&ntilde;o:</td><td >&nbsp;<input name="TxtModelo2" type="text"  class="TextBox" style="width:250px" maxlength="30"  tabindex="10"  value="<? echo $_SESSION['TxtModelo2']; ?>"></td><td align="right"  ></td><td></td></tr>
</table>
