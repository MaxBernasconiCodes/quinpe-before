<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

GLO_tituloypath(0,600,'','PRUEBAS','salir');
?>


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Metodo:</td><td  valign="top" >&nbsp;<select name="CbMetodo"  tabindex="1"  class="campos" id="CbMetodo"  style="width:400px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("metodos","CbMetodo","Nombre","","",$conn); ?></select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad"  tabindex="1"  class="campos" id="CbUnidad"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("metodosunidades","CbUnidad","Nombre","","",$conn); ?></select></td></tr>
<tr><td height="18"  align="right"  >Resultado:</td><td  valign="top" >&nbsp;<input name="TxtRes" type="text"  class="TextBox"  maxlength="14"  value="<? echo $_SESSION['TxtRes']; ?>" tabindex="1"  style="width:100px" onChange="this.value=validarNumero(this.value);"></td></tr>
<tr><td height="18"  align="right"  >Valor Ref.:</td><td  valign="top" >&nbsp;<input name="TxtVal" type="text"  class="TextBox"  maxlength="20"  value="<? echo $_SESSION['TxtVal']; ?>" tabindex="1"  style="width:100px"></td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>