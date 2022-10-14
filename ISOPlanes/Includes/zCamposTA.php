<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,700,'','TAREA','salir'); 

?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr ><td height="18"  align="right" valign="top" >Observaciones:</td><td  valign="top" >&nbsp;<textarea name="TxtObs" style="width:550px" rows="2" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea><label class="MuestraError" style="vertical-align:top"> * </label></td></tr>
<tr><td height="18"  align="right"  >Tarea:</td><td  valign="top" >&nbsp;<input name="TxtNombre" tabindex="1" type="text" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" ><label class="MuestraError"> * </label></td></tr>
</table>

<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	                    

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Lugar:</td><td  valign="top" >&nbsp;<select name="CbYac"  tabindex="1" style="width:250px" class="campos" id="CbYac" ><option value=""></option> <? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?> </select> </td></tr>
<tr><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<select name="CbEstado"  tabindex="1" style="width:250px;<? PL_ColorEstadoC(intval($_SESSION['CbEstado']))?>" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("plan_e","CbEstado","Orden","","",$conn); ?> </select> </td></tr>
<tr><td height="18"  align="right"  >Prioridad:</td><td  valign="top" ><input name="OptTipo"  type="radio" tabindex="2" class="radiob"    value="1"<? if ($_SESSION['OptTipo'] ==1) echo 'checked'; ?> >Alta   &nbsp;&nbsp;&nbsp;<input name="OptTipo" tabindex="2" type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipo'] ==2) echo 'checked'; ?> >Media &nbsp;&nbsp;&nbsp;<input name="OptTipo" tabindex="2" type="radio"  class="radiob"   value="3"<? if ($_SESSION['OptTipo'] ==3) echo 'checked'; ?> >Baja </td></tr>
</table>

<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	                    

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="250"></td><td width="100"></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >Inicio Prog:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFecha1","../Codigo/","actual",2) ?><label class="MuestraError"> * </label></td>
<td align="right"  >Inicio Real:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFecha3","../Codigo/","actual",3) ?></td></tr>
<tr><td height="18"  align="right"  >Final Prog:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFecha2","../Codigo/","actual",2) ?></td><td align="right"  >Final Real:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFecha4","../Codigo/","actual",3) ?></td></tr>
</table>



<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtId',0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
?>