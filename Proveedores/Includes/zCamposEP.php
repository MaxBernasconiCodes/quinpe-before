<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,900,'','EVALUACION '.$_SESSION['TxtApellido'],'salir');
?>



<table width="900" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80" height="3"  ></td>  <td width="120"></td><td width="110"></td><td width="240"></td><td width="110"></td><td width="240"></td></tr>
<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox" tabindex="1" style="width:65px;" maxlength="10"  onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td><td align="right">Resp.Compras:</td><td>&nbsp;<select name="CbPersonal1" class="campos" tabindex="1" id="CbPersonal1"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal1',$conn); ?></select></td><td align="right">Ref.Receptor:</td><td>&nbsp;<select name="CbPersonal2" class="campos" tabindex="1" id="CbPersonal2"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal2',$conn); ?></select></td></tr>
</table>


<table width="900" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="450" height="3"  ></td>  <td width="90"></td><td width="10"></td><td width="350"></td></tr>
<tr><td height="18"  >&nbsp; Experiencia previa</td><td >&nbsp;<select name="CbEP1" style="width:35px"   class="campos" tabindex="2" id="CbEP1" ><option value=""></option> <? PROV_CbEP1("CbEP1",1); ?> </select></td><td></td><td><input name="TxtI1" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI1']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Plazos de entrega</td><td>&nbsp;<select name="CbEP2"  style="width:35px" class="campos" tabindex="2" id="CbEP2" ><option value=""></option> <? PROV_CbEP1("CbEP2",2); ?> </select></td><td></td><td><input name="TxtI2" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI2']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Precio</td><td>&nbsp;<select name="CbEP3"  style="width:35px" class="campos" tabindex="2" id="CbEP3" ><option value=""></option> <? PROV_CbEP1("CbEP3",3); ?> </select></td><td></td><td><input name="TxtI3" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI3']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Condiciones de pago</td><td>&nbsp;<select name="CbEP4"  style="width:35px" class="campos" tabindex="2" id="CbEP4" ><option value=""></option> <? PROV_CbEP1("CbEP4",4); ?> </select></td><td></td><td><input name="TxtI4" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI4']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Documentacion legal e impositiva</td><td>&nbsp;<select name="CbEP5"  style="width:35px" class="campos" tabindex="2" id="CbEP5" ><option value=""></option> <? PROV_CbEP1("CbEP5",5); ?> </select></td><td></td><td><input name="TxtI5" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI5']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Respuesta a solicitudes post servicio</td><td>&nbsp;<select name="CbEP6"  style="width:35px" class="campos" tabindex="2" id="CbEP6" ><option value=""></option> <? PROV_CbEP1("CbEP6",6); ?> </select></td><td></td><td><input name="TxtI6" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI6']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Asesoria puntual a consultas</td><td>&nbsp;<select name="CbEP7"  style="width:35px" class="campos" tabindex="2" id="CbEP7" ><option value=""></option> <? PROV_CbEP1("CbEP7",7); ?> </select></td><td></td><td><input name="TxtI7" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI7']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Atencion personalizada/comunicacion</td><td>&nbsp;<select name="CbEP8"  style="width:35px" class="campos" tabindex="2" id="CbEP8" ><option value=""></option> <? PROV_CbEP1("CbEP8",8); ?> </select></td><td></td><td><input name="TxtI8" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI8']; ?>"></td></tr>
<tr> <td height="18"  style="font-weight:bold">&nbsp; Valor total Trayectoria de la empresa</td><td>&nbsp;<input  name="TxtTotal" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo '&nbsp;'.$_SESSION['TxtTotal'];?>" style="width:35px;font-weight:bold"></td><td></td><td></td></tr>
</table>


<table width="900" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="450" height="3"  ></td>  <td width="90"></td><td width="10"></td><td width="350"></td></tr>
<tr><td height="18"  >&nbsp; Certificacion de seguridad/medio ambiente/calidad</td><td >&nbsp;<select name="CbEP9" style="width:35px"  class="campos" tabindex="3" id="CbEP9" ><option value=""></option> <? PROV_CbEP1("CbEP9",9); ?> </select></td><td></td><td><input name="TxtI9" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI9']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Registro de no conformidades de Seguridad, Ambiente y/o Calidad</td><td>&nbsp;<select name="CbEP10"  style="width:35px" class="campos" tabindex="3" id="CbEP10" ><option value=""></option> <? PROV_CbEP1("CbEP10",10); ?> </select></td><td></td><td><input name="TxtI10" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI10']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Auditorias de Seguridad, Ambiente y/o Calidad</td><td>&nbsp;<select name="CbEP11"  style="width:35px" class="campos" tabindex="3" id="CbEP11" ><option value=""></option> <? PROV_CbEP1("CbEP11",11); ?> </select></td><td></td><td><input name="TxtI11" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI11']; ?>"></td></tr>
<tr> <td height="18" >&nbsp; Evaluacion AA e IA e identificacion de peligros y Evaluacion de Riesgo</td><td>&nbsp;<select name="CbEP12"  style="width:35px" class="campos" tabindex="3" id="CbEP12" ><option value=""></option> <? PROV_CbEP1("CbEP12",12); ?> </select></td><td></td><td><input name="TxtI12" type="text"  class="TextBox" style="width:320px" maxlength="40"   value="<? echo $_SESSION['TxtI12']; ?>"></td></tr>
<tr> <td height="18" style="font-weight:bold">&nbsp; Valor total Sistema de Calidad</td><td>&nbsp;<input  name="TxtTotal2" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo '&nbsp;'.$_SESSION['TxtTotal2'];?>" style="width:35px;font-weight:bold"></td><td></td><td></td></tr>
</table>

<table width="900" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="450" height="3"  ></td>  <td width="90"></td><td width="100"></td><td width="260"></td></tr>
<tr> <td height="18" style="font-weight:bold">&nbsp; Calificacion final del proveedor</td><td>&nbsp;<input  name="TxtTotal3" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo '&nbsp;'.$_SESSION['TxtTotal3'];?>" style="width:35px;font-weight:bold;<? echo PROV_EPestilo($_SESSION['TxtTotal3'],1,0);?>"></td><td colspan="2"><input  name="TxtTexto" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtTexto'];?>" style="width:300px;font-weight:bold;border:none;<? echo PROV_EPestilo($_SESSION['TxtTotal3'],2,0);?>"></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtTexto2',0);GLO_Hidden('TxtApellido',0);
GLO_guardar("900",4,0); 
if( intval($_SESSION['TxtNumero'])!=0 ){GLO_exportarform(900,1,0,0,0,0);}
GLO_mensajeerror();
?>