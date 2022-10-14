<? 
//perfiles
GLO_PerfilAcceso(10);

GLO_tituloypath(0,500,'../Turnos.php','TURNOS','linksalir');
?>

<table width="500" border="0"  cellspacing="0" class="Tabla">
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input  name="TxtNombre" type="text" class="TextBox" style="width:300px" maxlength="30"  tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" <? GLO_keypress(0);?>> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Horas:</td><td  valign="top" >&nbsp;<input name="TxtHs" type="text"  tabindex="1" class="TextBox"  maxlength="6"  style="width:50px" value="<? echo $_SESSION['TxtHs']; ?>"  onchange="this.value=validarNumero(this.value);"></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLOF_botonesform(500,0,0,2,0);
GLO_mensajeerror();
?>