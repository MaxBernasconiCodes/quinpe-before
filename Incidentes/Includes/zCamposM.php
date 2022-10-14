<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,700,'','MEDIDA CORRECTIVA/PREVENTIVA','salir'); 
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right" valign="top" >Medida:</td><td  valign="top" >&nbsp;<textarea name="TxtNombre" style="width:550px" rows="3" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtNombre']; ?></textarea> <label class="MuestraError"  style=" vertical-align:top"> * </label></td></tr>
</table>


<table width="700" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Responsable:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:400px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> </td></tr>
<tr><td height="18"  align="right"  >Cumplimiento:</td><td  valign="top" >&nbsp;<?php GLO_calendario("TxtFecha1","../Codigo/","actual",1); ?></td></tr>
</table>

<table width="700" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Verificado por:</td><td  valign="top" >&nbsp;<select name="CbPersonal2" class="campos" id="CbPersonal2"  style="width:400px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal2',$conn); ?></select></td></tr>
<tr><td height="18"  align="right"  >Verificacion:</td><td  valign="top" >&nbsp;<?php GLO_calendario("TxtFecha2","../Codigo/","actual",1); ?></td></tr>
</table>


<table width="700" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<input name="OptE"  type="radio"  class="radiob"    value="0"<? if ($_SESSION['OptE'] ==0){ echo 'checked';} ?> >Pendiente &nbsp;&nbsp;&nbsp;<input name="OptE"  type="radio"  class="radiob"   value="1"<? if ($_SESSION['OptE'] ==1) {echo 'checked';} ?>  >Realizada &nbsp;&nbsp;&nbsp;<input name="OptE"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptE'] ==2) {echo 'checked';} ?>  >Cancelada</td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("700",1,0); 
GLO_mensajeerror();
?>