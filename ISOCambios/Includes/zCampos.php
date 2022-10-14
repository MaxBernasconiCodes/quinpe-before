<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>
<? 
GLO_tituloypath(0,750,'','GESTION DE CAMBIOS','salir');
GLO_mensajeerrorE();
?>

<table width="750" border="0"  cellspacing="0"><tr> <td  class="encabezado">SECCION 1 SOLICITUD DEL CAMBIO</td></tr></table>
<table width="750" border="0"   cellspacing="0"  class="Tabla">
<tr><td width="110" height="1" ></td><td width="300" ></td><td width="100" ></td><td width="240" ></td></tr>
<tr> <td  align="right" height="18">Fecha:</td><td >&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?><label class="MuestraError"> * </label></td><td align="right">Numero:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td></tr>
<tr> <td  align="right" height="18">Solicita:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:260px" onKeyDown="enterxtab(event)" tabindex="1" ><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">Estado:</td><td >&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:200px" onKeyDown="enterxtab(event)" tabindex="1" ><option value=""></option><? CAM_ComboEstado('CbEstado'); ?></select></td></tr>
<tr> <td  align="right" height="18">Obra/Serv/Sector:</td><td>&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="1"  style="width:260px" maxlength="200"  value="<? echo $_SESSION['TxtNombre']; ?>" ><label class="MuestraError"> * </label></td><td align="right">Requerido para:</td><td >&nbsp;<input name="TxtReq" type="text" class="TextBox"   tabindex="1"  style="width:200px" maxlength="50"  value="<? echo $_SESSION['TxtReq']; ?>" ></td></tr>
<tr> <td  align="right" height="18">Razon:</td><td>&nbsp;<input name="TxtRazon" type="text" class="TextBox"   tabindex="1"  style="width:260px" maxlength="200"  value="<? echo $_SESSION['TxtRazon']; ?>" ></td><td align="right">Prioridad:</td><td >&nbsp;<select name="CbPrio" class="campos" id="CbPrio"  style="width:200px" onKeyDown="enterxtab(event)" tabindex="1" ><option value=""></option><? CAM_ComboPrioridad('CbPrio'); ?></select></td></tr>
<tr> <td  align="right" height="18" valign="top">Cambio:</td><td colspan="3">&nbsp;<textarea name="TxtObs" style="resize:none;width:600px" rows="2" class="TextBox" onkeypress="event.cancelBubble=true;" tabindex="1" ><? echo $_SESSION['TxtObs']; ?></textarea></td></tr>
</table>
<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="1"></td></tr></table>	
<?php if(intval($_SESSION['TxtNumero'])!=0){CAM_TablaTipo($_SESSION['TxtNumero'],$conn);} ?>


<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	
<table width="750" border="0"  cellspacing="0"><tr> <td  class="encabezado">SECCION 2 EVALUACION DEL CAMBIO</td></tr></table>
<table width="750" border="0"   cellspacing="0"  class="Tabla">
<tr><td width="110" height="1" ></td><td width="300" ></td><td width="100" ></td><td width="240" ></td></tr>
<tr> <td  align="right" height="18">Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFechaE","../Codigo/","actual",1) ?></td><td align="right"></td><td >&nbsp;</td></tr>
<tr> <td  align="right" height="18" valign="top">Impactos:</td><td colspan="3">&nbsp;<textarea name="TxtObs2" style="resize:none;width:600px" rows="2" class="TextBox" onkeypress="event.cancelBubble=true;" tabindex="1" ><? echo $_SESSION['TxtObs2']; ?></textarea></td></tr>
</table>
<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="1"></td></tr></table>	
<?php if(intval($_SESSION['TxtNumero'])!=0){CAM_TablaAsistentes($_SESSION['TxtNumero'],$conn);} ?>


<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	
<table width="750" border="0"  cellspacing="0"><tr> <td  class="encabezado">SECCION 3 RESOLUCION DE LA SOLICITUD DEL CAMBIO</td></tr></table>
<table width="750" border="0"   cellspacing="0"  class="Tabla">
<tr><td width="110" height="1" ></td><td width="300" ></td><td width="100" ></td><td width="240" ></td></tr>
<tr> <td  align="right" height="18">Estado Resol:</td><td>&nbsp;<select name="CbRes" class="campos" id="CbRes"  style="width:200px" onKeyDown="enterxtab(event)" tabindex="1" ><option value=""></option><? CAM_ComboResolucion('CbRes'); ?></select></td><td align="right">Fecha Resol:</td><td >&nbsp;<? GLO_calendario("TxtFechaR","../Codigo/","actual",1) ?></td></tr>
</table>
<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="1"></td></tr></table>	
<?php if(intval($_SESSION['TxtNumero'])!=0){CAM_TablaActividades($_SESSION['TxtNumero'],$conn);} ?>


<?
GLO_Hidden('TxtId',0);
GLO_botonesform("750",0,2); 
GLO_mensajeerror();
?>