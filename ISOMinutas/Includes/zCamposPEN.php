<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(950,700,'sgi','PENDIENTES MINUTA','salir'); 
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right" valign="top" >Actividad:</td><td  valign="top" >&nbsp;<textarea name="TxtObs" style="width:550px" rows="7" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea> <label class="MuestraError"> * </label></td></tr>
</table>

<table width="700" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Responsable:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:450px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> </td></tr>
<tr><td height="18"  align="right"  >Otro:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()"> </td></tr>
</table>

<table width="700" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<input name="OptE"  type="radio"  class="radiob"    value="0"<? if ($_SESSION['OptE'] ==0){ echo 'checked';} ?> >Pendiente &nbsp;&nbsp;&nbsp;<input name="OptE"  type="radio"  class="radiob"   value="1"<? if ($_SESSION['OptE'] ==1) {echo 'checked';} ?>  >Realizada &nbsp;&nbsp;&nbsp;<input name="OptE"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptE'] ==2) {echo 'checked';} ?>  >Cancelada</td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
?>