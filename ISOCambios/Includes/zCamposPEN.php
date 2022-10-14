<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>

<? GLO_tituloypath(950,700,'sgi','PLAN DE ACCION','salir'); ?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top" >&nbsp;<input name="TxtFecha" id="TxtFecha"  type="text" class="TextBox"  style="width:60px" maxlength="10"   tabindex="1"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFecha","../Codigo/","actual") ?></td></tr>
<tr><td height="18"  align="right" valign="top" >Actividad:</td><td  valign="top" >&nbsp;<textarea name="TxtNombre" style="resize:none;width:550px" rows="3" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtNombre']; ?></textarea> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Responsable:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:450px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> </td></tr>
<tr><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<input name="OptE"  type="radio"  class="radiob"    value="0"<? if ($_SESSION['OptE'] ==0){ echo 'checked';} ?> >Pendiente   <input name="OptE"  type="radio"  class="radiob"   value="1"<? if ($_SESSION['OptE'] ==1) {echo 'checked';} ?>  >Realizada </td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
?>