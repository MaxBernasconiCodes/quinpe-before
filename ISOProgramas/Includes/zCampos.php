<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,750,'Consulta.php','PROGRAMA ANUAL','linksalir');
GLO_mensajeerrorE();
?>
<table width="760" border="0"   cellspacing="0"  class="Tabla">
<tr><td width="50" height="3" ><td width="40" ></td><td width="80" ></td><td width="50" ></td><td width="120" ></td><td width="50" ></td><td width="160" ></td><td width="80" ></td><td width="130" ></td></tr>
<tr><td>&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"  value="<? echo $_SESSION['TxtNumero'];?>" style="width:40px;text-align:right;"></td> <td  align="right" height="18">A&ntilde;o:</td><td>&nbsp;<input name="TxtFecha" type="text"  tabindex="1"  class="TextBox" style="width:50px" maxlength="4"  value="<? echo $_SESSION['TxtFecha']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td align="right">Sector:</td><td>&nbsp;<select name="CbSector"  tabindex="1" style="width:100px;" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipo"  tabindex="1" style="width:130px;" class="campos" id="CbTipo" > <? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboTablaRFX("programas_tipo","CbTipo","Nombre","","",$conn);}else{ComboTablaRFROX("programas_tipo","CbTipo","Nombre","",intval($_SESSION['CbTipo']),"",$conn);} ?> </select><label class="MuestraError"> * </label></td> <td  align="right">Programar:</td><td>&nbsp;<select name="CbTipoE"  tabindex="1" style="width:98px;" class="campos" id="CbTipoE" > <? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboTablaRFX("programas_ent","CbTipoE","Nombre","","",$conn);}else{ComboTablaRFROX("programas_ent","CbTipoE","Nombre","",intval($_SESSION['CbTipoE']),"",$conn);} ?> </select><label class="MuestraError"> * </label>
</td></tr>
</table>


<table width="760" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td width="90" height="3" ></td><td width="670" ></td></tr>
<tr> <td  align="right" height="18">Nombre:</td><td>&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="1"  style="width:638px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" /> <label class="MuestraError"> * </label></td></tr>
<tr> <td  align="right" height="18" valign="top">Observaciones:</td><td>&nbsp;<textarea name="TxtObs" style="width:638px" rows="1" class="TextBox" onkeypress="event.cancelBubble=true;" tabindex="1" ><? echo $_SESSION['TxtObs']; ?></textarea></td></tr>
<tr> <td  align="right" height="18">Referencia:</td><td>&nbsp;<select name="CbTipoR"  tabindex="1" style="width:80px;" class="campos" id="CbTipoR" > <option value=""></option> <? ComboTablaRFX("iso_tiporef","CbTipoR","Nombre","","",$conn);?> </select>&nbsp;<input name="TxtRef" type="text" class="TextBoxRO" readonly="true"  style="width:555px"   value="<? echo $_SESSION['TxtRef']; ?>" /></td></tr>
</table>

<table width="760" border="0"   cellspacing="0"  class="Tabla TMT">
<tr><td width="90" height="3" ></td><td width="170" ><td width="80"></td><td width="170" ></td><td width="80" height="3" ></td><td width="170" ></td></tr>
<tr> <td  align="right" height="18">Detalle 1:</td><td>&nbsp;<input name="TxtNombre1" type="text" class="TextBox"   tabindex="1"  style="width:150px" maxlength="30"  value="<? echo $_SESSION['TxtNombre1']; ?>" /></td><td  align="right">Detalle 2:</td><td>&nbsp;<input name="TxtNombre2" type="text" class="TextBox"   tabindex="1"  style="width:150px" maxlength="30"  value="<? echo $_SESSION['TxtNombre2']; ?>" /></td><td  align="right">Responsable:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:140px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select></td></tr>
</table>

<?

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);

if(intval($_SESSION['TxtNumero'])!=0){//modificar
	GLO_mensajeerror();
	PL_TablaTareas(intval($_SESSION['TxtNumero']),intval($_SESSION['CbTipo']),intval($_SESSION['CbTipoE']),intval($_SESSION['TxtFecha']),$conn);
	GLO_botonesform(1270,0,2); 
	//GLO_exportarform(1270,1,0,0,0,0);
}else{//alta
	GLO_botonesform(760,0,2); 
}


?>