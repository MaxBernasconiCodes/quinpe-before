<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>

<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<?php GLO_tituloypath(0,750,'../TOT.php','TARJETA DE OBSERVACION','linksalir'); ?>


<table width="750" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="100"></td><td width="250"></td><td width="10"></td> <td width="270"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>
  <label class="MuestraError"> * </label></td><td align="right"  ></td><td align="right" ></td></tr>
<tr> <td height="18"  align="right"  >Equipo:</td><td colspan="2">&nbsp;<select name="CbCentro"  tabindex="1"  class="campos" id="CbCentro"  style="width:300px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboEquipos("CbCentro","epparticulos",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right"></td><td><input name="Opt1"  class="check" type="checkbox"  value="1" <? if ($_SESSION['Opt1'] =='1') echo 'checked'; ?>> Pudo corregir el problema usted mismo</td></tr>
<tr> <td height="18"  align="right"  >Cliente:</td><td colspan="2">&nbsp;<select name="CbCliente"  tabindex="1"  class="campos" id="CbCliente"  style="width:300px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right"></td><td><input name="Opt2"  class="check" type="checkbox"  value="1" <? if ($_SESSION['Opt2'] =='1') echo 'checked'; ?>> Se aplico autoridad detencion de trabajo</td></tr>
<tr> <td height="18"  align="right"  >Sector:</td><td colspan="2">&nbsp;<select name="CbSector"  tabindex="1"  style="width:300px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td align="right"></td>  <td><input name="Opt3"  class="check" type="checkbox"  value="1" <? if ($_SESSION['Opt3'] =='1') echo 'checked'; ?>> Cerrado </td></tr>
</table>


<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="630"></td></tr>
<tr> <td height="18"  align="right"  >Resp.Deteccion:</td><td>&nbsp;<select name="CbPersonal"   tabindex="1"  style="width:400px" class="campos"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn);  ?></select></td></tr>
<tr> <td height="18"  align="right"  >Resp.Seguimiento:</td><td>&nbsp;<select name="CbPersonal2"   tabindex="1"  style="width:400px" class="campos"><option value=""></option><? ComboPersonalRFX("CbPersonal2",$conn);  ?></select></td></tr>
</table>


<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="630"></td></tr>
<tr> <td height="18"  align="right"  >Categoria:</td><td>&nbsp;<select name="CbCateg"   tabindex="1"  style="width:600px" class="campos"><option value=""></option><? ComboTablaRFX("totcat","CbCateg","Nombre","","",$conn);  ?></select></td></tr>
</table>



<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="630"></td></tr>
<tr> <td height="18"  align="right"  >Situacion Detectada:</td><td>&nbsp;<input name="TxtObs3" type="text"  class="TextBox" style="width:600px" maxlength="200"  tabindex="1"  value="<? echo $_SESSION['TxtObs3']; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Consecuencia:</td><td>&nbsp;<input name="TxtObs4" type="text"  class="TextBox" style="width:600px" maxlength="100"  tabindex="1"  value="<? echo $_SESSION['TxtObs4']; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Accion Corr/Prev:</td><td>&nbsp;<input name="TxtObs5" type="text"  class="TextBox" style="width:600px" maxlength="200"  tabindex="1"  value="<? echo $_SESSION['TxtObs5']; ?>"></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_botonesform("750",0,2);
GLO_mensajeerror(); 
?>	