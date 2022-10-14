<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,700,'','REQUERIMIENTO','salir'); 
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"></td> <td width="250"></td><td width="100" ></td> <td width="250"></td> </tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?></td>
<td height="18"  align="right"  >Urgencia:</td><td  valign="top" >&nbsp;<select name="CbUrg" tabindex="2"  style="width:70px" class="campos" id="CbUrg" > <? ComboPRQUrg("CbUrg",$conn); ?> </select></td></tr>
<tr > <td height="18"  align="right"  valign="top" >Observaciones:</td><td  valign="top"  colspan="3">&nbsp;<textarea  name="TxtObs" style="width:560;" rows="4" class="TextBox"  tabindex="3" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea><label class="MuestraError"   style="vertical-align:top" > * </label></td></tr>
</table>

<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdOrden',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform(700,0,2);
GLO_mensajeerror(); 
?>